<template>
    <Dialog v-model:visible="visible" modal :header="`Staff`" @hide="close">
        <div class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <InputText id="name" v-model="form.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="username">Username</label>
                <InputText id="username" v-model="form.username" aria-describedby="username-help" disabled/>
            </div>
        </div> 
    </Dialog>
</template>
<script setup lang="ts">
import { InputText } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UserTypes } from '../Types/StaffTypes'
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<UserTypes>({
    username: '',
    name: '',
    password: ''
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: UserTypes) {
    console.log(props)
    form.defaults(props)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    reloadTable()
}

defineExpose({
    open
})
</script>