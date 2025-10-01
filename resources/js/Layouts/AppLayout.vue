<template>
    <Nav />
    <!-- Wrapper for ScrollSmoother: .smooth-wrapper stays fixed while .smooth-content scrolls -->
    <div class="smooth-wrapper" ref="smootherWrapper">
        <div class="smooth-content">
            <slot />
            <FooterForm v-if="!route().current('contact')" />
            <Footer />
        </div>
    </div>
    <div class="d-flex flex-column align-items-center pt-4 justify-content-sm-center pt-sm-0 d-lg-none mobile-guard">
        <ApplicationLogo class="d-inline-block" />
        <p class="text-center fs-6 mt-5 mb-0">Mobile layout under development.</p>
        <p class="fs-6">Check back soon.</p>
    </div>
</template>

<script setup>
import Nav from './components/Nav.vue';
import FooterForm from './components/FooterForm.vue';
import Footer from './components/Footer.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useGsap } from '@/composables/useGsap';

const smootherWrapper = ref(null);
let smootherInstance = null;

onMounted(async () => {
    // Initialize GSAP and plugins lazily (browser-only)
    try {
        // Skip smoother on small screens to avoid stacking/transform issues with mobile guard
        const isSmall = typeof window !== 'undefined' && window.matchMedia && (
            window.matchMedia('(max-width: 991.98px)').matches ||
            window.matchMedia('(pointer: coarse)').matches
        );
        if (isSmall) return;

        const { gsap, ScrollSmoother } = await useGsap();

        // Create ScrollSmoother if available and wrapper exists
        if (ScrollSmoother && smootherWrapper.value && typeof ScrollSmoother.create === 'function') {
            // create with reasonable defaults; tweak as needed
            smootherInstance = ScrollSmoother.create({
                wrapper: smootherWrapper.value,
                content: smootherWrapper.value.querySelector('.smooth-content'),
                smooth: 1.25,
                effects: true,
                normalizeScroll: true,
            });
        }
    } catch (e) {
        // If GSAP or plugins fail to load, silently continue; site remains scrollable
        console.warn('GSAP init failed', e);
    }
});

onBeforeUnmount(() => {
    try {
        if (smootherInstance && typeof smootherInstance.kill === 'function') {
            smootherInstance.kill();
            smootherInstance = null;
        }
    } catch (e) {
        // ignore
    }
});
</script>

<style scoped>
.smooth-content { padding-top: 97px; }
.mobile-guard {
    position: fixed; /* don't rely solely on Bootstrap utility */
    inset: 0; /* top:0; right:0; bottom:0; left:0 */
    width: 100vw;
    height: 100vh;
    z-index: 2147483647; /* above any smoother/transform contexts */
    background: #fff; /* ensure solid backdrop */
}
</style>
