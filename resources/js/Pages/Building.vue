<template>
  <AppLayout>
    <Head title="Building" />
    <div>
      <h1>Building</h1>
      <pre>{{ $page.props }}</pre>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
