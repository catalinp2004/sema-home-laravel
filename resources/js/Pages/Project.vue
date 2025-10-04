<template>
    <AppLayout>
        <Head title="Project" />
        <img
            src="/images/hero_about-2560.webp"
            srcset="
                /images/hero_about-480.webp 480w,
                /images/hero_about-768.webp 768w,
                /images/hero_about-1024.webp 1024w,
                /images/hero_about-1440.webp 1440w,
                /images/hero_about-1920.webp 1920w,
                /images/hero_about-2560.webp 2560w"
            sizes="100vw"
            alt="Sema Home interior rendering"
            class="w-100 h-auto"
        />
        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-5 my-xl-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 col-md-9 col-lg-5 mb-4 mb-lg-0">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Primul proiect rezidențial <br class="d-none d-xl-inline" />parte integrantă din <span class="text-teal"><br class="d-none d-xl-inline" />Sema Parc</span></h2>
                        <p>Totul a pornit dintr-o viziune: transformarea fostei platforme industriale Semănătoarea într-un reper al Bucureștiului modern. Masterplanul Sema Parc conturează un ansamblu urban complex, ce reunește componente deja realizate sau aflate în dezvoltare — clădiri de birouri clasa A, locuințe moderne, restaurante, supermarket și zone de entertainment — alături de funcțiuni ce vor fi adăugate în etapele viitoare: zone de promenadă, spații de retail, terase, hotel, precum și facilități administrative și educaționale. Un ansamblu conceput să îmbine dinamica vieții urbane cu liniștea și confortul pe care le meriți.</p>
                        <p>Sema Home este primul proiect rezidențial al Sema Real Estate și va fi realizat în mai multe faze, fiecare etapă având o dezvoltare progresivă și un impact semnificativ asupra comunității locale.</p>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-2 col-md-9 offset-md-2 col-lg-5 offset-lg-0">
                        <img
                            src="/images/sema_home_interior_courtyard-737.webp"
                            srcset="
                                /images/sema_home_interior_courtyard-480.webp 480w,
                                /images/sema_home_interior_courtyard-737.webp 737w"
                            sizes="100vw"
                            alt="Sema Home interior courtyard rendering"
                            class="img-fluid snipped"
                        />
                    </div>
                </div>
                <div class="row margin-bottom-large" data-speed="1.1">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="bg-dark-blue snipped px-4 py-5 px-md-5">
                            <h2 class="mb-5 tk-obvia fs-2">Sema Home – Faza 1</h2>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-sm-6 px-lg-5 pe-sm-0 ps-xl-0 mb-5 mb-xl-0">
                                            <p class="text-xl d-block mb-0 tk-obvia fw-semibold">301</p>
                                            <p class="text-l tk-obvia mb-0 fw-semibold">Apartamente cu<br>1/2/3/4 camere</p>
                                        </div>
                                        <div class="col-sm-6 px-lg-5 pe-sm-0 ps-xl-0 mb-5 mb-xl-0">
                                            <p class="text-xl d-block mb-0 tk-obvia fw-semibold">390</p>
                                            <p class="text-l tk-obvia mb-0 fw-semibold">Locuri de parcare</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 offset-xl-1">
                                    <div class="row">
                                        <div class="col-sm-6 d-flex flex-column align-items-start px-lg-5 pe-sm-0 ps-xl-0 mb-5">
                                            <div class="d-flex align-items-center mb-5">
                                                <img src="/images/icon_green_spaces.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Spații verzi</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/icon_tech.svg" class="img-fluid me-3" alt="">
                                                <span class="text-nowrap tk-obvia fw-semibold">Tehnologii<br> avansate</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-flex flex-column align-items-start px-lg-5 pe-sm-0 ps-xl-0">
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
                    </div>
                </div>

                <div class="row bg-beige py-5 py-lg-0 margin-bottom-large">
                    <div class="col-10 offset-1 col-md-9 offset-md-2 col-lg-5 offset-lg-1 col-arhitectura">
                        <div class="d-flex flex-column align-items-start flex-md-row align-items-md-center flex-lg-column align-items-lg-start ps-3 ps-sm-2 ps-md-0">
                            <TitleDecoration class="start-0 arch-title-decoration" />
                            <h2 class="mb-4 mb-md-5 tk-obvia fw-normal">Arhitectură</h2>
                            <div class="ms-0 ms-md-auto ms-lg-0">
                                <img src="/images/excellency_stamp.svg" class="img-fluid margin-bottom me-4 me-sm-5 logo-breeam" alt="Breeam Excellency">
                                <img src="/images/logo_nzeb.svg" class="img-fluid margin-bottom logo-nzeb" alt="Near Zero Energy Building">
                            </div>
                        </div>
                        <p class="ps-3 ps-sm-2 ps-md-0">Un concept arhitectural elegant, la un standard <strong>upper-medium</strong>, unde locuința devine un spațiu al relaxării, al liniștii și al intimității, oferind tot confortul și siguranța de care ai nevoie.</p>
                        <p class="ps-3 ps-sm-2 ps-md-0">Proiectarea se va realiza folosind standardul NZEB, “net zero energy building”, clădiri cu un consum de energie aproape de zero.</p>
                        <p class="ps-3 ps-sm-2 ps-md-0 mb-0">Prin soluții constructive cuprinse încă din faza de proiectare, clădirea a obținut deja certificare BREEAM Excellent din fază de proiect.</p>
                    </div>
                    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xxl-5 offset-xxl-1">
                        <div class="slider-about">
                            <swiper-container
                                direction="vertical"
                                class="swiper"
                                :slidesPerView="3"
                                :spaceBetween="0"
                                :loop="true"
                                :speed="800"
                                :grabCursor="true"
                                :autoplay="true"
                                :pagination="{
                                    el: '.swiper-pagination',
                                    clickable: true,
                                }"
                                :navigation="{
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                }">
                                <swiper-slide v-for="n in 5" :key="n" class="swiper-slide">
                                    <img
                                        :src="`/images/despre_proiect_swiper_${n}-600.webp`"
                                        :srcset="
                                            `/images/despre_proiect_swiper_${n}-480.webp 480w,
                                            /images/despre_proiect_swiper_${n}-600.webp 600w`"
                                        sizes="100vw"
                                        :alt="`Sema Home rendering ${n}`"
                                        class="snipped"
                                        @click="openLightbox(lightboxItems[n - 1])"
                                    />
                                </swiper-slide>
                            </swiper-container>
                            <div class="swiper-pagination"><!-- --></div>
                            <div class="swiper-button-prev"><!-- --></div>
                            <div class="swiper-button-next"><!-- --></div>
                        </div>
                    </div>
                </div>

                <div class="row gx-5 margin-bottom-large">
                    <div class="col-2 col-lg-1 d-flex justify-content-start">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 offset-2 col-md-9 offset-md-2 col-lg-10 offset-lg-0">
                        <h2 class="mb-3 mb-sm-4 mb-lg-5 tk-obvia">Design și finisaje <br class="d-none d-lg-inline" /><span class="text-teal">premium</span></h2>
                    </div>
                    <div class="col-10 offset-2 col-md-9 offset-md-2 col-lg-5 offset-lg-1 mb-5 mb-lg-0">
                        <img
                            src="/images/render_living-737.webp"
                            srcset="
                                /images/render_living-480.webp 480w,
                                /images/render_living-737.webp 737w"
                            sizes="100vw"
                            alt="Describe the image"
                            class="img-fluid snipped"
                        />
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-2 col-md-9 offset-md-2 col-lg-5 offset-lg-0">
                        <ul class="ap-details-list">
                            <li>Suprafață generoasă, cu până la 20% mai mult spațiu locuibil decât media pieței</li>
                            <li>Două sau mai multe variante de compartimentare pentru fiecare tip de apartament</li>
                            <li>Finisaje de calitate superioară</li>
                            <li>Sistem smart home pentru un stil de viață contemporant</li>
                            <li>Aer condiționat multisplit LG cu control personalizat al temperaturii pentru un ambient perfect în fiecare încăpere</li>
                        </ul>
                    </div>
                </div>

                <div class="row gx-5 mt-xl-5 margin-bottom-large">
                    <div class="col-2 col-lg-1 d-flex justify-content-start poi-title-decoration-col">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 offset-2 offset-md-2 col-lg-4 offset-lg-0">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Puncte de <br class="d-none d-lg-inline" /><span class="text-teal">interes</span></h2>
                        <p><strong>Există numeroase opțiuni de shopping și entertainment, dar și educație și sănătate.</strong></p>
                    </div>
                    <div class="col-10 offset-2 col-md-10 offset-md-1 col-md-8 offset-md-2 col-lg-5 offset-lg-1">
                        <p class="mb-5">Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții) și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).</p>
                        <Link :href="route('location')" class="btn btn-icon btn-teal d-inline-flex align-items-center tk-obvia snipped" alt="">
                            <img src="/images/icon_location.svg" class="img-fluid" alt="">
                            <span class="text-nowrap">Vezi localizare</span>
                        </Link>
                    </div>
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
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { register } from 'swiper/element/bundle';
import TitleDecoration from '@/Components/TitleDecoration.vue';

