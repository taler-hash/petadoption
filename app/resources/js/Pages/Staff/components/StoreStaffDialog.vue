<template>
    <Dialog v-model:visible="visible" modal :header="`Create Staff`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="status">Shelter</label>
                <LazySelect label="name" module="shelters" v-model="form.shelter_id" required />
                <InputError :message="form.errors.shelter_id" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <InputText id="name" v-model="form.name" aria-describedby="name-help" required />
                <InputError :message="form.errors.name" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="username">Username</label>
                <InputText id="username" v-model="form.username" aria-describedby="username-help" required />
                <InputError :message="form.errors.username" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="password">Password</label>
                <InputText id="password" v-model="form.password" aria-describedby="password-help" required />
                <InputError :message="form.errors.password" />
            </div>
            <div class="pt-2">
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form> 
    </Dialog>
</template>
<script setup lang="ts">
import {Button} from 'primevue';
import { InputText } from 'primevue';
import InputError from '@/Components/InputError.vue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UserTypes } from '../Types/StaffTypes'
import { useToast } from 'primevue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';

const toast = useToast()
const form = useForm<UserTypes>({
    username: '',
    name: '',
    password: '',
    shelter_id: undefined
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    form.clearErrors()
    reloadTable()
}

async function submit() {
    form.post(route('staffs.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Added Staff Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>