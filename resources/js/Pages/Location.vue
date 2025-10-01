<template>
  <AppLayout>
    <Head title="Location" />
        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-5 mb-xl-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-lg-4">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Puncte de <br class="d-none d-lg-inline" /><span class="text-teal">interes</span></h2>
                        <p><strong>Există numeroase opțiuni de shopping și entertainment, dar și educație și sănătate.</strong></p>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-1">
                        <p>Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții) și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 p-2 bg-dark-blue d-flex flex-column flex-sm-row align-items-center snipped filter-case">
                        <template v-for="(layer, idx) in layers" :key="layer.key">
                            <div class="flex-grow-1 w-100 w-lg-auto mb-3 mb-sm-0">
                                <button
                                    class="btn p-3 text-white w-100 d-flex align-items-center justify-content-between"
                                    :class="{ 'bg-light-teal': isActive(layer.key), 'snipped': layer.key === 'transport' }"
                                    @click="setLayer(layer.key)"
                                    :aria-pressed="isActive(layer.key)"
                                >
                                    <img src="/images/icon_location_white.svg" class="img-fluid me-2" alt="">
                                    <span class="text-uppercase me-auto">{{ layer.label }}</span>
                                </button>
                            </div>
                            <hr class="map-hr" v-if="idx < layers.length - 1">
                        </template>
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

                <div class="row gx-5 margin-bottom-large z-1 position-relative">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-lg-4">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Accesibilitate</h2>
                        <p><strong>Sema Home se află amplasat în interiorul Sema Parc, la distanță de zgomotul traficului și al vieții agitate din capitală.</strong></p>
                        <p>Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții) și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).</p>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-1">
                        <img src="/images/access.png" class="w-100 h-auto" alt="">
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
</script>

<style scoped>
.filter-case button {
    border-radius: 0;
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
</style>
 
