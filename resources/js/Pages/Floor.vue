<template>
    <AppLayout>
        <Head :title="`${floor.name} - ${building.name}`" />
        <div class="large-pad pt-4 pad-bottom position-relative">
            <div class="row gx-5">
                <div class="col-10 col-lg-11 col-xl-10 offset-xl-1">
                    <Link :href="route('building.show', building.slug)" class="btn btn-arrow btn-arrow-prev btn-teal snipped mb-5 d-inline-block">
                        <span>Înapoi la selecție etaj</span>
                    </Link>
                </div>
                <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                    <TitleDecoration />
                </div>
            </div>
            <div class="row gx-5 mt-5">
                <div class="col-lg-2 offset-xl-1 d-flex flex-column align-items-start">
                    <h2 class="tk-obvia fw-normal text-uppercase mb-4">{{ building.name }}<br /><span class="text-teal">{{ floor.name }}</span></h2>
                    <p class="text-l">Opțiuni de apartamente pentru fiecare stil de viață.</p>
                    <!-- Rooms filter control -->
                    <ApartmentFilter v-model="roomsFilter" class="mt-auto" />
                </div>

                <div class="col-lg-10 col-xl-9">
                    <div class="position-relative" v-if="floor" ref="overlayRef">
                        <img
                            :src="`/images/${floor.floor_plan}-2560.webp`"
                            :srcset="
                                `/images/${floor.floor_plan}-480.webp 480w,
                                /images/${floor.floor_plan}-768.webp 768w,
                                /images/${floor.floor_plan}-1024.webp 1024w,
                                /images/${floor.floor_plan}-1440.webp 1440w,
                                /images/${floor.floor_plan}-1920.webp 1920w,
                                /images/${floor.floor_plan}-2560.webp 2560w`"
                            sizes="100vw"
                            :alt="floor.name + ', ' + building.name + ' din proiectul Sema Home'"
                            class="w-100 h-auto"
                        />

                        <svg v-if="floor.floor_svg_viewbox && filteredApartments.length"
                            class="position-absolute"
                            style="left:0;top:0;width:100%;height:100%"
                            xmlns="http://www.w3.org/2000/svg"
                            :viewBox="floor.floor_svg_viewbox"
                            preserveAspectRatio="xMinYMin">
                            <g v-for="apt in filteredApartments" :key="apt.id"
                            :ref="el => registerAptRef(apt.id, el)">
                                <a v-if="apt.is_available"
                                    :href="`/${building.slug}/${floor.slug}/${apt.friendly_id}${roomsFilter !== 'toate' ? ('?camere=' + roomsFilter) : ''}`"
                                    @mouseover="onHover(apt)" @mouseleave="onLeave(apt)"
                                    v-html="apt.g_content"
                                    :class="['apt', 'available', { 'filtered-match': roomsFilter !== 'toate' }]">
                                </a>
                                <g v-else
                                    class="apt sold"
                                    @mouseover="onHover(apt)" @mouseleave="onLeave(apt)"
                                    v-html="apt.g_content"></g>
                            </g>
                        </svg>

                        <!-- Floating HTML label shown only on hover -->
                        <transition name="apt-fade">
                            <div v-if="hoverApt"
                                ref="labelRef"
                                class="apt-float-label position-absolute"
                                :class="{ 'is-flipped': flipY }"
                                :style="labelStyle">
                                <div class="label-badge text-white text-center px-4 py-2 snipped">
                                    <div class="text-uppercase fs-7">Ap.</div>
                                    <div class="tk-obvia fw-bold fs-5">{{ formatLabel(hoverApt) }}</div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted, nextTick, watch, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleDecoration from '@/Components/TitleDecoration.vue';
import ApartmentFilter from '@/Components/ApartmentFilter.vue';

const props = defineProps({
    building: Object,
    floor: Object,
    selectedRooms: { type: [String, Number], default: 'toate' },
});

const roomsFilter = ref(String(props.selectedRooms ?? 'toate'));

const filteredApartments = computed(() => {
    const list = props.floor?.apartments || [];
    if (!roomsFilter.value || roomsFilter.value === 'toate') return list;
    const wanted = parseInt(roomsFilter.value, 10);
    return list.filter(a => Number(a.room_count) === wanted);
});

// Hover state and DOM refs
const hoverId = ref(null);
const hoverApt = ref(null);
const floatPos = ref({ left: 0, top: 0 });
const aptRefs = new Map();
const overlayRef = ref(null);
const labelRef = ref(null);
const labelDims = ref({ w: 0, h: 0 });
const flipY = ref(false);
const padding = 8; // px padding from container edges

function registerAptRef(id, el) {
    if (el) {
        aptRefs.set(id, el);
    } else {
        aptRefs.delete(id);
    }
}

