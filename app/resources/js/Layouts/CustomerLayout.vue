<template>
    <div class="w-full h-full">
        <Menubar :model="items" class="sticky top-0 z-[999]">
            <template #start>
                <div class="lg:pl-10">
                    <img :src="Logo" alt="" class="w-40 h-20 object-contain cursor-pointer" @click="handleRoute('')">
                </div>
            </template>
            <template #item="{ item, props, hasSubmenu, root }">
                <a v-ripple class="flex align-items-center rounded-lg"
                    :class="{ 'bg-gray-200': page.url.replace('/', '') === item.link }" v-bind="props.action"
                    @click="handleRoute(item?.link)">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                    <span v-if="item.shortcut"
                        class="ml-auto border-1 surface-border border-round surface-100 text-xs p-1">{{
                            item.shortcut
                        }}</span>
                    <i v-if="hasSubmenu"
                        :class="['pi pi-angle-down', { 'pi-angle-down ml-2': root, 'pi-angle-right ml-auto': !root }]"></i>
                </a>
            </template>
        </Menubar>
        <div class="">
            <Toast />
            <ConfirmDialog />
            <slot />
        </div>
    </div>
</template>
<script setup lang="ts">
import { ConfirmDialog, Menubar, Toast } from 'primevue';
import Logo from '@/assets/logo.png'
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3';

const page = usePage()

const items = ref([
    {
        label: 'DONATE',
        icon: 'pi pi-home',
        link: 'donate'
    },
    {
        label: 'ADOPT',
        icon: 'pi pi-search',
        link: 'adopt'
    },
    {
        label: 'TRACK',
        icon: 'pi pi-bell',
        link: 'track'
    },
    {
        label: 'CONTACT US',
        icon: 'pi pi-envelope',
        link: 'contact'
    }
]);

function handleRoute(route: string) {
    if (route === undefined) return

    router.visit(`/${route}`)
}
</script>