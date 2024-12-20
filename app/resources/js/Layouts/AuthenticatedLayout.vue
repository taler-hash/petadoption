<template>
    <div>
        <div class="h-screen bg-gray-100">
            <!-- Page Heading -->
            <header class="sticky top-0 bg-white shadow flex items-center justify-between px-2 z-[99]" v-if="$slots.header">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center justify-center flex-col">
                        <Link :href="route('dashboard')">
                            <img :src="Logo" alt="" class="w-40 h-20 object-contain cursor-pointer"
                                @click="handleRoute('dashboard')">
                        </Link>
                        <p class="text-xs uppercase">{{ $page.props.auth.user.shelter?.name }}</p>
                    </div>
                </div>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>

                <!-- settings -->
                <div class="">
                    <!-- Settings Dropdown -->
                    <div class="relative ms-3">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                        {{ $page.props.auth.user.name }}
                                        <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex w-full h-[calc(100%-6rem)]">
                <Toast />
                <ConfirmDialog />
                <SideBar>
                    <slot />
                </SideBar>
            </main>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import SideBar from '@/Components/SideBar.vue';
import { Toast } from 'primevue';
import { ConfirmDialog } from 'primevue';
import Logo from '@/assets/logo.png'
import { router } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

function handleRoute(route: string) {
    if (route === undefined) return

    router.visit(`/${route}`)
}
</script>