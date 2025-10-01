<template>
    <div class="bg-dark-blue large-pad pad-top pad-bottom">
        <div class="limited-container">
            <div class="row">
                <div class="col-xl-5 offset-xl-1 flex-column justify-content-start align-items-start mb-5">
                    <img src="/images/logo_sema_home_dark.svg" class="img-fluid mb-4" alt="Sema Home Logo">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-xl-4 offset-lg-1">
                    <Form />
                </div>
                <div class="col-lg-5 offset-lg-1 col-xl-4 offset-xl-2 mt-5">
                    <div class="row gx-5">
                        <div class="col-md-6 col-lg-12 d-flex flex-column align-items-center align-items-md-start">
                            <img src="/images/logo_sema_realestate_white.svg" class="img-fluid mb-4">
                            <img src="/images/logo_sema_parc_white.svg" class="img-fluid mb-4">
                            <img src="/images/logo_fundatia_sema_white.svg" class="img-fluid">
                        </div>
                        <div class="col-md-6 col-lg-12 d-flex flex-column align-items-center align-items-md-start mt-5 mt-md-0 mt-lg-5 mb-5">
                            <ContactDetails compact dark />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import Form from './Form.vue';
    import ContactDetails from './ContactDetails.vue';
</script>