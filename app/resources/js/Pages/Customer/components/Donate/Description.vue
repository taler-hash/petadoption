<template>
    <div class="w-full p-4 px-8 grid place-items-center">
        <div class="max-w-7xl text-center space-y-7 space-y-10 flex flex-wrap justify-center mt-10">
            <p class="text-amber-600 font-medium text-2xl">
                As a non-profit organization, Pawprints Project operates and relies heavily on donations from people like
                you.
            </p>
            <p class="text-lg font-fig text-justify">
                We are always called upon to rescue animals suffering from abandonment, abuse, injury or neglect.
                Whether it’s a street dog or cat in need of medical treatment or our ongoing fight against Animal
                Cruelty in the Philippines, none of it is possible without your support.
            </p>
            <div v-for="count in counts" class="text-center px-10 py-16">
                <p class="text-7xl text-orange-600"><CountUp :end-val="count.count"/></p>
                <p class="text-3xl text-amber-500">{{ count.description }}</p>
            </div>
            <p class="font-fig text-lg text-justify">
                Please donate when you can. Every little thing helps for our rescues. Seeing them smile and then sleep
                so well after a good meal makes all the effort and struggles worth it.
            </p>
            <div class="font-fig text-lg text-start w-full">
                For tracking purposes, kindly send your proof of donation to: <span class="font-sans text-orange-500">donations@pawprints.org.</span>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import CountUp from 'vue-countup-v3'

const counts = ref<any>([
    {
        count: 1,
        description: 'Shelter Location'
    },
    {
        count: 600,
        description: 'Rescue Sheltered'
    },
    {
        count: 2000,
        description: 'Rescued'
    },
    {
        count: 12000,
        description: 'Weekly Expenses'
    },
]
)
</script>