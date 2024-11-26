<template>
    <Head title="Paw Prints - Donate" />
    <CustomerLayout>
        <ImageHeader />
        <Description />
        <Donation />
        <Footer />
    </CustomerLayout>
</template>
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import ImageHeader from './components/Donate/ImageHeader.vue';
import Description from './components/Donate/Description.vue';
import Donation from './components/Donate/Donation.vue';
import Footer from '@/Components/Footer.vue';
</script>