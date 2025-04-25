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
                </div>
            </div>
        </template>
        <Column field="location" header="Location" sortable />
        <Column field="animal_status" header="Animal Status" sortable />
        <Column field="status" header="Status" sortable />
        <Column field="contact_number" header="Contact Number" sortable />
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
                    <Button severity="danger" text @click="handleDeleteReport(props.data.id)">
                        <Trash/>
                    </Button>
                </div>
            </template>
            <template v-else #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="success" text @click="handleRestoreReport(props.data.id)">
                        <Recycle/>
                    </Button>
                    <Button severity="ghost" text @click="handleForceDeleteReport(props.data.id)">
                        <X/>
                    </Button>
                </div>
            </template>
        </Column>
    </DataTable>
    <SeeReportDialog ref="sesd" />
    <UpdateReportDialog ref="usd" />
</template>
<script setup lang="ts">
import { Column, Badge } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeReportDialog from './SeeReportDialog.vue';
import UpdateReportDialog from './UpdateReportDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterReportTypes, ReportPaginationTypes } from '../Types/ReportTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { Edit, Eye, Recycle, X, Trash, Plus, List } from 'lucide-vue-next';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<ReportPaginationTypes>()
const filters = ref<FilterReportTypes>({
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
    const res = await axios.get(route('reports.index'), { params: filters.value })

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

function handleDeleteReport(id: number) {
    confirm.require({
        message: `Are you sure you want to trash this Report`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteReport(id)
        }
    })
}

function submitDeleteReport(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('reports.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Trashed Report Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleRestoreReport(id: number) {
    confirm.require({
        message: `Are you sure you want to restore this Report`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitRestoreReport(id)
        }
    })
}

function submitRestoreReport(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.post(route('reports.restore'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Restored Report Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleForceDeleteReport(id: number) {
    confirm.require({
        message: `Are you sure you want to permanently delete this Report`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitForceDeleteReport(id)
        }
    })
}

function submitForceDeleteReport(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('reports.forceDelete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Permanently Deleted Report Successfully`, life: 3000 });
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