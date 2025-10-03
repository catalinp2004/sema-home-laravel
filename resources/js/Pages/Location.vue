<template>
  <AppLayout>
    <Head title="Location" />
        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-5 mb-4 mb-lg-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 col-md-9 col-lg-4">
                        <h2 class="mb-3 mb-sm-4 mb-lg-5 tk-obvia">Puncte de <br class="d-none d-lg-inline" /><span class="text-teal">interes</span></h2>
                        <p><strong>Există numeroase opțiuni de shopping și entertainment, dar și educație și sănătate.</strong></p>
                    </div>
                    <div class="col-10 offset-2 col-md-9 offset-md-2 col-lg-5 offset-lg-1">
                        <p>Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții) și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 p-2 bg-dark-blue snipped filter-case">
                        <div class="row gx-2 gy-2 align-items-stretch">
                            <div v-for="(layer, idx) in layers" :key="layer.key" class="col-6 col-md-4 col-xl-2 filter-button-col">
                                <button
                                    class="btn p-3 text-white w-100 d-flex align-items-center justify-content-start h-100 text-start"
                                    :class="{ 'bg-light-teal': isActive(layer.key) }"
                                    @click="setLayer(layer.key)"
                                    :aria-pressed="isActive(layer.key)"
                                >
                                    <img src="/images/icon_location_white.svg" class="img-fluid me-2" alt="">
                                    <span class="text-uppercase">{{ layer.label }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="position-relative map-wrapper">
                    <img src="/images/map_base.svg" class="w-100 h-auto" alt="Harta baza">
                        <transition name="layer-fade" mode="out-in">
                        <img
                            v-if="currentLayer"
                            :key="currentLayer.key"
                            :src="currentLayer.src"
                            :alt="currentLayer.label"
                            class="position-absolute top-0 start-0 w-100 h-auto"
                        />
                    </transition>
                    <img src="/images/sema_marker.svg" alt="Sema marker" class="position-absolute top-0 start-0 w-100 h-auto">
                </div>

                <div class="row gx-5 margin-bottom z-1 position-relative">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 col-md-9 col-lg-5 col-xl-4">
                        <h2 class="mb-3 mb-sm-4 mb-lg-5 tk-obvia">Accesibilitate</h2>
                        <p><strong>Sema Home se află amplasat în interiorul Sema Parc, la distanță de zgomotul traficului și al vieții agitate din capitală.</strong></p>
                        <p class="mb-0">Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții) și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).</p>
                    </div>
                    <div class="col-12 col-sm-11 offset-sm-1 col-md-9 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 offset-xl-1 mt-4 mt-lg-0">
                        <div class="bg-dark-blue text-white snipped px-4 py-3">
                            <div class="row">
                                <!-- Left: destinations and times -->
                                <div class="col-12 destinations-col">
                                    <div>
                                        <div
                                            v-for="(item, idx) in accessItems"
                                            :key="item.label"
                                            class="row align-items-center py-3"
                                            :class="{ 'border-0': idx === accessItems.length - 1 }"
                                        >
                                            <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                                                <div class="text-sm-end">
                                                    <span class="me-2">→</span>
                                                    <span class="fs-6 fw-semibold">{{ item.label }}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 col-sm-3 col-lg-3 position-relative time-col">
                                                <div class="d-flex flex-column align-items-center gap-3 lh-lg">
                                                    <span>{{ item.transit.time }} min</span>
                                                    <span>{{ item.car.time }} min</span>
                                                </div>
                                            </div>
                                            <div class="col-7 col-sm-4 col-lg-3">
                                                <div class="d-flex flex-column gap-4">
                                                    <div class="d-flex align-items-center gap-3 flex-nowrap">
                                                        <img v-for="(icon, i) in item.transit.icons" :key="i" class="icon-transport" :src="`/images/icon_${icon}.svg`" :alt="icon">
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img class="icon-transport" src="/images/icon_car.svg" alt="car">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right: note -->
                                <div class="col-12 mt-3 position-relative gmaps-col">
                                    <p class="small fw-bold"><span>Aceste estimări au fost calculate cu ajutorul</span> <img src="/images/google_maps_logo.svg" alt="Google Maps"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TitleDecoration from '@/Components/TitleDecoration.vue';
import { ref, computed } from 'vue';

