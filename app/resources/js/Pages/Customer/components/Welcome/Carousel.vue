<template>
    <Carousel :value="carouselOptions" :numVisible="1" :numScroll="1" circular :autoplayInterval="6000">
        <template #item="slotProps">
            <div class="relative">
                <div class="absolute w-full h-full bg-black/25"></div>
                <div class="absolute bottom-0 w-full h-full grid place-items-center text-center text-white font-black text-sm sm:text-2xl lg:text-6xl">
                    {{ slotProps.data.description }}
                </div>
                <img :src="slotProps.data.image" alt="" class="w-full max-h-[700px] object-cover object-top">
            </div>
        </template>
    </Carousel>
</template>
<script setup lang="ts">
import { Carousel } from 'primevue';
import { ref } from 'vue';
import * as CarouselImage from '@/assets/Welcome/carousel/carousel'

const carouselOptions = ref<any>([
    {
        description: "You can't buy Love, but you can Rescue it.",
        image: CarouselImage.carouselImage1
    },
    {
        description: "Be a part of our Mission.",
        image: CarouselImage.carouselImage2
    },
    {
        description: 'We can all do something.',
        image: CarouselImage.carouselImage3
    },
    {
        description: 'Our Mission it to Rescue.',
        image: CarouselImage.carouselImage4
    },
])
</script>