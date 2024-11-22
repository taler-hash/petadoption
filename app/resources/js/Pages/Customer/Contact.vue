<template>
    <Head title="Paw Prints - Contact us" />
    <CustomerLayout>
        <div class="w-full flex justify-center h-screen">
            <div class="w-full space-y-20 flex flex-col h-full justify-between">
                <Header />
                <Description />
                <Footer />
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup lang="ts">
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
import Header from './components/Contact/Header.vue';
import Description from './components/Contact/Description.vue';
import Footer from '@/Components/Footer.vue';
</script>
