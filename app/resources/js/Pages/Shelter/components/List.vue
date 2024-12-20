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
        <Column field="name" header="Name" sortable />
        <Column field="location" header="Location" sortable />
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
    <StoreShelterDialog ref="ssd" />
    <SeeShelterDialog ref="sesd" />
    <UpdateShelterDialog ref="usd" />
</template>
<script setup lang="ts">
import { Column, Badge } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeShelterDialog from './SeeShelterDialog.vue';
import StoreShelterDialog from './StoreShelterDialog.vue';
import UpdateShelterDialog from './UpdateShelterDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterShelterTypes, ShelterPaginationTypes } from '../Types/ShelterTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
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
    const res = await axios.get(route('shelters.index'), { params: filters.value })

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
        message: `Are you sure you want to delete this Shelter`,
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
    form.delete(route('shelters.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Deleted Shelter Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

provide('reloadTable', reloadTable)
</script>