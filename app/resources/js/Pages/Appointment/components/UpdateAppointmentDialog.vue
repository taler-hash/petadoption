<template>
    <Dialog v-model:visible="visible" modal :header="`Update Appointment Status`" @hide="close" class="w-96">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="adopter_name">Adopter name</label>
                <InputText id="adopter_name" v-model="form.adopter.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="animal_name">Pet name</label>
                <InputText id="animal_name" v-model="form.animal.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="appointment_date">Appointment date</label>
                <InputText id="appointment_date" v-model="form.parsed_appointment_date" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="type">Status</label>
                <Select id="type" v-model="form.status" :options="statusOptions" aria-describedby="type-help" required />
                <InputError :message="form.errors.status" />
            </div>
            <div class="pt-2">
                <Button :disabled="!form.isDirty" type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form> 
    </Dialog>
</template>
<script setup lang="ts">
import { InputText } from 'primevue';
import InputError from '@/Components/InputError.vue';
import { Dialog, Select, Button } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { AppointmentTypes } from '../Types/AppointmentTypes';

const toast = useToast()
const form = useForm<AppointmentTypes>({
    adopter: {name: '', email: null, phone: null},
    animal: {name: ''},
    status: ''
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)
const statusOptions = ref<string[]>()

function open(props: AppointmentTypes) {
    setStatusOptions(props.status);
    form.defaults(props)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

function setStatusOptions(status: string) {

    switch(status) {
        case 'pending':
            statusOptions.value = ['pending', 'confirmed', 'cancelled']
        break
        case 'confirmed':
            statusOptions.value = ['confirmed', 'completed', 'cancelled']
        break
        default:
            statusOptions.value = [status]
    }
}

async function submit() {
    form.put(route('appointments.update'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated Appointment Status Successfully`, life: 3000 });
            close()
            form.reset()
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Error', detail: `Details is outdated record will be refreshed`, life: 3000 });
        }
    })
}

defineExpose({
    open
})
</script>