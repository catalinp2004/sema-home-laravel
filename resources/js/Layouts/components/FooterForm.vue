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
                    <form id="contact-form" action="" method="POST">
                        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>">
                        <div class="form-group mb-4">
                            <label for="name" class="fw-bolder mb-1 text-uppercase">Nume*</label>
                            <input type="text" class="form-control snipped" id="name" name="name" placeholder="Numele tău">
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" class="fw-bolder mb-1 text-uppercase">E-mail*</label>
                            <input type="text" class="form-control snipped" id="email" name="email" placeholder="ADRESA@EMAIL.COM">
                        </div>
                        <div class="form-group mb-4">
                            <label for="phone" class="fw-bolder mb-1 text-uppercase">Telefon*</label>
                            <input type="text" class="form-control snipped" id="phone" name="phone" placeholder="07XX XXX XXX">
                        </div>
                        <div class="form-group mb-4">
                            <label for="apartment_type" class="fw-bold mb-1 text-uppercase">Mă interesează*</label>
                            <select id="apartment_type" class="form-select snipped" name="apartment_type">
                                <option selected disabled hidden>Selectează tipul apartamentului</option>
                                <option value="Studio">Studio</option>
                                <option value="2 camere">2 camere</option>
                                <option value="3 camere">3 camere</option>
                                <option value="4 camere">4 camere</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="message" class="fw-bolder mb-1 text-uppercase">Mesajul tău</label>
                            <textarea class="form-control snipped" id="message" name="message" rows="6" placeholder="SCRIE AICI MESAJUL TĂU (Opțional)"></textarea>
                        </div>
                        <div class="form-check d-flex justify-content-start w-100 mb-3">
                            <input type="checkbox" class="form-check-input" id="agree" name="agree">
                            <label class="form-check-label ms-2" for="agree">Sunt de acord cu <a href="#" class="text-white fs-6">Termenii de confidențialitate</a></label>
                        </div>
                        <p class="mb-5 text-start mx-auto recaptcha-terms fs-7"><small>Acest site este protejat de reCAPTCHA și se aplică <a href="https://policies.google.com/privacy?hl=ro" target="_blank" rel="noopener" class="fs-7 text-white fw-bold">Politica de confidențialitate</a> și <a href="https://policies.google.com/terms?hl=ro" target="_blank" rel="noopener" class="fs-7 text-white fw-bold">Termenii și condițiile</a> Google.</small></p>
                        <button type="submit" class="btn btn-arrow btn-teal snipped d-flex align-items-center mx-auto tk-obvia text-nowrap">Trimite cererea</button>
                        <div class="col-12 text-center mt-4" id="result"></div>
                    </form>
                </div>
                <div class="col-lg-5 offset-lg-1 col-xl-4 offset-xl-2 mt-5">
                    <div class="row gx-5">
                        <div class="col-md-6 col-lg-12 d-flex flex-column align-items-center align-items-md-start mb-5">
                            <img src="/images/logo_sema_realestate_white.svg" class="img-fluid mb-4">
                            <img src="/images/logo_sema_parc_white.svg" class="img-fluid mb-4">
                            <img src="/images/logo_fundatia_sema_white.svg" class="img-fluid">
                            <p class="text-m fw-semibold tk-obvia mt-5 mb-0 text-center text-md-start">319L Splaiul Independenței,<br> Sema Parc, Clădirea Paris,<br>lângă intrarea C, parter<br>Sector 6, București, România</p>
                        </div>
                        <div class="col-md-6 col-lg-12 d-flex flex-column align-items-center align-items-md-start mb-5">
                            <p class="text-m tk-obvia fw-semibold">Contactează-ne</p>
                            <a href="tel:+40748108020" class="d-flex align-items-center mb-3 text-white">
                                <img src="/images/icon_phone.svg" class="img-fluid me-3" alt="">
                                <span class="tk-obvia">+40 748 108 020</span>
                            </a>
                            <a href="tel:+40748109070" class="d-flex align-items-center mb-3 text-white">
                                <img src="/images/icon_phone.svg" class="img-fluid me-3" alt="">
                                <span class="tk-obvia">+40 748 109 070</span>
                            </a>
                            <a href="mailto:sales@semahome.ro" class="d-flex align-items-center text-white">
                                <img src="/images/icon_mail.svg" class="img-fluid me-3" alt="">
                                <span class="tk-obvia">sales@semahome.ro</span>
                            </a>
                            <p class="text-m fw-medium tk-obvia fw-semibold mt-5">Urmărește-ne pe</p>
                            <div class="d-flex align-items-center">
                                <a href="#">
                                    <img src="/images/icon_facebook.svg" class="img-fluid" alt="">
                                </a>
                                <a href="#">
                                    <img src="/images/icon_instagram.svg" class="img-fluid mx-4" alt="">
                                </a>
                                <a href="#">
                                    <img src="/images/icon_linkedin.svg" class="img-fluid" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>