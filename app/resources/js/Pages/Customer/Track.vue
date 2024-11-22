<template>
    <Head title="Paw Prints - Track" />
    <CustomerLayout>
        <div class="w-full flex justify-center">
            <div class="w-full space-y-20 flex flex-col">
                <Header />
                <Description />
                <Divider />
                <TrackStatus />
                <Footer />
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup lang="ts">
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
import Header from './components/Track/Header.vue';
import Description from './components/Track/Description.vue';
import Divider from './components/Track/Divider.vue';
import TrackStatus from './components/Track/TrackStatus.vue';
import Footer from '@/Components/Footer.vue';
</script>
