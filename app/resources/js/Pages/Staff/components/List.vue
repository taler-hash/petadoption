<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex flex-wrap items-center space-x-4">
                    <div class="font-bold text-xl">{{ filters.trash ? 'Trash' : 'List' }}</div>
                    <div class="flex items-center space-x-2">
                        <SearchInput @callback="reloadTable()" />
                        <LazySelect module="shelters" label="name" v-model="filters.shelter" @callback="reloadTable()"
                            placeholder="Select Shelter" />
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
        <Column field="username" header="Username" sortable />
        <Column field="shelter.name" header="Shelter" />
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
                    <Button severity="danger" text @click="handleDeleteUser(props.data.id)">
                        <Trash />
                    </Button>
                </div>
            </template>
            <template v-else #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="success" text @click="handleRestoreUser(props.data.id)">
                        <Recycle/>
                    </Button>
                    <Button severity="ghost" text @click="handleForceDeleteUser(props.data.id)">
                        <X/>
                    </Button>
                </div>
            </template>
        </Column>
    </DataTable>
    <StoreStaffDialog ref="ssd" />
    <SeeStaffDialog ref="sesd" />
    <UpdateStaffDialog ref="usd" />
</template>
<script setup lang="ts">
import { Column } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeStaffDialog from './SeeStaffDialog.vue';
import StoreStaffDialog from './StoreStaffDialog.vue';
import UpdateStaffDialog from './UpdateStaffDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterWithRoleTypes, UserPaginationTypes } from '../Types/StaffTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { Edit, Eye, Recycle, X, Trash, Plus, List } from 'lucide-vue-next';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<UserPaginationTypes>()
const filters = ref<FilterWithRoleTypes>({
    trash: false,
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
    role: props?.role,
})

onMounted(() => {
    reloadTable()
})

async function reloadTable() {
    const res = await axios.get(route('staffs.index'), { params: filters.value })

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
        message: `Are you sure you want to trash this User`,
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
    form.delete(route('staffs.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Trashed User Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleRestoreUser(id: number) {
    confirm.require({
        message: `Are you sure you want to restore this User`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitRestoreUser(id)
        }
    })
}

function submitRestoreUser(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.post(route('staffs.restore'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Restored User Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleForceDeleteUser(id: number) {
    confirm.require({
        message: `Are you sure you want to permanently delete this User`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitForceDeleteUser(id)
        }
    })
}

function submitForceDeleteUser(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('staffs.forceDelete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Permanently Deleted User Successfully`, life: 3000 });
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