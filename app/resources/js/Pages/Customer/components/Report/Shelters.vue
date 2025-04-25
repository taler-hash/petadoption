<template>
    <div class="max-w-7xl text-center space-y-7 space-y-10 flex flex-wrap justify-center mt-10">
        <DataView paginator lazy :rows="filters.rows" :value="data?.data" layout="grid" data-key="card"
            @page="handleChangePage($event)" :totalRecords="data?.total">
            <template #header>
                <div class="w-full flex justify-between">
                    <div class="">
                        <p>Shelters</p>
                    </div>
                </div>
            </template>
            <template #grid="props">
                <div class="grid grid-cols-12 gap-4 justify-items-center">
                    <div v-for="(item, index) in props.items" :key="index"
                        class="col-span-12 sm:col-span-6 md:col-span-6 xl:col-span-4 p-2">
                        <div
                            @click="selectItem(item)" 
                            class="p-6 py-10 border border-amber-400 bg-surface-0 bg-amber-300/[.3] rounded flex h-full items-center justify-center cursor-pointer hover:bg-amber-500 hover:text-white transition-all hover:scale-105">
                            <div class="">
                                <p class="text-4xl capitalize">{{ item.name }}</p>
                                <p>{{ item.location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </DataView>
    </div>
</template>
<script setup lang="ts">
import { DataView, DataViewPageEvent } from 'primevue';
import { FilterShelterTypes, ShelterPaginationTypes, ShelterTypes } from '@/Pages/Shelter/Types/ShelterTypes';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const emits = defineEmits(['callback'])
const model = defineModel()
const data = ref<ShelterPaginationTypes>()
const filters = ref<FilterShelterTypes>({
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
})

onMounted(() => {
    reloadTable()
})

async function reloadTable() {
    const res = await axios.get(route('customers.shelters.index'), { params: filters.value })

    if (res.status === 200) {
        data.value = res.data
    }
}

function selectItem(item: ShelterTypes) {
    model.value = item.id
    emits('callback')
}

function handleChangePage(e: DataViewPageEvent) {
    filters.value.rows = e.rows
    filters.value.page = e.page + 1

    reloadTable()
}

</script>