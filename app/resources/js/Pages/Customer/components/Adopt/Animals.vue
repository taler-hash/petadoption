<template>
    <div class="w-full p-4 px-8 grid place-items-center">
        <Shelters v-if="!filters.shelter" v-model="filters.shelter" @callback="getShelter"/>
        <div v-else class="w-7xl text-center space-y-7 space-y-10 flex flex-wrap justify-center mt-10">
            <DataView 
                paginator 
                lazy 
                :rows="filters.rows" 
                :value="data?.data" 
                layout="grid" 
                data-key="card"
                @page="handleChangePage($event)"
                :totalRecords="data?.total">
                <template #header>
                    <div class="w-full flex justify-between">
                        <div class="w-full flex items-center justify-between space-x-4">
                            <Select v-model="filters.type" :options="['dog', 'cat']" @change="reloadTable()"/>
                            <div class="">
                                <p class="text-lg font-bold">{{ shelter.name }}</p>
                            </div>
                            <div class="">
                                <Button severity="ghost" @click="handleBack">
                                    <ChevronLeft/>
                                </Button>
                            </div>
                        </div>
                    </div>
                </template>
                <template #grid="props">
                    <div class="grid grid-cols-12 gap-4">
                        <div v-for="(item, index) in props.items" :key="index"
                            class="col-span-12 sm:col-span-6 md:col-span-6 xl:col-span-4 p-2">
                            <div class="p-6 border border-amber-400 bg-surface-0 bg-amber-300/[.3] rounded flex flex-col">
                                <div class="bg-white flex justify-center rounded p-4">
                                    <div class="relative mx-auto">
                                        <div class="w-72 h-72 grid place-items-center bg-white">
                                            <img class="rounded w-full" :src="item.media[0].original_url"
                                                :alt="item.name" style="max-width: 300px" />
                                        </div>
                                        <div class="absolute bg-black/70 rounded-border" style="left: 4px; top: 4px">
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-6 flex flex-col justify-between h-48">
                                    <div class="text-start">
                                        <p class="text-2xl font-medium uppercase text-start">{{ item.name }}</p>
                                        <p class="font-medium text-gray-700">{{ item.color }}</p>
                                        <p class="font-medium text-xl text-gray-700"><span class="pi pi-info"></span> {{ item.breed }}</p>
                                        <p class="font-medium text-xl text-gray-700 "><span class="pi pi-hashtag"></span> {{ item.age }}</p>
                                    </div>
                                    <div class="flex justify-between space-x-2 pt-4">
                                        <Button label="About" class="!bg-white" outlined severity="info" variant="text" raised @click="$refs.sad?.open(item)"/>
                                        <Button label="Adopt" class="!bg-white" outlined severity="success" variant="text" raised @click="$refs.aaad?.open(item)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template #empty>
                    <div class="w-full h-96 grid place-items-center">No Available Pets to adopt</div>
                </template>
            </DataView>
            <SeeAnimalDialog ref="sad"/>
            <AppointAdoptionAnimalDialog ref="aaad" />
        </div>
    </div>
</template>
<script setup lang="ts">
import AppointAdoptionAnimalDialog from './AppointAdoptionAnimalDialog.vue';
import SeeAnimalDialog from '@/Pages/Animal/components/SeeAnimalDialog.vue';
import { DataView, DataViewPageEvent, Select, Button } from 'primevue';
import { AnimalPaginationTypes, FilterAnimalTypes } from '@/Pages/Animal/Types/AnimalTypes';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import Shelters from './Shelters.vue';
import { ShelterTypes } from '@/Pages/Shelter/Types/ShelterTypes';
import { ChevronLeft } from 'lucide-vue-next';

const shelter = ref<ShelterTypes>({})
const data = ref<AnimalPaginationTypes>()
const filters = ref<FilterAnimalTypes>({
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
    type: 'dog',
    status: 'available',
    shelter: undefined
})

onMounted(() => {
    reloadTable()
})

async function reloadTable() {
    const res = await axios.get(route('customers.animals.index'), { params: filters.value })

    if (res.status === 200) {
        data.value = res.data
    }
}

function handleChangePage(e: DataViewPageEvent) {
    filters.value.rows = e.rows
    filters.value.page = e.page + 1

    reloadTable()
}

function getShelter() {
    axios.get(route('customers.shelters.show'), {params: { id: filters.value.shelter}})
    .then((res) => {
        shelter.value = res.data
    })
    .catch((err) => {
        console.log(err)
    })

    reloadTable()
}

function handleBack() {
    filters.value.shelter = undefined
    shelter.value = {}
}

provide('reloadTable', reloadTable)
</script>