register();

const lightboxItems = computed(() => {
    const items = [];
    for (let i = 1; i <= 5; i++) {
        items.push({
            src: `/images/despre_proiect_swiper_${i}-2048.webp`,
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
.logo-breeam {
    mix-blend-mode: multiply;
}

.col-arhitectura {
    padding-top: 6rem;
    padding-bottom: 6rem;
}

.slider-about {
    height: 110%;
    position: relative;
    z-index: 1;
    top: -5%;
}

.slider-about .swiper {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    padding-left: 2rem;
    padding-right: 3rem;
    margin-right: -3rem;
}

.slider-about .swiper-slide {
    height: 33.3333% !important;
    transition: height 0.3s ease-in-out;
}

.slider-about .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 1rem;
    transform: scale(.9);
    transition: all 0.3s ease-in-out;
    opacity: 0;
}

.slider-about .swiper-slide-active,
.slider-about .swiper-slide-next + .swiper-slide {
    height: 30% !important;
}

.slider-about .swiper-slide-next {
    height: 40% !important;
}

.slider-about .swiper-slide-next img,
.slider-about .swiper-slide-active img,
.slider-about .swiper-slide-next + .swiper-slide img {
    opacity: 1;
}

.slider-about .swiper-slide-next img {
    transform: scale(1);
}

.slider-about .swiper-pagination-bullets {
    right: auto;
    left: 0;
}

.slider-about .swiper-button-next,
.slider-about .swiper-button-prev {
    top: 49%;
    right: 0;
}

.slider-about:deep(.swiper-pagination-bullet-active) {
    width: .5rem;
    height: 1rem;
}

.slider-about .swiper-button-prev {
    left: auto;
    transform: translateY(-100%) rotate(90deg);
}

.slider-about .swiper-button-next {
    transform: translateY(100%) rotate(90deg);
}

.poi-title-decoration-col {
    position: relative;
}

@media (max-width: 1399px) {
    .slider-about .swiper {
        padding-left: 1.5rem;
    }
}

@media (max-width: 991px) {
    .col-arhitectura {
        padding-top: 0;
        padding-bottom: 0;
    }

    .arch-title-decoration {
        top: 5rem;
    }

    .logo-breeam,
    .logo-nzeb {
        max-height: 90px;
    }
    
    .slider-about {
        height: 60vh;
        top: 0;
        margin-top: 2rem;
    }

    .slider-about .swiper {
        padding-left: 3rem;
        padding-right: 3rem;
    }

    .slider-about .swiper-pagination-bullets {
        left: 1rem;
    }
    
    .poi-title-decoration-col {
        position: static;
    }
}

@media (max-width: 768px) {
    .arch-title-decoration {
        top: auto;
    }
}

@media (max-width: 575px) {
    .logo-breeam,
    .logo-nzeb {
        max-height: 80px;
    }
}
</style>