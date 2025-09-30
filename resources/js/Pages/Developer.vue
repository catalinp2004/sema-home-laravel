<template>
  <AppLayout>
    <Head title="Developer" />
    <div class="large-pad pt-5">
        <div class="limited-container">
            <div class="row gx-5 margin-bottom">
                <div class="col-2 col-lg-1 d-flex justify-content-start">
                    <TitleDecoration />
                </div>
                <div class="col-lg-5">
                    <img src="/images/logo_sema_realestate.svg" alt="Logo Sema Real Estate" class="mb-5">
                    <h2 class="mb-3 mb-sm-4 mb-md-5 tk-obvia">Un Dezvoltator <br class="d-none d-lg-inline" />cu <span class="text-teal">Viziune</span></h2>
                    <p class="mb-5">SEMA Real Estate este un investitor și dezvoltator imobiliar cu capital românesc, cu activitate de peste 20 ani pe piața locală, susținut de o echipă de profesioniști cu o vastă experiență în planificarea, dezvoltarea și gestionarea proiectelor imobiliare de mare anvergură.</p>
                    <h4 class="tk-obvia fw-bold fs-5 mb-4">Misiunea noastră</h4>
                    <p class="mb-5">Esența noastră ca dezvoltator imobiliar este aceea de a fi un partener pentru toți cei care cred într-o dezvoltare imobiliară inteligentă și atentă la nevoile comunității.</p>
                    <a href="#" class="btn btn-icon btn-teal d-inline-flex align-items-center tk-obvia snipped" alt="">
                        <img src="/images/icon_external_link.svg" class="img-fluid" alt="">
                        <span class="text-nowrap">Vezi detalii</span>
                    </a>
                </div>
                <div class="col-10 offset-lg-1 col-sm-7 col-lg-5">
                    <div class="bg-dark-blue tk-obvia text-white snipped p-5">
                        <div class="mb-5">
                            <p class="fw-medium fs-4 lh-sm mb-2">Mai mult de</p>
                            <p class="lh-1 mb-0"><span class="text fw-bold stat">965&nbsp;000</span> <span class="fs-1 position-absolute ms-3 fw-300">mp</span></p>
                            <p class="fs-4 lh-sm mb-0">Supratață total construită</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-medium fs-4 lh-sm mb-2">Mai mult de</p>
                            <p class="lh-1 mb-0"><span class="text fw-bold stat">93&nbsp;000</span> <span class="fs-1 position-absolute ms-3 fw-300">mp</span></p>
                            <p class="fs-4 lh-sm mb-0">Supratață total construită (retail)</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-medium fs-4 lh-sm mb-2">Mai mult de</p>
                            <p class="lh-1 mb-0"><span class="text fw-bold stat">305&nbsp;000</span> <span class="fs-1 position-absolute ms-3 fw-300">mp</span></p>
                            <p class="fs-4 lh-sm mb-0">Supratață total construită (rezidențial)</p>
                        </div>
                        <div>
                            <p class="fw-medium fs-4 lh-sm mb-2">Mai mult de</p>
                            <p class="lh-1 mb-0"><span class="text fw-bold stat">527&nbsp;000</span> <span class="fs-1 position-absolute ms-3 fw-300">mp</span></p>
                            <p class="fs-4 lh-sm mb-0">Supratață total construită (birouri)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bg-beige pad-top pad-bottom margin-bottom gx-5">
                <div class="col-lg-10 offset-lg-1 mb-5">
                    <TitleDecoration class="start-0" />
                    <img src="/images/logo_fundatia_sema.svg" alt="Fundația Sema">
                </div>
                <div class="col-lg-auto offset-lg-1">
                    <img src="/images/oana_radulea-250.webp" alt="Oana Rădulea" class="img-fluid snipped">
                </div>
                <div class="col-lg">
                    <p class="mb-5">Suntem motivați să facem bine făcând mai bine – atât în slujba celorlalți, cât și în a sprijini cauzele care duc la schimbări pozitive în societatea noastră. Conduși de această dorința de a face bine, am înființat anul acesta Fundația SEMA cu scopul de a promova și sustine un stil de viață sănătos, atât prin acțiuni de prevenție cât și prin intervenții materiale, suport psihologic și emotional.</p>
                    <p class="tk-obvia fw-bold mb-0 fs-5">Oana Rădulea</p>
                    <p class="fs-6">Managing Partner SEMA Real Estate</p>
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
</script>

<style scoped>
.stat {
    font-size: 4.5rem;
    position: relative;
}

.stat::before {
    content: '';
    position: absolute;
    width: 1.25rem;
    height: 1.25rem;
    border-top: 3px solid #27A9B5;
    border-right: 3px solid #27A9B5;
    transform: rotate(45deg);
    left: -2rem;
    top: .75rem;
}
</style>
