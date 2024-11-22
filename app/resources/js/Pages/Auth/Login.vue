<template>

    <Head title="Log in" />
    <div class="w-full h-screen">
        <div class="w-full h-full grid xl:grid-cols-2">
            <div class="hidden xl:block w-full h-full">
                <img :src="LoginBg" class="w-full h-screen object-cover" />
            </div>
            <div class="w-full h-full grid place-items-center bg-gray-100">
                <div class="flex flex-col items-center space-y-4">
                    <ApplicationLogo />
                    <div class="w-96 p-4 px-8 border rounded-lg shadow bg-white">

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="username" value="Username" />

                                <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username"
                                    required autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.username" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />

                                <TextInput id="password" type="password" class="mt-1 block w-full"
                                    v-model="form.password" required autocomplete="current-password" />

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                            <div class="mt-4 flex items-center justify-end">
                                <Button label="Login" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing" @click="submit" severity="success" class="w-full" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup lang="ts">
import LoginBg from '@/assets/loginbg.jpg'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from 'primevue';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>