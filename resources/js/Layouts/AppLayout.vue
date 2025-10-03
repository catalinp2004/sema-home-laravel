<template>
    <Nav />
    <div class="smooth-wrapper" ref="smootherWrapper">
        <div class="smooth-content">
            <slot />
            <FooterForm v-if="!route().current('contact')" />
            <Footer />
        </div>
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
        const { gsap, ScrollSmoother } = await useGsap();

        // Create ScrollSmoother if available and wrapper exists
        if (ScrollSmoother && smootherWrapper.value && typeof ScrollSmoother.create === 'function') {
            // create with reasonable defaults; tweak as needed
            smootherInstance = ScrollSmoother.create({
                wrapper: smootherWrapper.value,
                content: smootherWrapper.value.querySelector('.smooth-content'),
                smooth: 1.25,
                effects: true,
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

@media (max-width: 991px) {
    .smooth-content { padding-top: 78px; }
}
</style>
