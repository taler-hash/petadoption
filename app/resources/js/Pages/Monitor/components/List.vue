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
                        <ListIcon v-else/>
                    </Button>
                    <Button outlined severity="success" @click="$refs.smd?.open()">
                        <Plus/>
                    </Button>
                </div>
            </div>
        </template> 
        <Column header="Pet Image">
            <template #body="props">
                <Avatar :image="props.data.animal.media[0].original_url" class="mr-2" size="xlarge" shape="circle" />
            </template>
        </Column>
        <Column header="Pet">
            <template #body="props">
                <Button :label="props.data.animal.name" text severity="info" @click="$refs.sead?.open(props.data.animal)"/>
            </template>
        </Column>
        <Column header="Adopter">
            <template #body="props">
                <Button :label="props.data.adopter.name" text severity="success" @click="$refs.seadd?.open(props.data.adopter)"/>
            </template>
        </Column>
        <Column header="Staff" field="staff.name"></Column>
        <Column field="parsed_date" header="Date" />
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template #body="props">
                <div class="flex flex-nowrap justify-center">
                    <template v-if="!filters.trash">
                        <Button v-if="page.props.auth.user.id === props.data.staff.id" severity="warn" text @click="$refs.umd?.open(props.data)">
                            <Edit/>
                        </Button>
                        <Button severity="success" text @click="$refs.semd?.open(props.data)">
                            <Eye/>
                        </Button>
                        <Button v-if="page.props.auth.user.id === props.data.staff.id" severity="danger" text @click="handleDeleteMonitor(props.data.id)">
                            <Trash />    
                        </Button>
                    </template>
                    <template v-else>
                        <Button v-if="page.props.auth.user.id === props.data.staff.id" severity="success" text @click="handleRestoreMonitor(props.data.id)">
                            <Recycle/>
                        </Button>
                        <Button v-if="page.props.auth.user.id === props.data.staff.id" severity="ghost" text @click="handleForceDeleteMonitor(props.data.id)">
                            <X/>
                        </Button>
                    </template>
                </div>
            </template>
        </Column>
    </DataTable>
    <SeeAdopterDialog ref="seadd" />
    <SeeMonitorDialog ref="sead" />
    <StoreMonitorDialog ref="smd" />
    <UpdateMonitorDialog ref="umd" />
    <SeeMonitorDialog ref="semd" />
</template>
<script setup lang="ts">
import { Column } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useConfirm } from 'primevue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import StoreMonitorDialog from './StoreMonitorDialog.vue';
import { MonitorPaginationTypes, FilterMonitorTypes } from '../Types/MonitorTypes';
import SeeAdopterDialog from '@/Pages/Adopter/components/SeeAdopterDialog.vue';
import UpdateMonitorDialog from './UpdateMonitorDialog.vue';
import SeeMonitorDialog from './SeeMonitorDialog.vue'
import { Plus, Edit, Eye, Recycle, X, Trash, List as ListIcon } from 'lucide-vue-next';

const page = usePage()
const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<MonitorPaginationTypes>()
const filters = ref<FilterMonitorTypes>({
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
    const res = await axios.get(route('monitor.index'), { params: filters.value })

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

function handleDeleteMonitor(id: number) {
    confirm.require({
        message: `Are you sure you want to trash this Monitor`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteMonitor(id)
        }
    })
}

function submitDeleteMonitor(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('monitor.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Trashed Monitor Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleRestoreMonitor(id: number) {
    confirm.require({
        message: `Are you sure you want to restore this Monitor`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitRestoreMonitor(id)
        }
    })
}

function submitRestoreMonitor(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.post(route('monitor.restore'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Restored Monitor Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleForceDeleteMonitor(id: number) {
    confirm.require({
        message: `Are you sure you want to permanently delete this Monitor`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitForceDeleteMonitor(id)
        }
    })
}

function submitForceDeleteMonitor(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('monitor.forceDelete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Permanently Deleted Monitor Successfully`, life: 3000 });
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