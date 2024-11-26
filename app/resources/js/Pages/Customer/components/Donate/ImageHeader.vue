<template>
    <div class="w-full relative">
        <div class="absolute w-full h-full bg-black/25"></div>
        <div
            class="absolute bottom-0 w-full h-full grid place-items-center text-center text-white font-black text-sm sm:text-2xl lg:text-6xl">
            Donate You can make a difference today.
        </div>
        <img :src="Image1" class="w-full max-h-[700px] object-cover object-top"/>
    </div>
</template>
<script setup lang="ts">
import { Image1 } from '@/assets/Donate/donateImage';
</script>