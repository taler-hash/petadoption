<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-2">
                    <SearchInput v-model="filters.searchString" @callback="reloadTable()" />
                </div>
                <div class="flex items-center-space-x-2">
                    <Button outlined icon="pi pi-plus" severity="success" @click="$refs.ssd?.open()" />
                </div>
            </div>
        </template>
        <Column header="Image">
            <template #body="props">
                <Avatar :image="props.data.media[0].original_url" class="mr-2" size="xlarge" shape="circle" />
            </template>
        </Column>
        <Column field="name" header="Name" sortable />
        <Column field="type" header="Type" sortable />
        <Column field="color" header="Color" sortable />
        <Column field="breed" header="Breed" sortable />
        <Column field="age" header="Age" sortable />
        <Column field="status" header="Status">
            <template #body="props">
                <Badge :value="props.data.status" :class="AnimalStatusSeverity(props.data.status)"/>
            </template>
        </Column>
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="info" icon="pi pi-eye" text @click="$refs.sesd?.open(props.data)" />
                    <Button severity="warn" icon="pi pi-pencil" text @click="$refs.usd?.open(props.data)" />
                    <Button severity="danger" icon="pi pi-times" text @click="handleDeleteUser(props.data.id)" />
                </div>
            </template>
        </Column>
    </DataTable>
    <StoreAnimalDialog ref="ssd" />
    <SeeAnimalDialog ref="sesd" />
    <UpdateAnimalDialog ref="usd" />
</template>
<script setup lang="ts">
import { Column, Badge } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeAnimalDialog from './SeeAnimalDialog.vue';
import StoreAnimalDialog from './StoreAnimalDialog.vue';
import UpdateAnimalDialog from './UpdateAnimalDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterAnimalTypes, AnimalPaginationTypes } from '../Types/AnimalTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { AnimalStatusSeverity } from '@/api/AnimalStatusSeverity';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<AnimalPaginationTypes>()
const filters = ref<FilterAnimalTypes>({
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
    const res = await axios.get(route('animals.index'), { params: filters.value })

    if (res.status === 200) {
        data.value = res.data
    }
}

function handleSort(e: DataTableSortEvent) {
    filters.value.sortBy = e.sortField as string ?? 'id'
    filters.value.sortType = e.sortOrder as number > 0 ? 'asc' : 'desc'

    reloadTable()
}

function handleChangePage(e: DataTablePageEvent) {
    filters.value.rows = e.rows
    filters.value.page = e.page + 1

    reloadTable()
}

const handleSearch = useDebounceFn(() => {
    reloadTable()
}, 1000)

function handleDeleteUser(id: number) {
    confirm.require({
        message: `Are you sure you want to delete this Animal`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteUser(id)
        }
    })
}

function submitDeleteUser(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('animals.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Deleted Animal Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

provide('reloadTable', reloadTable)
</script>