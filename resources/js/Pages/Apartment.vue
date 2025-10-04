<template>
    <AppLayout>
        <Head :title="`${floor.name} - ${building.name}`" />
        <div class="large-pad pt-4 pad-bottom position-relative">
            <div class="row">
                <div class="col-xl-11 offset-xl-1">
                    <Link :href="route('floor.show', { 'building': building.slug, 'floor': floor.slug })" class="btn btn-arrow btn-arrow-prev btn-teal snipped mb-5 d-inline-block">
                        <span>Înapoi la selecție apartament</span>
                    </Link>
                </div>
            </div>
            <div class="row gx-5">
                <div class="col-lg-6 col-xxl-6 offset-xxl-1 mb-5">
                    <h2 class="tk-obvia fw-medium">{{ apartment.title }}</h2>
                    <p class="mb-2">
                        <Link :href="route('building.show', building.slug)" class="text-uppercase text-teal fs-6">{{ building.name }}</Link>
                        <span class="d-inline-block mx-3">/</span>
                        <Link :href="route('floor.show', { 'building': building.slug, 'floor': floor.slug })" class="text-teal fs-6">{{ floor.name }}</Link>
                        <span class="d-inline-block mx-3">/</span>
                        <strong class="fs-6">Ap. {{ apartment.number }}</strong>
                    </p>
                    <p class="small">Tip {{ apartment.type_name }}</p>
                    <div class="mt-5">
                        <swiper-container
                            class="swiper"
                            :spaceBetween="0"
                            :loop="true"
                            :speed="800"
                            :autoplay="{
                                delay: 8000,
                                disableOnInteraction: true,
                                pauseOnMouseEnter: true,
                            }"
                            :lazy="true">
                            <swiper-slide v-for="(image, i) in apartment.images" :key="image.id" class="swiper-slide">
                                <img
                                    :src="image.width_560_url"
                                    :srcset="
                                        `${image.width_320_url} 320w,
                                        ${image.width_560_url} 560w,
                                        ${image.url} 2560w,`"
                                    sizes="
                                        (max-width: 560px) 560px,
                                        2560px"
                                    :alt="`Sema Home interior rendering ${image.title}`"
                                    class="img-fluid"
                                    loading="lazy"
                                    @click="openLightbox(lightboxItems[i])"
                                />
                            </swiper-slide>
                        </swiper-container>
                        <div class="swiper-lazy-preloader"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-4 d-flex flex-column mb-5">
                    <div class="row mb-5">
                        <div class="col-sm-6 col-md-3 offset-md-3 col-lg offset-lg-0 mb-5 mb-sm-0">
                            <h3 class="text-teal mb-2 tk-obvia fw-semibold fs-2">{{ parseInt(apartment.room_count) === 1 ? '1 cameră' : parseInt(apartment.room_count) + ' camere' }}</h3>
                            <p class="mb-0 small">Nr. băi: <span class="fw-bold">{{ apartment.bathroom_count }}</span></p>
                            <p class="mb-0 small" v-if="apartment.balcony_count">{{ apartment.balcony_count === 1 ? 'Balcon: ' : apartment.balcony_count + ' balcoane: ' }} <span class="fw-bold">{{ apartment.balcony_size_sqm }}</span> m<sup>2</sup></p>
                            <p class="mb-0 small" v-if="apartment.terrace_count">{{ apartment.terrace_count === 1 ? 'Terasă: ' : apartment.terrace_count + ' terase: ' }} <span class="fw-bold">{{ apartment.terrace_size_sqm }}</span> m<sup>2</sup></p>
                            <p class="mb-0 small" v-if="apartment.garden_size_sqm">Grădină: <span class="fw-bold">{{ apartment.garden_size_sqm }}</span> m<sup>2</sup></p>
                        </div>
                        <div class="col-sm-6 col-lg-auto text-start">
                            <p class="mb-1 small lh-sm ">Suprafață utilă</p>
                            <p class="tk-obvia mb-2">
                                <span class="text-xl fw-bold">{{ apartment.usable_size_sqm }}</span>
                                <span class="fw-medium text-l text-teal">m<sup>2</sup></span>
                            </p>
                            <p class="mb-0 fs-6 fw-bold">Suprafață totală: <span class="text-teal">{{ apartment.total_size_sqm }}</span> m<sup>2</sup></p>
                        </div>
                    </div>
                    <div v-if="apartment.description" v-html="formattedDescription" class="mb-4 desc"></div>
                    <p class="mb-0 fs-6">Orientare: <span class="fw-bold">{{ apartment.orientation }}</span></p>
                    <p class="mb-0 fs-6">Clasă de eficiență energetică: <span class="fw-bold">{{ apartment.energy_efficiency_class }}</span></p>
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center w-100 mt-5">
                        <p class="mb-5 mb-sm-0 text-m tk-obvia fw-semibold">Preț la cerere</p>
                        <a href="#" class="btn btn-arrow btn-teal tk-obvia snipped ms-auto me-auto me-sm-0 text-uppercase">Cere ofertă</a>
                    </div>
                </div>
            </div>
            <div class="row gx-5">
                <div class="col-xxl-10 offset-xxl-1">
                    <div class="row gx-5">
                        <div v-if="apartment.utility_values?.length" class="col-md-6 col-lg-4 col-xxl-3 mb-5 mb-md-0">
                            <h4 class="text-teal mb-4 tk-obvia fw-semibold fs-">Utilități</h4>
                            <ul class="ap-details-list mb-0">
                                <li v-for="(value, index) in apartment.utility_values" :key="index">{{ value }}</li>
                            </ul>
                        </div>
                        <div v-if="apartment.facility_values?.length" class="col-md-6 col-lg-4 col-xxl-3">
                            <h4 class="text-teal mb-4 tk-obvia fw-semibold fs-">Dotări</h4>
                            <ul class="ap-details-list mb-0">
                                <li v-for="(value, index) in apartment.facility_values" :key="index">{{ value }}</li>
                            </ul>
                        </div>
                        <div class="col-auto ms-auto d-flex flex-column justify-content-center mt-4 mt-lg-0"
                            :class="!(apartment.utility_values?.length || apartment.facility_values?.length) ? 'me-auto align-items-center' : 'me-auto me-lg-0 align-items-center align-items-lg-start'"
                        >
                            <h4 class="mb-3 tk-obvia fw-semibold fs-5 text-center">Distribuie prin:</h4>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-link p-0 me-3" @click="shareWhatsApp" title="Trimite prin WhatsApp">
                                    <img src="/images/icon_share_whatsapp.svg" class="img-fluid" alt="WhatsApp">
                                </button>
                                <button type="button" class="btn btn-link p-0 me-3" @click="shareTelegram" title="Trimite prin Telegram">
                                    <img src="/images/icon_share_telegram.svg" class="img-fluid" alt="Telegram">
                                </button>
                                <button type="button" class="btn btn-link p-0 me-3" @click="shareMessenger" title="Trimite prin Facebook Messenger">
                                    <img src="/images/icon_share_messenger.svg" class="img-fluid" alt="Messenger">
                                </button>
                                <button type="button" class="btn btn-link p-0 me-3" @click="shareEmail" title="Trimite prin Email">
                                    <img src="/images/icon_share_email.svg" class="img-fluid" alt="Email">
                                </button>
                                <button type="button" class="btn btn-link p-0" @click="copyLink" title="Copiază link">
                                    <img src="/images/icon_share_link.svg" class="img-fluid" alt="Copiază link">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-5 mt-5">
                <div class="col-auto mx-auto text-center">
                    <p class="mb-5">
                        <strong>Solicită o ofertă personalizată,</strong><br />
                        iar unul dintre consultanții noștri îți va răspunde în cel mai scurt timp.
                    </p>
                    <a href="#" class="btn btn-arrow btn-teal tk-obvia snipped text-uppercase">Cere ofertă</a>
                </div>
            </div>
        </div>
        <Teleport to="body">
            <silent-box
                ref="silentbox"
                :gallery="lightboxItems"
                :lazy-loading="true"
                :preview-count="lightboxItems.length"
                class="silentbox-hidden-activators">
            </silent-box>
        </Teleport>
        <div class="bg-teal text-white" :class="['copy-toast', copySuccess ? 'show' : '']" role="status" aria-live="polite">
            <span class="check">✓</span> Link copiat
        </div>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { register } from 'swiper/element/bundle';

    register();

    const props = defineProps({
        building: Object,
        floor: Object,
        apartment: Object,
    });

    // computed-like helper: escape HTML and convert newlines to <br>
    import { computed } from 'vue';
    import { ref } from 'vue';

    const formattedDescription = computed(() => {
        const text = props.apartment?.description || '';
        // Basic HTML-escape
        const escaped = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
        // Convert CRLF and LF to <br>
        return escaped.replace(/\r\n|\r|\n/g, '<br>');
    });

    const lightboxItems = computed(() => {
        return props.apartment?.images?.map(image => ({
            src: image.url,
            srcSet: [`${image.width_320_url} 320w`, `${image.width_560_url} 560w`, `${image.url} 2560w`],
            description: image.title || '',
        })) || [];
    });

    const silentbox = ref(null);
    const openLightbox = (item, index = 0) => {
        silentbox.value.openOverlay(item, index)
    }

    // Share URLs and helpers
    const pageUrl = computed(() => {
        // Prefer canonical URL if provided in props, otherwise build from window
        const canonical = props.apartment?.friendly_id ? `${route('apartment.show', { building: props.building.slug, floor: props.floor.slug, apartment: props.apartment.friendly_id })}` : window.location.href;
        return canonical;
    });

    const shareText = computed(() => `${props.apartment?.title || ''} - ${props.building?.name || ''} ${pageUrl.value}`);

    function openUrl(url) {
        window.open(url, '_blank', 'noopener,noreferrer');
    }

    function shareEmail() {
        const subject = encodeURIComponent(props.apartment?.title || 'Apartament');
        const body = encodeURIComponent(shareText.value);
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    }

    function shareWhatsApp() {
        const text = encodeURIComponent(shareText.value);
        openUrl(`https://api.whatsapp.com/send?text=${text}`);
    }

    function shareTelegram() {
        const text = encodeURIComponent(shareText.value);
        openUrl(`https://t.me/share/url?url=${encodeURIComponent(pageUrl.value)}&text=${text}`);
    }

    function shareMessenger() {
        // Uses the Facebook sharer with the messenger parameter; note: deep integration requires FB SDK
        openUrl(`fb-messenger://share?link=${encodeURIComponent(pageUrl.value)}`);
    }

    const copySuccess = ref(false);

    async function copyLink() {
        try {
            await navigator.clipboard.writeText(pageUrl.value);
            copySuccess.value = true;
            setTimeout(() => (copySuccess.value = false), 2500);
        } catch (e) {
            // fallback for older browsers
            const input = document.createElement('input');
            input.value = pageUrl.value;
            document.body.appendChild(input);
            input.select();
            try {
                document.execCommand('copy');
                copySuccess.value = true;
                setTimeout(() => (copySuccess.value = false), 2500);
            } finally {
                document.body.removeChild(input);
            }
        }
    }
</script>

<style scoped>
h2 { line-height: 1.125; }
.text-xl { font-size: 4rem; line-height: 1; }
.desc { line-height: 1.75; }

/* Toast for copy link */
.copy-toast {
    position: fixed;
    right: 20px;
    bottom: 20px;
    padding: 10px 14px;
    border-radius: 6px;
    box-shadow: 0 6px 18px rgba(13,110,253,0.18);
    z-index: 1050;
    transform: translateY(10px);
    opacity: 0;
    transition: opacity 180ms ease, transform 180ms ease;
}
.copy-toast.show {
    transform: translateY(0);
    opacity: 1;
}

.copy-toast .check {
    display: inline-block;
    margin-right: 8px;
    font-weight: 700;
}

@media (max-width: 575px) {
    h2 { font-size: 1.75rem; }    
}
</style>