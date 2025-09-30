<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="d-flex flex-column align-items-center min-vh-100 bg-light pt-4 justify-content-sm-center pt-sm-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="d-inline-block" />
            </Link>
        </div>

        <div class="mt-4 overflow-hidden bg-white p-5 shadow rounded-3 mx-auto col-12 col-sm-8 col-md-6 col-lg-4">
            <slot />
        </div>
    </div>
</template>
