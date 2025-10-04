<template>
    <AppLayout>
        <Head title="Home" />

        <BuildingScene :building="building" :selectedRooms="selectedRooms" />

        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-5 my-xl-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 col-sm-7 col-lg-5">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Despre <span class="text-teal"><br>Sema Home</span></h2>
                    </div>
                    <div class="col-5 offset-2 col-sm-3 offset-sm-0 col-lg-5 text-sm-end mb-5 mb-sm-0">
                        <a href="https://semaparc.ro/" target="_blank" rel="noopener noreferrer" class="highlight-on-hover">
                            <img src="/images/part_of_sema_parc.svg" class="img-fluid" alt="part of Sema Parc">
                        </a>
                    </div>
                </div>
                <div class="row gx-5 mb-5">
                    <div class="col-10 offset-2 col-lg-5 offset-lg-1 mb-3 mb-md-5 mb-xl-0 d-flex flex-column align-items-start">
                        <h3 class="text-l mb-4 mb-md-5">
                            <span class="d-block mb-2">Trăiește dincolo de așteptări.</span>
                            <span class="d-block">Alegerea firească în orașul tău</span>
                        </h3>
                        <p class="mb-5">La Sema Home, fiecare zi înseamnă mai mult decât o simplă locuință. E locul unde siguranța, confortul și armonia se întâlnesc pentru a-ți crea un stil de viață la care ai visat dintotdeauna.</p>
                        <Link :href="route('project')" class="btn btn-arrow btn-teal d-flex align-items-center justify-content-start tk-obvia snipped">Despre proiect</Link>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-0 z-2 image-overlap">
                        <img
                            src="/images/building_image-737.webp"
                            srcset="
                                /images/building_image-480.webp 480w,
                                /images/building_image-737.webp 737w"
                            sizes="(max-width: 767px) 100vw,
                                (max-width: 991px) 605px,
                                (max-width: 1199px) 447px,
                                (max-width: 1399px) 473px,
                                655px"
                            class="img-fluid w-100 snipped"
                            alt="Sema Home night scene rendering"
                            data-speed="1.1"
                        />
                    </div>
                    
                </div>
                <div class="bg-dark-blue snipped position-relative margin-bottom-large pb-5">
                    <div class="row gx-5">
                        <div class="col-xl-5 offset-xl-1 mt-md-3 mt-lg-5 px-5 px-xl-0">
                            <h2 class="my-5 tk-obvia">Sema Home<br> Faza 1</h2>
                            <p class="my-5">Prima fază a proiectului aduce un imobil modern cu regim 2SP11, ce va găzdui 301 apartamente și 390 de locuri de parcare. Toate locuințele sunt gândite pentru confortul de zi cu zi, oferind spații de depozitare, design contemporan și un nivel ridicat de eficiență energetică.</p>
                            <p class="mb-5">Tipologiile sunt variate - de la apartamente practice cu o cameră, la apartamente cu 2, 3 sau 4 camere – pentru a răspunde perfect fiecărui stil de viață. Fiecare unitate este dotată cu tehnologii inteligente, iar materialele folosite vor respecta cele mai înalte standarde de calitate și sustenabilitate</p>
                            <p class="mb-3 mb-lg-4">Locatarii vor avea acces la facilități comune de înaltă calitate, inclusiv spații verzi și zone de relaxare, precum și la zonele de alimentație publică și servicii din cadrul Sema Parc.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 mt-5">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-sm-6 px-5 pe-sm-0 ps-xl-0 mb-5 mb-xl-0">
                                            <p class="text-xl d-block mb-0 tk-obvia fw-semibold">301</p>
                                            <p class="text-l tk-obvia fw-semibold">Apartamente cu<br>1/2/3/4 camere</p>
                                        </div>
                                        <div class="col-sm-6 px-5 pe-sm-0 ps-xl-0 mb-5 mb-xl-0">
                                            <p class="text-xl d-block mb-0 tk-obvia fw-semibold">390</p>
                                            <p class="text-l tk-obvia fw-semibold">Locuri de parcare</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 offset-xl-1 mb-5 mb-sm-0 mb-lg-4 mb-xl-5">
                                    <div class="row">
                                        <div class="col-sm-6 d-flex flex-column align-items-start px-5 pe-sm-0 ps-xl-0 mb-5">
                                            <div class="d-flex align-items-center mb-5">
                                                <img src="/images/icon_green_spaces.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Spații verzi</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/icon_tech.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Tehnologii<br> avansate</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-flex flex-column align-items-start px-5 pe-sm-0 ps-xl-0">
                                            <div class="d-flex align-items-center mb-5">
                                                <img src="/images/icon_fabrics.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Materiale la cele<br> mai înalte standarde</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/icon_sustainable.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Soluții<br> Sustenabile</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 offset-1 d-flex justify-content-center align-items-center">
                            <Link :href="route('project')" class="btn btn-arrow btn-teal d-flex align-items-center tk-obvia snipped">Vezi detalii</Link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-lg-1 d-flex justify-content-start">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 col-lg-6 col-xl-5 mb-5 d-flex flex-column align-items-start">
                        <h2 class="mb-4 mb-lg-5 tk-obvia text-teal"><span class="text-black">Sema Home<br></span> Faza 2</h2>
                        <p class="mb-4 mb-lg-5">Proiectul va continua cu construcția a încă doua blocuri 2SP11, completand proiectul cu alte 394 de apartamente si 516 locuri de parcare. Această etapă va aduce un plus de diversitate în tipologia locuințelor îmbunătățind infrastructura zonei.</p>
                        <p class="mb-5">Se va pune un accent deosebit pe integrarea armonioasă a noilor clădiri în peisajul existent al parcului existent, oferind un mediu plăcut și funcțional atât pentru cei care locuiesc acolo, cât și pentru cei care lucrează în apropiere.</p>
                        <Link :href="route('location')" class="btn btn-icon btn-teal d-flex align-items-center tk-obvia snipped" alt="">
                            <img src="/images/icon_location.svg" class="img-fluid" alt="">
                            <span class="text-nowrap">Vezi localizare</span>
                        </Link>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-4 offset-lg-1 col-xl-4 offset-xl-1">
                        <img
                            src="/images/building_image_2-737.webp"
                            srcset="
                                /images/building_image_2-480.webp 480w,
                                /images/building_image_2-737.webp 737w"
                            sizes="(max-width: 767px) 100vw,
                                (max-width: 991px) 605px,
                                (max-width: 1199px) 447px,
                                (max-width: 1399px) 473px,
                                655px"
                            alt="Sema Home daytime scene rendering with jogger"
                            class="img-fluid snipped mt-xl-5 w-100"
                            data-speed="1.15"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-home position-relative margin-top mb-4 mx-auto">
            <swiper-container
                class="swiper"
                :slidesPerView="1"
                :spaceBetween="0"
                :loop="true"
                :speed="800"
                :grabCursor="true"
                :autoplay="true"
                :navigation="{
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }"
                :pagination="{
                    el: '.swiper-pagination',
                    clickable: true,
                }"
                :breakpoints="{
                    992: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                }">
                <swiper-slide v-for="n in 8" :key="n" class="swiper-slide">
                    <img
                        :src="`/images/home_swiper_${n}-600.webp`"
                        :srcset="
                            `/images/home_swiper_${n}-480.webp 480w,
                            /images/home_swiper_${n}-600.webp 600w`"
                        sizes="100vw"
                        :alt="`Sema Home interior rendering ${n}`"
                        class="snipped"
                        @click="openLightbox(lightboxItems[n - 1])"
                    />
                    <img src="/images/open_gallery.svg" class="img-fluid position-absolute start-50 bottom-0 translate-middle icon" alt="View larger" />
                </swiper-slide>

            </swiper-container>
            <div class="swiper-pagination"><!-- --></div>
            <div class="swiper-button-prev"><!-- --></div>
            <div class="swiper-button-next"><!-- --></div>
        </div>

    <div class="d-flex justify-content-center margin-bottom-large">
        <button class="btn btn-icon btn-teal d-flex align-items-center tk-obvia snipped" alt="" @click="openLightbox(lightboxItems[0], 0)">
            <img src="/images/icon_click.svg" class="img-fluid" alt="">
            <span class="text-nowrap text-uppercase">Vezi galeria</span>
        </button>
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

    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { register } from 'swiper/element/bundle';
