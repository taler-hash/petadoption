<template>
    <Select
        :disabled="props.disabled"
        :options="items?.data" 
        :option-label="props.label" 
        v-model="item" 
        class="w-full"
        @value-change="updateItemValue" 
        @hide="close"
        showClear>
        <template #value>
            <div v-if="item !== 'empty'" class="">
                {{ item[props.label] }}
            </div>
            <div v-else class="text-gray-500">
                {{ placeholder ?? 'Please select an option' }}
            </div>
        </template>
        <template #header>
            <div class="p-2">
                <SearchInput v-model="filters.searchString" @callback="getItems()" />
            </div>
        </template>
        <template #footer>
            <div class="p-2">
                <Paginator @page="updatePage" v-model="filters.page" :rows="filters.rows" :totalRecords="items?.total"
                    template="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink" />
            </div>
        </template>
        <template #clearicon="event">
            <div class="grid place-items-center" @click="clear">
                <i class="pi pi-times"></i>
            </div>
        </template>
    </Select>
</template>
<script setup lang="ts">
import axios from 'axios';
import { Select, Paginator, PageState } from 'primevue';
import { onBeforeMount, onMounted, ref } from 'vue';
import { FilterLazySelectTypes, PaginationLazySelectTypes } from './Types/LazySelectTypes';
import SearchInput from '../SearchInput/SearchInput.vue';

const emits = defineEmits(['callback'])
const model = defineModel();
const props = defineProps(['module', 'label', 'disabled', 'placeholder']);
const item = ref<any>('empty')
const filters = ref<FilterLazySelectTypes>({})
const items = ref<PaginationLazySelectTypes>()

onMounted(() => {
    defaultFilters()
    getItem()
})

function defaultFilters() {
    filters.value = {
        page: 1,
        sortBy: 'id',
        sortType: 'desc',
        rows: 10,
        searchString: '',
    }
    getItems()
}

async function getItems() {
    axios.get(route(`${props.module}.index`), { params: filters.value })
    .then((res) => {
        items.value = res.data
    })
    .catch((err) => {
        console.error(err)
    })
}

async function getItem() {
    if(!model.value) return

    axios.get(route(`${props.module}.show`), {params:{id: model.value}})
    .then((res) => {
        item.value = res.data
    })
    .catch((err) => {
        console.log(err)
    })
}

function close() {
    defaultFilters()
}

function updateItemValue(data: any) {
    model.value = data.id
    emits('callback')
}

function updatePage(data: PageState) {
    filters.value.page = data?.page + 1

    getItems()
}

function clear() {
    item.value = 'empty'
    model.value = null
    emits('callback')
}

</script>