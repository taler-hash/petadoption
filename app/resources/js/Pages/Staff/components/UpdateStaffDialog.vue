<template>
    <Dialog v-model:visible="visible" modal :header="`Update Staff`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
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
                <InputText id="password" v-model="form.password" aria-describedby="password-help" />
                <InputError :message="form.errors.password" />
            </div>
            <div class="pt-2">
                <Button :disabled="!form.isDirty" type="submit" severity="success" label="submit" class="w-full" />
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

const toast = useToast()
const form = useForm<UserTypes>({
    username: '',
    name: '',
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: UserTypes) {
    form.defaults(props)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.put(route('staffs.update'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated Staff Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>