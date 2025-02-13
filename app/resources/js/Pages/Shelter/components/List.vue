<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex flex-wrap items-center space-x-4">
                    <div class="font-bold text-xl">{{ filters.trash ? 'Trash' : 'List' }}</div>
                    <div class="flex items-center space-x-2">
                        <SearchInput v-model="filters.searchString" @callback="reloadTable()" />
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <Button outlined :severity="`${!filters.trash ? 'danger' : 'info'}`" @click="handleDisplayTrash()">
                        <Trash v-if="!filters.trash"/>
                        <List v-else/>
                    </Button>
                    <Button outlined severity="success" @click="$refs.ssd?.open()">
                        <Plus/>
                    </Button>
                </div>
            </div>
        </template>
        <Column field="name" header="Name" sortable />
        <Column field="location" header="Location" sortable />
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template v-if="!filters.trash" #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="info" text @click="$refs.sesd?.open(props.data)">
                        <Eye/>
                    </Button>
                    <Button severity="warn" text @click="$refs.usd?.open(props.data)">
                        <Edit/>
                    </Button>
                    <Button severity="danger" text @click="handleDeleteShelter(props.data.id)">
                        <Trash/>
                    </Button>
                </div>
            </template>
            <template v-else #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="success" text @click="handleRestoreShelter(props.data.id)">
                        <Recycle/>
                    </Button>
                    <Button severity="ghost" text @click="handleForceDeleteShelter(props.data.id)">
                        <X/>
                    </Button>
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
import { Edit, Eye, Recycle, X, Trash, Plus, List } from 'lucide-vue-next';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<ShelterPaginationTypes>()
const filters = ref<FilterShelterTypes>({
    trash: false,
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

function handleDeleteShelter(id: number) {
    confirm.require({
        message: `Are you sure you want to trash this Shelter`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteShelter(id)
        }
    })
}

function submitDeleteShelter(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('shelters.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Trashed Shelter Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleRestoreShelter(id: number) {
    confirm.require({
        message: `Are you sure you want to restore this Shelter`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitRestoreShelter(id)
        }
    })
}

function submitRestoreShelter(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.post(route('shelters.restore'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Restored Shelter Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleForceDeleteShelter(id: number) {
    confirm.require({
        message: `Are you sure you want to permanently delete this Shelter`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitForceDeleteShelter(id)
        }
    })
}

function submitForceDeleteShelter(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('shelters.forceDelete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Permanently Deleted Shelter Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleDisplayTrash() {
    filters.value.trash = !filters.value.trash

    reloadTable()
}

provide('reloadTable', reloadTable)
</script>