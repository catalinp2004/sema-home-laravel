<template>
    <div class="grey-wrapper snipped d-flex justify-content-center position-absolute">
        <img src="/images/small_white_s_icon.svg" class="img-fluid mt-auto mb-3">
    </div>
</template>

<script setup>

</script>

<style scoped>
    .grey-wrapper {
        background-color: #9eacb0;
        height: 100%;
        max-height: 380px;
        width: 52px;
        border-radius: 5px;
    }

    @media (max-width: 575px) {  
        .grey-wrapper {
            width: 38px;
            max-height: 300px;
        }
    }
</style>