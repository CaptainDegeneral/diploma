<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Подтверждение email" />

        <div class="mb-4 text-sm text-gray-600">
            Спасибо за регистрацию! Прежде чем начать, пожалуйста, подтвердите
            ваш адрес электронной почты, перейдя по ссылке, которую мы только
            что отправили вам на почту. Если вы не получили письмо, мы с
            радостью отправим вам новое.
        </div>

        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            Новая ссылка для подтверждения была отправлена на адрес электронной
            почты, указанный вами при регистрации.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Отправить новое письмо
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Выйти</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
