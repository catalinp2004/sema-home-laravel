<template>
    <footer class="d-flex flex-column align-items-center pad-top pad-bottom">
        <div class="d-flex flex-column flex-lg-row align-items-center mb-4 text-black">
            <a href="https://anpc.ro/" target="_blank" rel="noopener noreferrer" class="mx-4 text-black"><small>ANPC</small></a>
            <Link :href="route('cookies')" class="mx-4 text-black"><small>Politică de cookie-uri</small></Link>
            <Link :href="route('privacy')" class="mx-4 text-black"><small>Politică de confidențialitate</small></Link>
            <Link :href="route('personal.data')" class="mx-4 text-black"><small>Date cu caracter personall</small></Link>
        </div>
        <p class="mb-5 text-center px-5"><small>Copyright © 2025 Sema Parc S.A. Toate drepturile rezervate.</small></p>
        <div class="d-flex flex-column flex-xl-row flex-no-wrap justify-content-center align-items-center mb-5">
            <a href="https://anpc.ro/ce-este-sal/" target="_blank" rel="noopener noreferrer" class="mx-2 mb-3 mb-xl-0 flex-shrink-0">
                <img src="/images/logo_sal.svg" class="img-fluid" alt="Solutionarea alternativa a litigiilor">
            </a>
            <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener noreferrer" class="mx-2 mb-3 mb-xl-0 flex-shrink-0">
                <img src="/images/logo_sol.svg" class="img-fluid" alt="Solutionarea online a litigiilor">
            </a>
        </div>
        <div class="d-flex align-items-center">
            <span class="d-inline-block me-3 opacity-50">Un proiect</span>
            <a href="https://sema.ro" target="_blank" rel="noopener noreferrer" class="d-inline-block">
                <img src="/images/logo_grey.svg" class="img-fluid" alt="">
            </a>
        </div> 
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>