<template>

    <Head title="Main" />
    <CustomerLayout>
        <div class="w-full flex justify-center">
            <div class="w-full space-y-32">
                <Carousel />
                <About />
                <HowYouCanHelp />
                <Count />
                <Footer />
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup lang="ts">
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
import Carousel from '@/Pages/Customer/components/Welcome/Carousel.vue';
import About from './components/Welcome/About.vue';
import Count from './components/Welcome/Count.vue';
import HowYouCanHelp from './components/Welcome/HowYouCanHelp.vue';
import Footer from '@/Components/Footer.vue';
</script>