// Simple reactive state: which overlay layer is visible
const layers = [
    { key: 'transport', label: 'Transport', src: '/images/map_transport.svg' },
    { key: 'shopping', label: 'Shopping', src: '/images/map_shopping.svg' },
    { key: 'recreatie', label: 'Recreație', src: '/images/map_recreatie.svg' },
    { key: 'licee_universitati', label: 'Licee și universități', src: '/images/map_licee_universitati.svg' },
    { key: 'gradinite_scoli', label: 'Grădinițe și școli', src: '/images/map_gradinite_scoli.svg' },
    { key: 'sanatate', label: 'Sănătate', src: '/images/map_sanatate.svg' }
];

const selectedLayer = ref('transport');
const setLayer = (key) => { selectedLayer.value = key; };
const isActive = (key) => selectedLayer.value === key;
const currentLayer = computed(() => layers.find(l => l.key === selectedLayer.value) || layers[0]);

// layout-specific clipping is handled in CSS using nth-child selectors below

// Access panel content (responsive, Bootstrap-driven)
const accessItems = [
    {
        label: 'Aeroportul Henri Coandă',
        transit: { time: 53, icons: ['subway', 'bus', 'trolley', 'tram'] },
        car: { time: 37 },
    },
    {
        label: 'Piața Victoriei',
        transit: { time: 22, icons: ['subway', 'bus', 'trolley'] },
        car: { time: 15 },
    },
    {
        label: 'Piața Unirii',
        transit: { time: 19, icons: ['subway', 'bus', 'tram'] },
        car: { time: 22 },
    },
];
</script>

<style scoped>
.filter-case button {
    border-radius: 0;
}

.filter-case button:hover,
.filter-case button:focus,
.bg-light-teal {
    background-color: rgba(255, 255, 255, 0.3)
}

/* Smooth fade between layers */
.layer-fade-enter-active, .layer-fade-leave-active {
    transition: opacity .15s ease;
}
.layer-fade-enter-from, .layer-fade-leave-to {
    opacity: 0;
}

.map-wrapper {
    margin-bottom: -6rem;
}
.filter-button-col {
    position: relative;
}
.filter-button-col:not(:last-child)::after {
    content: '';
    position: absolute;
    right: -1px;
    top: 18%;
    bottom: 18%;
    width: 1px;
    background: white;
    z-index: 1;
}

.filter-case .filter-button-col:nth-child(1) .btn {
    clip-path: polygon(0 0,100% 0,100% 100%,15px 100%,0 calc(100% - 15px));
}

/* Soft white gradient at the bottom of the map to match the static design */
.map-wrapper::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 22%;
    pointer-events: none;
    background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
    z-index: 1;
}

.time-col::before,
.time-col::after {
    content: '';
    position: absolute;
    left: .75rem;
    top: 0;
    width: 1px;
    background: white;
    z-index: 1;
    height: 100%;
}

.time-col::after {
    left: auto;
    right: .75rem;
}

.icon-transport {
    width: 28px;
    height: 28px;
}

.gmaps-col p {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
}

@media (min-width: 1800px) {
    .destinations-col {
        width: 75%;
    }
    .gmaps-col {
        width: 25%;
    }
    .gmaps-col::before {
        content: '';
        position: absolute;
        left: -.5rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1px;
        background: white;
        z-index: 1;
        height: 100%;
    }
}

@media (max-width: 1199px) {
    .filter-case .filter-button-col:nth-child(1) .btn {
        clip-path: none;
    }

    .filter-case .filter-button-col:nth-child(4) .btn {
        clip-path: polygon(0 0,100% 0,100% 100%,15px 100%,0 calc(100% - 15px));
    }

    .filter-button-col:nth-child(3)::after {
        content: none;
    }
}

@media (max-width: 991px) {
    .filter-case {
        transform: translateY(0);
        margin-bottom: 2rem;
    }
    .map-wrapper {
        margin-bottom: -3rem;
    }
}

@media (max-width: 767px) {
    .filter-case .filter-button-col:nth-child(4) .btn {
        clip-path: none;
    }
    .filter-case .filter-button-col:nth-child(5) .btn {
        clip-path: polygon(0 0,100% 0,100% 100%,15px 100%,0 calc(100% - 15px));
    }
    .filter-button-col:nth-child(3)::after {
        content: '';
    }

    .filter-button-col:nth-child(2)::after,
    .filter-button-col:nth-child(4)::after {
        content: none;
    }
}
@media (max-width: 575px) {
    .filter-case button {
        font-size: .875rem;
    }
    .filter-case button img {
        max-width: 20px;
    }
    .time-col::before {
        content: none;
    }
}
</style>
 
