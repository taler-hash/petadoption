<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-4 ">
                <div class="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-4 w-full justify-items-center">
                    <template v-for="(card, index) in counts" :key="index">
                        <div class="bg-white w-full p-4 border rounded-lg shadow-sm ">
                            <div class="flex items-center justify-between pb-4">
                                <p class="font-black text-2xl capitalize">{{ card.name }}</p>
                                <span class="!text-4xl" :class="card.icon"></span>
                            </div>
                            <div>
                                <Suspense>
                                    <p class="text-7xl font-black">{{ card.count ?? '-' }}</p>
                                    <template #fallback>
                                        -
                                    </template>
                                </Suspense>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';

interface CountTypes {
    [key: string]: {
        name: string,
        count: number,
        icon: string
    }
}

const page = usePage<any>()
const counts = ref<CountTypes>({})

onMounted(() => {
    getStaffs()
    getAppointments()
    getAdoptions()
    getAnimals()
})

async function getStaffs() {
    if (page.props.auth.user.roles[0].name !== 'admin') return

    structureCount('staffs', 'pi-users')
}

async function getAppointments() {
    structureCount('appointments', 'pi-calendar')
}

async function getAdoptions() {
    structureCount('adoptions', 'pi-home')
}

async function getAnimals() {
    structureCount('animals', 'pi-heart')
}

function structureCount(module: string, _icon: string) {
    axios.get(route(`${module}.count`))
        .then((res) => {
            counts.value[module] = {
                name: module,
                count: res.data,
                icon: `pi ${_icon}`
            }
        })
}
</script>
