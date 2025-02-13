<template>
    <div class="flex h-full bg-gray-100 w-full">
        <!-- Sidebar -->
        <div :class="[
            'bg-white text-white transition-all duration-300',
            isOpen ? 'w-64' : 'w-16'
        ]" class="h-full fixed lg:relative flex flex-col !z-[999]">
            <div class="w-full flex items-start px-2">
                <Button @click="toggleSidebar" class="p-4 focus:outline-none lg:hidden " text>
                    <AlignJustify />
                </Button>
            </div>
            <!-- Toggle Button -->

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-4 mt-6">
                <template v-for="item in navItems">
                    <Button :key="item.name" @click="item.callBack" v-if="item.show"
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-white transition-all !justify-start"
                        :class="{ 'justify-center': !isOpen }" text>
                            <div class="w-6 h-6 pl-2">
                                <component :is="item.icon"/>
                            </div>
                        <span v-if="isOpen" class="ml-4">{{ item.name }}</span>
                    </Button>
                </template>
            </nav>
        </div>

        <!-- Main Content -->
        <div :class="['flex-1']" class="h-full transition-all duration-300 w-[calc(100%-4rem)] pl-16 lg:pl-0 overflow-y-auto">
            <div class="w-full">
                <slot />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import { Button } from 'primevue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { AlignJustify, Calendar, Heart, Home, User } from 'lucide-vue-next';

const page = usePage<any>()
const isOpen = ref(false);
const toggleSidebar = () => (isOpen.value = !isOpen.value);

const navItems = ref([
    {
        name: 'Staffs',
        icon: User,
        callBack: (() => router.visit('staffs')),
        show: page.props.auth.user.roles.some((v: any) => ['admin'].includes(v.name))
    },
    {
        name: 'Shelters',
        icon: Home,
        callBack: (() => router.visit('shelters')),
        show: page.props.auth.user.roles.some((v: any) => ['admin'].includes(v.name))
    },
    {
        name: 'Animals',
        icon: Heart,
        callBack: (() => router.visit('animals')),
        show: page.props.auth.user.roles.some((v: any) => ['staff'].includes(v.name))
    },
    {
        name: 'Appointments',
        icon: Calendar,
        callBack: (() => router.visit('appointments')),
        show: page.props.auth.user.roles.some((v: any) => ['staff'].includes(v.name))
    },
    {
        name: 'Adoptions',
        icon: Home,
        callBack: (() => router.visit('adoptions')),
        show: page.props.auth.user.roles.some((v: any) => ['staff'].includes(v.name))
    },
]);
</script>