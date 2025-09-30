<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    // Password reset is disabled in this project
    canResetPassword: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="alert alert-success" role="alert">
            {{ status }}
        </div>

        <form @submit.prevent="submit" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    :class="{ 'is-invalid': form.errors.email }"
                />
                <div v-if="form.errors.email" class="invalid-feedback d-block">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    :class="{ 'is-invalid': form.errors.password }"
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mb-3 form-check">
                <input
                    id="remember"
                    type="checkbox"
                    class="form-check-input"
                    v-model="form.remember"
                />
                <label for="remember" class="form-check-label">Remember me</label>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-light bg-teal w-100 py-2 mt-4" :disabled="form.processing">
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Log in
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped>
    form {
        max-width: 400px;
        margin: auto;
    }
</style>