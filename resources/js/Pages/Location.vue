<template>
  <AppLayout>
    <Head title="Location" />
        <div class="large-pad pt-5">
            <div class="limited-container">
                <div class="row gx-5 mb-xl-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-lg-4">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Puncte de <br class="d-none d-lg-inline" /><span class="text-teal">interes</span></h2>
                        <p><strong>Există numeroase opțiuni de shopping și entertainment, dar și educație și sănătate.</strong></p>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-1">
                        Amplasarea strategică a proiectului permite accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului (prin Șoseaua Virtuții)și spre Militari (ieșind direct în Bulevardul Iuliu Maniu).
                    </div>
                </div>

                <div class="position-relative margin-bottom-large">
                    <img src="/images/map_bg.jpg" class="w-100 h-auto" alt="">
                </div>

                <div class="row gx-5 my-xl-5">
                    <div class="col-2 col-lg-1 d-flex justify-content-start position-relative">
                        <TitleDecoration />
                    </div>
                    <div class="col-lg-4">
                        <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Accesibilitate</h2>
                        <p><strong>Sema Home se află amplasat în interiorul Sema Parc, la distanță de zgomotul traficului și al vieții agitate din capitală.</strong></p>
                        <p>Amplasarea strategica a proiectului permit accesul facil la 2 magistrale de metrou (M1 si M3), precum și posibilitatea de a ajunge cu ușurință în trei direcții importante ale orașului: spre centru (Piața Victoriei și Piața Unirii), spre zona de nord a orașului prin Șoseaua Virtuții și spre Militari, ieșind direct în Bulevardul Iuliu Maniu.</p>
                    </div>
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-1">
                        <img src="/images/access.png" class="w-100 h-auto" alt="">
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
</script>
