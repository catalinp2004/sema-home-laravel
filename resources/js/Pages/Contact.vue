<template>
  <AppLayout>
    <Head title="Contact" />
        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-md-5">
                    <div class="col-1 d-flex justify-content-start position-relative-xs">
                        <TitleDecoration />
                    </div>
                    <div class="col-10 offset-1">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Contact</h2>
                    </div>
                    <div class="col-md-10 offset-md-2 offset-md-1 col-xl-5 offset-xl-1 mb-5 mb-xl-0 mt-4 mt-md-0">
                        <div class="bg-dark-blue px-3 px-sm-5 py-4 snipped">
                            <Form />
                        </div>
                    </div>
                    <div class="col-md-10 offset-md-2 offset-md-1 col-xl-5 offset-xl-0">
                        <div id="map-2" class="mb-4 w-100">
                            <img src="/images/placeholder_contact_map.jpg" class="w-100" alt="" srcset="">
                        </div>
                        <a href="https://maps.app.goo.gl/BoEF94dWan3AcTJ9A" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center mb-5 text-black">
                            <img src="/images/icon_map.svg" class="me-2" alt="">
                            <p class="mb-0">Apasă aici pentru instrucțiuni GPS</p>
                        </a>
                        <ContactDetails />
                    </div>
                </div>
            </div>
        </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TitleDecoration from '@/Components/TitleDecoration.vue';
import Form from '@/Layouts/components/Form.vue';
import ContactDetails from '@/Layouts/components/ContactDetails.vue';
</script>

<style scoped>
    @media (max-width: 767px) {
        .position-relative-xs {
            position: relative;
        }
    }

    @media (min-width: 768px) {
        #map-2 {
            min-height: 300px;
        }
    }

</style>