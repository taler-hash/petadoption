<template>
    <div class="w-full grid place-items-center">
        <div class="max-w-7xl flex flex-col items-center">
            <p class="text-4xl pb-12">
                How You Can Help
            </p>
            <div class="flex flex-wrap items-center justify-center">
                    <div v-for="card in cards" class="w-72 m-5 space-y-4 rounded-lg border px-6 py-2 h-96 flex flex-col justify-start text-gray-200 bg-green-800">
                        <div>
                            <p class="text-center text-3xl font-bold text-amber-500">{{ card.title }}</p>
                        </div>
                        <div class="self-center">
                            <p class="font-fig font-medium text-justify">{{ card.description }}</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import { Card } from 'primevue';

const cards = ref<any>([
    {
        title: 'Donate',
        description: `
            As a non-profit organization, PAWPRINTS: INTEGRATED SOLUTION 
            FOR ANIMAL WELFARE AND ADOPTION SERVICES operates and 
            relies heavily on donations from the community. We are always 
            called upon to rescue animals suffering from abandonment, 
            abuse, injury or neglect and none of it is possible 
            without your support.
        `,
        callback: ''
    },
    {
        title: 'Adopt',
        description: `
            Many of our Adoptables in Animal Welfare Shelters have been rescued 
            from death row, from local pounds or from abusive environments. 
            By choosing to adopt, you are giving them the chance to find a new 
            home and to feel the love and security they deserve.
        `,
        callback: ''
    },
    {
        title: 'Sponsor',
        description: `
            While not everyone can foster or adopt, there are always other 
            ways to help our rescues. Through our Sponsor-A-Rescue Program, 
            our rescues now have a wonderful support system rooting for their 
            full recovery and continuous comfort while at the shelter.
        `,
        callback: ''
    }

])
</script>