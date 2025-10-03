<template>
    <nav class="navbar navbar-expand-xl w-100 tk-obvia position-fixed">
        <div class="large-pad d-flex align-items-center w-100">
            <div class="row w-100 flex-grow-1 align-items-center">
                <Link class="navbar-brand col-auto me-auto" :href="route('home')">
                    <img src="/images/logo_sema_home.svg" class="img-fluid" alt="Sema Home Logo">
                </Link>
                <div class="collapse navbar-collapse col-5 col-xl-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav text-center pt-4 pt-xl-0">
                        <li class="nav-item">
                            <Link :href="route('project')" class="nav-link" :class="{ active: route().current('project') }"><span>Despre proiect</span></Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('location')" class="nav-link" :class="{ active: route().current('location') }"><span>Localizare</span></Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('apartments')" class="nav-link" :class="{ active: route().current('apartments') }"><span>Apartamente</span></Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('developer')" class="nav-link" :class="{ active: route().current('developer') }"><span>Dezvoltator</span></Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('contact')" class="nav-link mb-0" :class="{ active: route().current('contact') }"><span>Contact</span></Link>
                        </li>
                    </ul>
                </div>
                <div class="col-auto me-3 order-xl-3">
                    <span class="lang-active">RO</span>
                    <span class="mx-2">|</span>
                    <span>EN</span>
                </div>
                <div class="col-auto">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';

</script>

<style scoped>
    .nav-link {
        font-weight: 500;
        white-space: nowrap;
        color: #000000;
    }

    .nav-link span {
        position: relative;
    }

    .nav-link.active span::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 0;
        width: 100%;
        border-top: 6px solid #88CDD2;
    }

    .navbar-collapse {
        flex-grow: 0;
        background-color: #ffffff;
        order: 4;
    }

    .navbar-brand {
        min-width: 150px;
    }

    .navbar {
        --bs-navbar-nav-link-padding-x: 1rem;
        --bs-navbar-padding-y: 1rem;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 99;
        background-color: #ffffff;
    }

    @media (max-width: 575px) {
        .navbar-brand {
            min-width: auto;
            max-width: 135px;
        }
    }

    @media (max-width: 1199px) {
        .nav-link.active span::after {
            bottom: -8px;
        }
    }

    @media (min-width: 1200px) {
        .navbar-collapse {
            order: 2;
            margin-right: auto;
        }
    }

    @media (min-width: 1800px) {
        .navbar-brand {
            order: 2;
            flex: 0 0 auto;
            width: 16.66666667%;
        }
        .navbar-collapse {
            order: 1;
            flex: 0 0 auto;
            width: 41.66666667%;
            margin-right: 0;
        }
    }
</style>