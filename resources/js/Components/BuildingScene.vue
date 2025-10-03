<template>
    <div class="hero-home position-relative overflow-hidden" v-if="building">
        <Head v-if="shouldInjectPreload">
            <link rel="preload" as="image" :href="heroSrc" :imagesrcset="heroSrcset" imagesizes="100vw" />
        </Head>
        <div class="hero-scene">
            <img :src="heroSrc" :srcset="`
                /images/${building.render}-480.webp 480w,
                /images/${building.render}-768.webp 768w,
                /images/${building.render}-1024.webp 1024w,
                /images/${building.render}-1440.webp 1440w,
                /images/${building.render}-1920.webp 1920w,
                /images/${building.render}-2560.webp 2560w`"
            sizes="100vw"
            fetchpriority="high"
            loading="eager"
            :alt="building.name + ' din proiectul Sema Home'"
            class="w-100 h-auto" />
            <svg v-if="building.floor_svg_viewbox && building.floors && building.floors.length" class="position-absolute"
                style="left:0;top:0;width:100%;height:100%" xmlns="http://www.w3.org/2000/svg"
                :viewBox="building.floor_svg_viewbox" preserveAspectRatio="xMinYMin">
                <g v-for="floor in building.floors" :key="floor.id">
                    <a v-if="!floor.is_sold_out"
                        :href="`/${building.slug}/${floor.slug}${roomsFilter !== 'toate' ? ('?camere=' + roomsFilter) : ''}`"
                        class="sh-floor clickable">
                        <template v-if="Array.isArray(floor.shape_paths) && floor.shape_paths.length">
                            <g :transform="floor.group_transform || null">
                                <path v-for="(shape, idx) in floor.shape_paths" :key="floor.id + '-' + idx"
                                    @mouseover="setTitle(floor)" @mouseleave="title = ''" :d="shape.d"
                                    :transform="shape.transform || null" fill="currentColor" />
                            </g>
                        </template>
                        <template v-else>
                            <path @mouseover="setTitle(floor)" @mouseleave="title = ''" :d="floor.floor_d"
                                :transform="floor.floor_transform || null" fill="currentColor" />
                        </template>
                    </a>
                    <g v-else class="sh-floor sold-out">
                        <template v-if="Array.isArray(floor.shape_paths) && floor.shape_paths.length">
                            <g :transform="floor.group_transform || null">
                                <path v-for="(shape, idx) in floor.shape_paths" :key="'sold-' + floor.id + '-' + idx"
                                    @mouseover="setTitle(floor)" @mouseleave="title = ''" :d="shape.d"
                                    :transform="shape.transform || null" fill="currentColor" />
                            </g>
                        </template>
                        <template v-else>
                            <path @mouseover="setTitle(floor)" @mouseleave="title = ''" :d="floor.floor_d"
                                :transform="floor.floor_transform || null" fill="currentColor" />
                        </template>
                    </g>
                </g>
            </svg>
            <transition name="floor-label-fade">
                <div v-if="title" class="floor-label position-absolute text-center text-white snipped px-5 py-2">
                    <span class="d-block title tk-obvia fw-bold">{{ title }}</span>
                    <span class="d-block sub-title">{{ subTitle }}</span>
                </div>
            </transition>
        </div>

        <ApartmentFilter v-if="building && building.floors && building.floors.length" v-model="roomsFilter"
            class="bottom-0 start-0 mb-lg-4 ms-lg-4 apt-filter" />
    </div>
</template>

<script setup>
import ApartmentFilter from '@/Components/ApartmentFilter.vue';
import { ref, watch, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    building: [Object, null],
    selectedRooms: { type: [String, Number], default: 'toate' },
});

const title = ref('');
const subTitle = ref('');
const roomsFilter = ref(String(props.selectedRooms ?? 'toate'));

// Inject preload only on the first full page load. When navigating with Inertia the
// component will remount but the window flag prevents duplicating the same preload link.
const shouldInjectPreload = ref(false);
onMounted(() => {
    if (typeof window !== 'undefined' && !window.__sema_home_hero_preloaded) {
        window.__sema_home_hero_preloaded = true;
        shouldInjectPreload.value = true;
    }
});

const heroSrc = computed(() => `/images/${props.building?.render}-2560.webp`);
const heroSrcset = computed(() => `
    /images/${props.building?.render}-480.webp 480w,
    /images/${props.building?.render}-768.webp 768w,
    /images/${props.building?.render}-1024.webp 1024w,
    /images/${props.building?.render}-1440.webp 1440w,
    /images/${props.building?.render}-1920.webp 1920w,
    /images/${props.building?.render}-2560.webp 2560w`);

function setTitle(floor) {
    const name = floor.name || (floor.level != null ? `Etaj ${floor.level}` : 'Etaj');
    const filt = roomsFilter.value && roomsFilter.value !== 'toate' ? (roomsFilter.value === '1' ? '1 cameră:' : String(roomsFilter.value) + ' camere:') : '';
    const count = floor.available_apartments_count ?? floor.apartments_count ?? 0;
    const avail = count === 1 ? 'disponibil' : 'disponibile';
    title.value = name;
    subTitle.value = count > 0 ? `${filt} ${count} ${avail}` : 'Vândut';
}

// Reload counts from server when filter changes (preserve UI and replace history)
watch(roomsFilter, (val) => {
    // Always send 'rooms' so selecting 'toate' clears previous preference
    const data = { camere: val || 'toate' };
    router.get(window.location.pathname, data, { replace: true, preserveState: true, preserveScroll: true });
});
</script>

<style scoped>
/* Interactive overlay styles */
.sh-floor {
    color: transparent;
    transition: color .2s ease, opacity .2s ease;
}

.sh-floor.clickable {
    cursor: pointer;
}

.sh-floor:hover {
    color: rgba(29, 149, 158, 0.75);
}

.sh-floor.sold-out:hover {
    color: rgb(144, 28, 28, 0.75);
}

.floor-label {
    left: 50%;
    top: 20%;
    transform: translateX(-50%);
    background-color: rgba(41, 71, 82, .85);
    backdrop-filter: blur(6px);
    box-shadow: 0 3px 17px rgba(41, 71, 82, .56);
}

.floor-label .title {
    font-size: 1.5rem;
}

.floor-label .sub-title {
    font-size: .875rem;
}

.apt-filter {
    position: absolute;
}

/* Fade-up transition for the label */
.floor-label-fade-enter-active, .floor-label-fade-leave-active {
    transition: opacity .5s ease, transform .5s ease;
}
.floor-label-fade-enter-from, .floor-label-fade-leave-to {
    opacity: 0;
    transform: translateY(8px) translateX(-50%);
}
.floor-label-fade-enter-to, .floor-label-fade-leave-from {
    opacity: 1;
    transform: translateY(0) translateX(-50%);
}

@media (max-width: 991px) {
    .apt-filter {
        position: static;
        width: 90%;
        transform: translate(5%, -1rem);
    }
    .hero-scene {
        width: 140%;
        transform: translateX(-17.5%);
    }
}
</style>
