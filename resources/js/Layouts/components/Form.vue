<template>
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
</template>

<script setup>

</script>