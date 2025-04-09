<template>
    <Dialog v-model:visible="visible" modal :header="`Adopter`" @hide="close">
        <div class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <InputText id="name" v-model="form.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="email">Email</label>
                <InputText id="email" v-model="form.email" aria-describedby="email-help" disabled/>
            </div>
            <div class="flex flex-col gap-2">
                <label for="phone">Phone</label>
                <InputText id="phone" :value="form.phone" aria-describedby="phone-help" disabled/>
            </div>
        </div> 
    </Dialog>
</template>
<script setup lang="ts">
import { InputText } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AdopterTypes } from '../Types/AdopterTypes';

const form = useForm<AdopterTypes>({
    name: '',
    email: '',
    phone: null,
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: AdopterTypes) {
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