function updateFloatPosition(id) {
    const container = overlayRef.value;
    const el = aptRefs.get(id);
    if (!container || !el) return;
    try {
        const crect = container.getBoundingClientRect();
        const erect = el.getBoundingClientRect();
        // Measure tooltip if present
        if (labelRef.value) {
            const lrect = labelRef.value.getBoundingClientRect();
            labelDims.value = { w: lrect.width, h: lrect.height };
        }
        const { w, h } = labelDims.value;

        // Desired center x at shape center; clamp within container (account for half label width)
        const desiredCx = erect.x + erect.width / 2 - crect.x;
        const minCx = padding + (w ? w / 2 : 40);
        const maxCx = Math.max(minCx, crect.width - padding - (w ? w / 2 : 40));
        const clampedCx = Math.min(Math.max(desiredCx, minCx), maxCx);

        // Top edge Y of the shape (relative to container)
        const topEdgeY = erect.y - crect.y;
        // If showing above would overflow out of container top, flip below
        const neededTop = topEdgeY - (h ? h * 1.2 : 40) - padding;
        // Uncomment this to restore flipping behavior:
        // flipY.value = neededTop < 0; 

        floatPos.value = { left: clampedCx, top: topEdgeY };
    } catch (e) {
        // ignore
    }
}

function onHover(apt) {
    hoverId.value = apt.id;
    hoverApt.value = apt;
    nextTick(() => {
        // ensure label exists to measure dims
        updateFloatPosition(apt.id);
    });
}

function onLeave() {
    hoverId.value = null;
    hoverApt.value = null;
}

onMounted(async () => {
    await nextTick();
    if (hoverId.value) updateFloatPosition(hoverId.value);
    // Recompute on window resize to handle image/SVG size changes
    window.addEventListener('resize', () => {
        if (hoverId.value) updateFloatPosition(hoverId.value);
    });
});

watch(() => props.floor?.apartments, async () => {
    await nextTick();
    if (hoverId.value) updateFloatPosition(hoverId.value);
});

function formatLabel(apt) {
    // Keep it simple: show apartment number; customize as needed (e.g., rooms/size)
    return apt.number || '';
}

const labelStyle = computed(() => {
    // Overlap the shape slightly: place closer than before
    const offset = flipY.value ? 4 : -90; // px percentage-ish translated via CSS
    return {
        left: floatPos.value.left + 'px',
        top: floatPos.value.top + 'px',
        transform: `translate(-50%, ${flipY.value ? '6px' : '-90%'})`,
    };
});

// Persist preference and keep backend in sync (mirrors Home behavior)
watch(roomsFilter, (val) => {
    // Always send 'rooms' so selecting 'toate' clears the previous preference
    const data = { camere: val || 'toate' };
    router.get(window.location.pathname, data, { replace: true, preserveState: true, preserveScroll: true });
});

</script>

<style scoped>
h2 { white-space: nowrap; font-size: 40px; }
/* Interactive overlay styles for apartments */
.apt { color: transparent; transition: color .2s ease, opacity .2s ease; }
.apt.available { cursor: pointer; }
.apt.available.filtered-match { color: rgba(29, 149, 158, 0.35); }
.apt.available:hover { color: rgba(29, 149, 158, 0.75); }
.apt.sold { color: rgb(144, 28, 28, 0.85); cursor: not-allowed; }
/* When a rooms filter is active, softly show matching available apartments */

/* Floating HTML label */
.apt-float-label { pointer-events: none; z-index: 3; }
.apt-float-label .label-badge {
    background-color: rgba(41, 71, 82, .85);
    backdrop-filter: blur(6px);
    box-shadow: 0 3px 17px rgba(41, 71, 82, .26);
    min-width: 64px;
}
.apt-float-label::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 0; height: 0;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 8px solid rgba(41, 71, 82, .85); /* arrow pointing down by default */
    filter: drop-shadow(0 -1px 1px rgba(0,0,0,.08));
}
.apt-float-label:not(.is-flipped)::after {
    top: calc(100% - 1px);
}
.apt-float-label.is-flipped::after {
    bottom: calc(100% - 1px);
    border-top: none;
    border-bottom: 8px solid rgba(41, 71, 82, .85); /* arrow pointing up when flipped */
    filter: drop-shadow(0 1px 1px rgba(0,0,0,.08));
}
.apt-float-label .small { font-size: 10px; letter-spacing: .06em; opacity: .8; }
.apt-float-label .fw-bold { font-weight: 700; font-size: 13px; }

/* Fade/slide transition */
.apt-fade-enter-active, .apt-fade-leave-active {
    transition: opacity .15s ease, transform .15s ease;
}
.apt-fade-enter-from, .apt-fade-leave-to {
    opacity: 0;
    transform: translate(-50%, -70%);
}
</style>
