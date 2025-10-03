<template>
  <AppLayout>
    <Head title="Apartments" />
    <div class="large-pad pt-5">
        <div class="limited-container">
            <div class="row margin-bottom">
                <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                    <TitleDecoration />
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-lg-auto">
                            <h2 class="mb-4 mb-md-5 tk-obvia">Apartamente <span class="text-teal"><br>disponibile</span></h2>
                        </div>
                        <div class="col-lg offset-lg-1">
                            <p class="mb-0 lh-lg">
                                <span v-if="sp['1']">1 cameră – prețuri începând de la <strong>{{ formatPrice(sp['1']) }}</strong></span>
                                <span v-else>1 cameră</span>
                                <br />
                                <span v-if="sp['2']">2 camere – prețuri începând de la <strong>{{ formatPrice(sp['2']) }}</strong></span>
                                <span v-else>2 camere</span>
                                <br />
                                <span v-if="sp['3']">3 camere – prețuri începând de la <strong>{{ formatPrice(sp['3']) }}</strong></span>
                                <span v-else>3 camere</span>
                                <br />
                                <span v-if="sp['4']">4 camere – prețuri începând de la <strong>{{ formatPrice(sp['4']) }}</strong></span>
                                <span v-else>4 camere</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom">
                <div class="col-xl-10 offset-xl-1 margin-bottom">
                    <div class="row gx-2 align-items-stretch bg-dark-blue snipped p-2 room-selector">
                        <div class="col-12 col-sm-auto room-filter-col">
                            <button @click="selectRooms('toate')" class="py-3">
                                <span>Toate</span>
                            </button>
                        </div>

                        <div class="col-6 col-sm-auto room-filter-col">
                            <button :class="[{ active: roomsFilter==='1' }]" @click="selectRooms('1')" class="py-3">
                                <span>1 cameră</span>
                            </button>
                        </div>

                        <div class="col-6 col-sm-auto room-filter-col">
                            <button :class="[{ active: roomsFilter==='2' }]" @click="selectRooms('2')" class="py-3">
                                <span>2 camere</span>
                            </button>
                        </div>

                        <div class="col-6 col-sm-auto room-filter-col">
                            <button :class="[{ active: roomsFilter==='3' }]" @click="selectRooms('3')" class="py-3">
                                <span>3 camere</span>
                            </button>
                        </div>

                        <div class="col-6 col-sm-auto room-filter-col">
                            <button :class="['last-active', { active: roomsFilter==='4' }]" @click="selectRooms('4')" class="py-3">
                                <span>4 camere</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <div class="table-responsive">
                        <table class="table table-striped mb-5">
                            <thead>
                                <tr class="align-middle">
                                    <th class="col-2 px-2">Apartament</th>
                                    <th class="col-2 px-2">Clădire</th>
                                    <th class="col-2 px-2">Etaj</th>
                                    <th class="col-2 px-2">Nr. camere</th>
                                    <th class="col-2 px-2">Sup. utila</th>
                                    <th class="col-2 px-2 text-center">Vezi apartament</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="apt in apartments" :key="apt.id">
                                    <td class="align-middle px-2">{{ apt.number }}</td>
                                    <td class="align-middle px-2">{{ apt.floor?.building?.name || '-' }}</td>
                                    <td class="align-middle px-2">{{ apt.floor?.level ?? '-' }}</td>
                                    <td class="align-middle px-2">{{ parseFloat(apt.room_count) }}</td>
                                    <td class="align-middle px-2">{{ Math.round(Number(apt.usable_size_sqm)) }}&nbsp;m<sup>2</sup></td>
                                    <td class="align-middle px-2 text-center">
                                        <Link :href="route('apartment.show', {'building': apt.floor?.building?.slug, 'floor': apt.floor?.slug, 'apartment': apt.friendly_id })" class="btn btn-sm btn-teal d-inline-block snipped px-4 py-2 snipped">
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
                    <div class="d-flex justify-content-center align-items-center mt-3 gap-2 flex-wrap mb-5 paginator">
                        <button class="btn btn-sm btn-teal snipped px-3 py-2" :disabled="pagination.current_page <= 1" @click="goFirst">
                            « Prima
                        </button>
                        <button class="btn btn-sm btn-teal snipped px-3 py-2" :disabled="pagination.current_page <= 1" @click="goPrev">
                            ‹ Înapoi
                        </button>

                        <template v-if="pageWindow.start > 1">
                            <button class="btn btn-sm btn-teal snipped px-3 py-2" @click="goToPage(1)">1</button>
                            <span class="px-1">…</span>
                        </template>

                        <button v-for="n in pageNumbers" :key="'p-'+n" @click="goToPage(n)"
                                :class="['snipped px-3 py-2', n === pagination.current_page ? 'btn btn-sm btn-teal' : 'btn btn-sm btn-teal']">
                            {{ n }}
                        </button>

                        <template v-if="pageWindow.end < pagination.last_page">
                            <span class="px-1">…</span>
                            <button class="btn btn-sm btn-teal snipped px-3 py-2" @click="goToPage(pagination.last_page)">{{ pagination.last_page }}</button>
                        </template>

                        <button class="btn btn-sm btn-teal snipped px-3 py-2" :disabled="pagination.current_page >= pagination.last_page" @click="goNext">
                            Înainte ›
                        </button>
                        <button class="btn btn-sm btn-teal snipped px-3 py-2" :disabled="pagination.current_page >= pagination.last_page" @click="goLast">
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
const sp = computed(() => page.props.starting_prices || {});
const roomsFilter = ref(String(filters.value.camere ?? 'toate'));
// Prevent navigation loops when roomsFilter is updated from server props
const suppressNav = ref(false);
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
    roomsFilter.value = String(val ?? 'toate');
}

// Keep roomsFilter in sync with backend-provided filters.camere (after navigation)
watch(() => filters.value.camere, (val) => {
    const normalized = String(val ?? 'toate');
    if (roomsFilter.value !== normalized) {
        suppressNav.value = true;
        roomsFilter.value = normalized;
    }
});

// When roomsFilter changes locally, navigate to refresh the list unless we just synced from server
watch(roomsFilter, (val) => {
    if (suppressNav.value) { suppressNav.value = false; return; }
    const data = { camere: val || 'toate' };
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

function formatPrice(num) {
    if (num == null) return '';
    try {
        return new Intl.NumberFormat('ro-RO', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(Number(num));
    } catch (e) {
        return `${Math.round(Number(num))} €`;
    }
}
</script>

<style scoped>
    .paginator .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        border: 1px solid #28A7B2;
        background-color: #28A7B2;
        color: #FFFFFF;
    }

    .room-filter-col {
        position: relative;
    }

    .room-filter-col:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -1px;
        top: 18%;
        bottom: 18%;
        width: 1px;
        background: white;
        z-index: 1;
    }

    .room-filter-col:first-child button {
        clip-path: polygon(0 0,100% 0,100% 100%,15px 100%,0 calc(100% - 15px));
    }

    table tbody td {
        white-space: nowrap;
    }

    @media (max-width: 575px) {
        .room-filter-col:nth-child(1)::after,
        .room-filter-col:nth-child(3)::after {
            content: none;
        }

        .room-filter-col:first-child button {
            clip-path: none;
        }

        .room-filter-col:nth-child(4) button {
            clip-path: polygon(0 0,100% 0,100% 100%,15px 100%,0 calc(100% - 15px));
        }
    }
</style>