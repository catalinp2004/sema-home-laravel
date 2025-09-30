<template>
  <AppLayout>
    <Head title="Apartments" />
    <div class="large-pad pt-5">
        <div class="limited-container">
            <div class="row margin-bottom">
                <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                    <TitleDecoration />
                </div>
                <div class="col-10 col-lg-11">
                    <h2 class="mb-5 tk-obvia">Apartamente <span class="text-teal"><br>disponibile</span></h2>
                    <p class="text-m fw-bold mb-0">Apartamente cu 1/2/3/4 camere</p>
                </div>
            </div>
            <div class="row margin-bottom">
                <div class="col-xl-10 offset-xl-1 margin-bottom">
                    <div class="d-flex flex-column flex-sm-row bg-dark-blue snipped p-2 room-selector">
                        <div class="d-flex">
                            <button :class="['snipped','first-active', { active: roomsFilter==='1' }]" @click="selectRooms('1')">
                                <span>1 cameră</span>
                            </button>
                        </div>
                        <hr class="mx-2">
                        <div class="d-flex">
                            <button :class="[{ active: roomsFilter==='2' }]" @click="selectRooms('2')">
                                <span>2 camere</span>
                            </button>
                        </div>
                        <hr class="mx-2">
                        <div class="d-flex">
                            <button :class="[{ active: roomsFilter==='3' }]" @click="selectRooms('3')">
                                <span>3 camere</span>
                            </button>
                        </div>
                        <hr class="mx-2">
                        <div class="d-flex">
                            <button :class="['last-active', { active: roomsFilter==='4' }]" @click="selectRooms('4')">
                                <span>4 camere</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <div class="table-responsive">
                        <table class="table table-striped table-fixed table-min mb-5">
                            <thead class="sticky-head">
                                <tr>
                                    <th scope="col-2 px-2">Apartament</th>
                                    <th scope="col-2 px-2">Clădire</th>
                                    <th scope="col-2 px-2">Etaj</th>
                                    <th scope="col-2 px-2">Nr. camere</th>
                                    <th scope="col-2 px-2">Sup. utila</th>
                                    <th scope="col-2 px-2">Vezi apartamnet</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="apt in apartments" :key="apt.id">
                                    <td class="align-middle px-2">{{ apt.number }}</td>
                                    <td class="align-middle px-2">{{ apt.floor?.building?.name || '-' }}</td>
                                    <td class="align-middle px-2">{{ apt.floor?.level ?? '-' }}</td>
                                    <td class="align-middle px-2">{{ parseFloat(apt.room_count) }}</td>
                                    <td class="align-middle px-2">{{ Math.round(Number(apt.usable_size_sqm)) }} m<sup>2</sup></td>
                                    <td class="align-middle px-2 text-center">
                                        <Link :href="route('apartment.show', {'building': apt.floor?.building?.slug, 'floor': apt.floor?.slug, 'apartment': apt.friendly_id })" class="btn-teal d-inline-block snipped px-4 py-2 snipped">
                                            Detalii
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="!apartments || !apartments.length">
                                    <td colspan="6" class="text-center py-4">Nu există apartamente pentru filtrul selectat.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3 gap-2 flex-wrap mb-5">
                        <button class="btn-teal snipped px-3 py-2" :disabled="pagination.current_page <= 1" @click="goFirst">
                            « Prima
                        </button>
                        <button class="btn-teal snipped px-3 py-2" :disabled="pagination.current_page <= 1" @click="goPrev">
                            ‹ Înapoi
                        </button>

                        <template v-if="pageWindow.start > 1">
                            <button class="btn-teal snipped px-3 py-2" @click="goToPage(1)">1</button>
                            <span class="px-1">…</span>
                        </template>

                        <button v-for="n in pageNumbers" :key="'p-'+n" @click="goToPage(n)"
                                :class="['snipped px-3 py-2', n === pagination.current_page ? 'btn-teal' : 'btn-teal']">
                            {{ n }}
                        </button>

                        <template v-if="pageWindow.end < pagination.last_page">
                            <span class="px-1">…</span>
                            <button class="btn-teal snipped px-3 py-2" @click="goToPage(pagination.last_page)">{{ pagination.last_page }}</button>
                        </template>

                        <button class="btn-teal snipped px-3 py-2" :disabled="pagination.current_page >= pagination.last_page" @click="goNext">
                            Înainte ›
                        </button>
                        <button class="btn-teal snipped px-3 py-2" :disabled="pagination.current_page >= pagination.last_page" @click="goLast">
                            Ultima »
                        </button>
                    </div>
                    <p class="mw-100 mt-3">* Pot apărea diferențe de +/- 5% între suprafețele aflate în schițele comerciale și masurătorile cadastrale;</p>
                </div>
            </div>
        </div>
    </div>
  </AppLayout>
  
  
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import TitleDecoration from '@/Components/TitleDecoration.vue';
import { computed, ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const apartments = computed(() => page.props.apartments || []);
const filters = computed(() => page.props.filters || {});
const roomsFilter = ref(String(filters.value.camere ?? 'toate'));
const pagination = computed(() => page.props.pagination || { current_page: 1, last_page: 1, per_page: 12 });

// Build a windowed list of pages around the current page (e.g., ±2)
const pageWindow = computed(() => {
    const total = Number(pagination.value.last_page || 1);
    const current = Number(pagination.value.current_page || 1);
    const radius = 2;
    const start = Math.max(1, current - radius);
    const end = Math.min(total, current + radius);
    return { start, end };
});

const pageNumbers = computed(() => {
    const nums = [];
    for (let i = pageWindow.value.start; i <= pageWindow.value.end; i++) nums.push(i);
    return nums;
});

function selectRooms(val) {
    roomsFilter.value = val;
}

// When rooms filter changes, navigate with Inertia to refresh the list (persist in session server-side)
watch(roomsFilter, (val) => {
    const data = { camere: val };
    router.get('/apartamente', data, { replace: true, preserveScroll: true });
});

function goToPage(n) {
    if (!n || n === pagination.value.current_page) return;
    const data = { camere: roomsFilter.value, page: n };
    const perPage = pagination.value?.per_page;
    if (perPage) data.per_page = perPage;
    router.get('/apartamente', data, { replace: false, preserveScroll: true });
}

function goPrev() {
    if (pagination.value.current_page > 1) {
        goToPage(pagination.value.current_page - 1);
    }
}

function goNext() {
    if (pagination.value.current_page < pagination.value.last_page) {
        goToPage(pagination.value.current_page + 1);
    }
}

function goFirst() {
    if (pagination.value.current_page > 1) {
        goToPage(1);
    }
}

function goLast() {
    if (pagination.value.current_page < pagination.value.last_page) {
        goToPage(pagination.value.last_page);
    }
}
</script>
