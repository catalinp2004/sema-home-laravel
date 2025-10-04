<template>
  <AppLayout>
    <Head title="Developer" />
    <div class="large-pad pt-5">
        <div class="limited-container">
            <div class="row gx-5 margin-bottom">
                <div class="col-2 col-lg-1 d-flex justify-content-start">
                    <TitleDecoration />
                </div>
                <div class="col-10 col-md-9 col-lg-5 mb-5 mb-lg-0">
                    <div class="d-flex flex-column flex-md-row flex-lg-column flex-xl-row justify-content-between align-items-start align-items-md-center align-items-lg-start align-items-xl-center mb-5">
                        <a href="https://sema.ro" target="_blank" rel="noopener noreferrer" class="highlight-on-hover mb-5 mb-md-0 mb-lg-5 mb-xl-0">
                            <img src="/images/logo_sema_realestate.svg" alt="Logo Sema Real Estate">
                        </a>
                        <a href="https://the-light.ro" target="_blank" rel="noopener noreferrer" class="highlight-on-hover">
                            <img src="/images/logo_the_light.svg" alt="Logo The Light">
                        </a>
                    </div>
                    <h2 class="mb-3 mb-sm-4 mb-md-5 text-obvia">Un Dezvoltator <br class="d-none d-lg-inline" />cu <span class="text-teal">Viziune</span></h2>
                    <p class="mb-5">SEMA Real Estate este un investitor și dezvoltator imobiliar cu capital românesc, cu activitate de peste 20 ani pe piața locală, susținut de o echipă de profesioniști cu o vastă experiență în planificarea, dezvoltarea și gestionarea proiectelor imobiliare de mare anvergură.</p>
                    <h4 class="text-obvia fw-medium fs-5 mb-4">Misiunea noastră</h4>
                    <p class="mb-5">Esența noastră ca dezvoltator imobiliar este aceea de a fi un partener pentru toți cei care cred într-o dezvoltare imobiliară inteligentă și atentă la nevoile comunității.</p>
                    <a href="#" class="btn btn-icon btn-teal d-inline-flex align-items-center text-obvia snipped" alt="">
                        <img src="/images/icon_external_link.svg" class="img-fluid" alt="">
                        <span class="text-nowrap">Vezi detalii</span>
                    </a>
                </div>
                <div class="col-sm-10 offset-sm-1 col-md-12 offset-md-0 col-lg-6 col-xl-5 offset-xl-1 ">
                    <div class="bg-dark-blue text-obvia text-white snipped p-5">
                        <div class="row">
                            <div class="col-md-6 col-lg-12 mb-5">
                                <p class="fw-normal fs-4 lh-sm mb-2">Mai mult de</p>
                                <p class="lh-1 mb-0"><span class="text fw-medium stat">965&nbsp;000</span> <span class="mp position-absolute fw-300">mp</span></p>
                                <p class="fs-4 lh-sm mb-0">Supratață total construită</p>
                            </div>
                            <div class="col-md-6 col-lg-12 mb-5">
                                <p class="fw-normal fs-4 lh-sm mb-2">Mai mult de</p>
                                <p class="lh-1 mb-0"><span class="text fw-medium stat">93&nbsp;000</span> <span class="mp position-absolute fw-300">mp</span></p>
                                <p class="fs-4 lh-sm mb-0">Supratață total construită (retail)</p>
                            </div>
                            <div class="col-md-6 col-lg-12 mb-5">
                                <p class="fw-normal fs-4 lh-sm mb-2">Mai mult de</p>
                                <p class="lh-1 mb-0"><span class="text fw-medium stat">305&nbsp;000</span> <span class="mp position-absolute fw-300">mp</span></p>
                                <p class="fs-4 lh-sm mb-0">Supratață total construită (rezidențial)</p>
                            </div>
                            <div class="col-md-6 col-lg-12 mb-0">
                                <p class="fw-normal fs-4 lh-sm mb-2">Mai mult de</p>
                                <p class="lh-1 mb-0"><span class="text fw-medium stat">527&nbsp;000</span> <span class="mp position-absolute fw-300">mp</span></p>
                                <p class="fs-4 lh-sm mb-0">Supratață total construită (birouri)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-beige">
                <div class="row pad-top pad-bottom margin-bottom gx-5">
                    <div class="offset-2 col-md-10 offset-md-2 offset-lg-1 mb-5">
                        <TitleDecoration class="start-0" />
                        <img src="/images/logo_fundatia_sema.svg" alt="Fundația Sema" class="fundatia-logo">
                    </div>
                    <div class="col-auto offset-2 offset-lg-1 mb-5 mb-lg-0">
                        <img src="/images/oana_radulea-250.webp" alt="Oana Rădulea" class="img-fluid snipped">
                    </div>
                    <div class="offset-2 col col-md-9 offset-md-2 col-lg offset-lg-0">
                        <p class="mb-4 mb-md-5">Suntem motivați să facem bine făcând mai bine – atât în slujba celorlalți, cât și în a sprijini cauzele care duc la schimbări pozitive în societatea noastră. Conduși de această dorința de a face bine, am înființat anul acesta Fundația SEMA cu scopul de a promova și sustine un stil de viață sănătos, atât prin acțiuni de prevenție cât și prin intervenții materiale, suport psihologic și emotional.</p>
                        <p class="text-obvia fw-medium mb-0 fs-5">Oana Rădulea</p>
                        <p class="fs-6">Managing Partner SEMA Real Estate</p>
                    </div>
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

.mp {
    font-size: 2rem;
    margin-left: .5rem;
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

@media (max-width: 992px) {
    .stat {
        font-size: 3rem;
    }

    .stat::before {
        content: '';
        position: absolute;
        width: .875rem;
        height: .875rem;
        border-top: 3px solid #27A9B5;
        border-right: 3px solid #27A9B5;
        transform: rotate(45deg);
        left: -1.5rem;
        top: .5rem;
    }

    .mp {
        font-size: 1.5rem;
        margin-left: .25rem;
    }
}

@media (max-width: 576px) {
    .fundatia-logo {
        max-width: 150px;
    }
}
</style>
