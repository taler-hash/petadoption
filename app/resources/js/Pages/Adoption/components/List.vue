<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-2">
                    <SearchInput v-model="filters.searchString" @callback="reloadTable()" />
                </div>
            </div>
        </template>
        <Column header="Pet Image">
            <template #body="props">
                <Avatar :image="props.data.animal.media[0].original_url" class="mr-2" size="xlarge" shape="circle" />
            </template>
        </Column>
        <Column header="Pet Name">
            <template #body="props">
                <Button :label="props.data.animal.name" text severity="info" @click="$refs.sead?.open(props.data.animal)"/>
            </template>
        </Column>
        <Column header="Adopter Name">
            <template #body="props">
                <Button :label="props.data.adopter.name" text severity="success" @click="$refs.seadd?.open(props.data.adopter)"/>
            </template>
        </Column>
        <Column field="parsed_adoption_date" header="Adoption Date" />
    </DataTable>
    <SeeAdopterDialog ref="seadd" />
    <SeeAnimalDialog ref="sead" />
</template>
<script setup lang="ts">
import {Badge} from 'primevue';
import { Column } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import SeeAnimalDialog from '@/Pages/Animal/components/SeeAnimalDialog.vue';
import { AdoptionPaginationTypes, FilterAdoptionTypes } from '../Types/AdoptionTypes';
import SeeAdopterDialog from '@/Pages/Adopter/components/SeeAdopterDialog.vue';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<AdoptionPaginationTypes>()
const filters = ref<FilterAdoptionTypes>({
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
    const res = await axios.get(route('adoptions.index'), { params: filters.value })

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

function handleDeleteAdoption(id: number) {
    confirm.require({
        message: `Are you sure you want to delete this Adoption`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteAdppointment(id)
        }
    })

}

function submitDeleteAdppointment(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('adoptions.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Deleted Adoption Successfully`, life: 3000 });
            reloadTable()
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Error', detail: `Details is outdated record will be refreshed`, life: 3000 });
        }
    })
}

function statusOptions() {
    
}

provide('reloadTable', reloadTable)
</script>