import AppLayout from '@/Layouts/AppLayout.vue';
import BuildingScene from '@/Components/BuildingScene.vue';
import TitleDecoration from '@/Components/TitleDecoration.vue';

const props = defineProps({
    building: [Object, null],
    selectedRooms: { type: [String, Number], default: 'toate' },
});

register();

const lightboxItems = computed(() => {
    const items = [];
    for (let i = 1; i <= 8; i++) {
        items.push({
            src: `/images/home_swiper_${i}-2048.webp`,
        });
    }
    return items;
});
const silentbox = ref(null);
const openLightbox = (item, index = 0) => {
    silentbox.value.openOverlay(item, index)
}

</script>

<style scoped>
.slider-home {
    width: 100%;
    max-width: 1700px;
}

.slider-home .swiper {
    padding-top: 4rem;
    padding-bottom: 6rem;
}

.slider-home .swiper-slide {
    transform: translateZ(0) scale(.6) !important;
    transition: all 0.3s ease-in-out;
    height: 23vw;
    max-height: 390px;
    overflow: hidden;
}

.slider-home .swiper-slide img:not(.icon) {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

img.icon {
    opacity: 0;
    transition: all 0.3s ease-in-out;
}

.slider-home .swiper-slide-next + .swiper-slide img.icon {
    opacity: 1;
}

.slider-home .swiper-slide-active {
    transform: translateZ(0) scale(.6) translateX(-33.33%) !important;
}

.slider-home .swiper-slide-next  {
    transform: translateZ(0) scale(.8) translateX(-48.5%)  !important;
}

.slider-home .swiper-slide-next + .swiper-slide {
    transform: translateZ(0) scale(1) translateX(-21.5%) !important;
    width: 35% !important;
}

.slider-home .swiper-slide-next + .swiper-slide + .swiper-slide {
    transform: translateZ(0) scale(.8) translateX(-45%)  !important;
}

.slider-home .swiper-slide-next + .swiper-slide + .swiper-slide + .swiper-slide {
    transform: translateZ(0) scale(.6) translateX(-92%) !important;
}

.slider-home .swiper-button-prev {
    left: calc(50% - 3rem);
}

.slider-home .swiper-button-next {
    right: calc(50% - 3rem);
}

.slider-home .swiper-horizontal>.swiper-pagination-bullets,
.slider-home .swiper-pagination-bullets.swiper-pagination-horizontal,
.slider-home .swiper-pagination-custom,
.slider-home .swiper-pagination-fraction {
    bottom: auto;
    top: 1.25rem;
}

@media (max-width: 991px) {
    .slider-home .swiper-slide {
        transform: translateZ(0) scale(.8) !important;
    }

    img.icon {
        width: 2rem;
    }

    .slider-home .swiper-slide-next + .swiper-slide img.icon {
        opacity: 0;
    }

    .slider-home .swiper-slide-next img.icon {
        opacity: 1;
    }

    .slider-home .swiper-slide-active {
        transform: translateZ(0) scale(.8) translateX(-12.4%) !important;
    }

    .slider-home .swiper-slide-next  {
        transform: translateZ(0) scale(1) translateX(-8%)  !important;
        width: 40% !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide {
        transform: translateZ(0) scale(.8) translateX(-12.4%) !important;
        width: 33.33% !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide + .swiper-slide {
        transform: translateZ(0) scale(.8) translateX(0)  !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide + .swiper-slide + .swiper-slide {
        transform: translateZ(0) scale(.8) translateX(0) !important;
    }
}

@media (max-width: 767px) {
    .slider-home .swiper-slide {
        transform: translateZ(0) scale(.9) !important;
        height: auto;
        max-height: none;
    }

    img.icon {
        width: 1.5rem;
    }

    .slider-home .swiper-slide-next img.icon {
        opacity: 0;
    }

    .slider-home .swiper-slide-active img.icon {
        opacity: 1;
    }

    .slider-home .swiper-slide-prev {
        transform: translateZ(0) scale(.9) translateX(12.5%) !important;
    }

    .slider-home .swiper-slide-active {
        transform: translateZ(0) scale(1) translateX(12.5%) !important;
        width: 80% !important;
    }

    .slider-home .swiper-slide-next  {
        transform: translateZ(0) scale(.9) translateX(10%)  !important;
        width: 100% !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide {
        transform: translateZ(0) scale(.9) translateX(0) !important;
        width: 100% !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide + .swiper-slide {
        transform: translateZ(0) scale(.9) translateX(0)  !important;
    }

    .slider-home .swiper-slide-next + .swiper-slide + .swiper-slide + .swiper-slide {
        transform: translateZ(0) scale(.9) translateX(0) !important;
    }
}
</style>