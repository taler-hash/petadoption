<template>
    <Head title="Paw Prints - Adopt" />
    <CustomerLayout>
        <div class="w-full flex justify-center">
            <div class="w-full space-y-20">
                <Header />
                <Description />
                <Divider />
                <Animals />
                <Footer />
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup lang="ts">
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
import Header from './components/Adopt/Header.vue';
import Description from './components/Adopt/Description.vue';
import Divider from './components/Adopt/Divider.vue';
import Animals from './components/Adopt/Animals.vue';
import Footer from '@/Components/Footer.vue';
</script>
