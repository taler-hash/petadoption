<template>
    <div class="w-full p-20 px-8 grid place-items-center">
        <div class="max-w-7xl flex flex-wrap justify-center space-y-8">
            <div class="w-full p-3 bg-green-700 text-amber-500 text-3xl text-center">
                Official Donation Channels
            </div>
            <div class="w-full flex flex-wrap justify-center">
                <div v-for="mode in modeDonation" class="w-48 m-10 space-y-3 flex flex-col items-center">
                    <img :src="mode.image" alt="" class="w-96 object-contain">
                    <p class="text-amber-600 font-medium text-lg">{{ mode.holder }}</p>
                    <p class="font-sans text-lg">{{ mode.number }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { GcashLogo, PayMayaLogo, PaypalLogo, BDOLogo } from '@/assets/Donate/donateImage';

const modeDonation = [
    {
        image: GcashLogo,
        holder: 'PawPrints',
        number: '0912345678'
    },
    {
        image: PayMayaLogo,
        holder: 'PawPrints',
        number: '0912345678'
    },
    {
        image: PaypalLogo,
        holder: 'PawPrints Foundations',
        number: '@pawprintsfoundationph'
    },
    {
        image: BDOLogo,
        holder: 'PawPrints',
        number: '012345767777'
    },
]
</script>