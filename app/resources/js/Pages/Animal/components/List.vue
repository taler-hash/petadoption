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
                        <div v-if="!$page.props.auth.user?.shelter">
                            <LazySelect module="shelters" label="name" v-model="filters.shelter"
                                @callback="reloadTable()" placeholder="Select Shelter" />
                        </div>
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
        <Column header="Image">
            <template #body="props">
                <Avatar :image="props.data.media[0].original_url" class="mr-2" size="xlarge" shape="circle" />
            </template>
        </Column>
        <Column field="name" header="Name" sortable />
        <Column field="type" header="Type" sortable />
        <Column field="color" header="Color" sortable />
        <Column field="breed" header="Breed" sortable />
        <Column field="shelter.name" header="Shelter" />
        <Column field="age" header="Age" sortable />
        <Column field="status" header="Status">
            <template #body="props">
                <Badge :value="props.data.status" :class="AnimalStatusSeverity(props.data.status)" />
            </template>
        </Column>
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template #body="props">
                <div class="flex flex-nowrap justify-center">
                    <template v-if="!filters.trash">
                        <Button severity="info" text @click="$refs.sesd?.open(props.data)">
                            <Eye/>
                        </Button>
                        <Button severity="warn" text @click="$refs.usd?.open(props.data)">
                            <Edit/>
                        </Button>
                        <Button severity="danger" text @click="handleDeleteAnimal(props.data.id)">
                            <Trash />    
                        </Button>
                    </template>
                    <template v-else>
                        <Button severity="success" text @click="handleRestoreAnimal(props.data.id)">
                            <Recycle/>
                        </Button>
                        <Button severity="ghost" text @click="handleForceDeleteAnimal(props.data.id)">
                            <X/>
                        </Button>
                    </template>
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
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { usePage } from '@inertiajs/vue3';
import { Edit, Eye, Recycle, X, Trash, Plus, List } from 'lucide-vue-next';

const page = usePage();
const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const props = defineProps(['role'])
const data = ref<AnimalPaginationTypes>()
const filters = ref<FilterAnimalTypes>({
    trash: false,
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
    //@ts-ignore
    shelter: page.props.auth.user?.shelter.id
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

function handleDeleteAnimal(id: number) {
    confirm.require({
        message: `Are you sure you want to trash this Animal`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteAnimal(id)
        }
    })
}

function submitDeleteAnimal(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('animals.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Trashed Animal Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleRestoreAnimal(id: number) {
    confirm.require({
        message: `Are you sure you want to restore this Animal`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitRestoreAnimal(id)
        }
    })
}

function submitRestoreAnimal(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.post(route('animals.restore'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Restored Animal Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleForceDeleteAnimal(id: number) {
    confirm.require({
        message: `Are you sure you want to permanently delete this Animal`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitForceDeleteAnimal(id)
        }
    })
}

function submitForceDeleteAnimal(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('animals.forceDelete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Permanently Deleted Animal Successfully`, life: 3000 });
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