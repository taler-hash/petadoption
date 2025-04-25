<template>
    <Head title="Paw Prints - Stray" />
    <CustomerLayout>
        <div class="w-full flex justify-center">
            <div class="w-full space-y-20 flex flex-col">
                <Header />
                <Description />
                <Divider />
                <Form />
                <Footer />
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup lang="ts">
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
import Header from './components/Report/Header.vue';
import Description from './components/Report/Description.vue';
import Divider from './components/Report/Divider.vue';
import Form from './components/Report/Form.vue';
import Footer from '@/Components/Footer.vue';
</script>
