<template>
    <div class="w-full p-20 px-8 bg-orange-700 grid place-items-center">
        <div class="max-w-7xl flex flex-wrap justify-center">
            <div v-for="count in counts" class="text-slate-200 text-center p-16">
                <p class="text-7xl"><CountUp :end-val="count.count"/></p>
                <p class="text-3xl">{{ count.description }}</p>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import CountUp from 'vue-countup-v3'
const counts = ref<any>([
    {
        count: 640,
        description: 'Sheltered'
    },
    {
        count: 2500,
        description: 'Rescued'
    },
    {
        count: 3800,
        description: 'Spayed & Neutered'
    },
    {
        count: 1000,
        description: 'Rehomed'
    },
]
)

</script>