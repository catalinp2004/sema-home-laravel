<template>
    <div class="row">
        <div class="col-12 mb-5">
            <p class="text-m fw-semibold tk-obvia text-center text-md-start">319L Splaiul Independenței,<br :class="{ 'd-none': !compact }"> Sema Parc, Clădirea Paris,<br>lângă intrarea C, parter<br :class="{ 'd-none': !compact }">Sector 6, București, România</p>
        </div>
        <div class="d-flex flex-column align-items-center align-items-md-start" :class="compact ? 'col-lg-12' : 'col-lg-6'">
            <p class="text-m tk-obvia fw-semibold">Contactează-ne</p>
            <a href="tel:+40748108020" class="d-flex align-items-center mb-3" :class="dark ? 'text-white' : 'text-black'">
                <img src="/images/icon_phone_teal.svg" class="img-fluid me-3" :class="{ 'white': dark }" alt="">
                <span class="tk-obvia">+40 748 108 020</span>
            </a>
            <a href="tel:+40748109070" class="d-flex align-items-center mb-3" :class="dark ? 'text-white' : 'text-black'">
                <img src="/images/icon_phone_teal.svg" class="img-fluid me-3" :class="{ 'white': dark }" alt="">
                <span class="tk-obvia">+40 748 109 070</span>
            </a>
            <a href="mailto:sales@semahome.ro" class="d-flex align-items-center" :class="dark ? 'text-white' : 'text-black'">
                <img src="/images/icon_mail_teal.svg" class="img-fluid me-3" :class="{ 'white': dark }" alt="">
                <span class="tk-obvia">sales@semahome.ro</span>
            </a>
        </div>
        <div class="d-flex flex-column align-items-center align-items-md-start mt-5" :class="compact ? 'col-lg-12' : 'col-lg-6 mt-lg-0'">
            <p class="text-m fw-medium tk-obvia fw-semibold">Urmărește-ne pe</p>
            <div class="d-flex align-items-center">
                <a href="#">
                    <img src="/images/icon_facebook_teal.svg" class="img-fluid" :class="{ 'white': dark }" alt="">
                </a>
                <a href="#">
                    <img src="/images/icon_instagram_teal.svg" class="img-fluid mx-4" :class="{ 'white': dark }" alt="">
                </a>
                <a href="#">
                    <img src="/images/icon_linkedin_teal.svg" class="img-fluid" :class="{ 'white': dark }" alt="">
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        compact: {
            type: Boolean,
            default: false,
        },

        dark: {
            type: Boolean,
            default: false,
        },
    });
</script>

<style scoped>
    .white {
        filter: brightness(0) invert(1);
    }
</style>