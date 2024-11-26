<template>
    <Dialog v-model:visible="visible" modal @hide="close" header="Adoption Form" class="w-72">
        <template v-if="!code">
            <form @submit.prevent="submit" class="space-y-4 w-full">
                <div class="w-full  space-y-3">
                    <div class="flex flex-col gap-2">
                        <label for="pet">Pet Name</label>
                        <InputText id="pet" :value="form.animal?.name" aria-describedby="name-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="name">Name</label>
                        <InputText id="name" v-model="form.name" aria-describedby="name-help" required />
                        <InputError :message="form.errors.name?.[0]" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email">Email</label>
                        <InputText id="email" v-model="form.email" aria-describedby="email-help" required />
                        <InputError :message="form.errors.email?.[0]" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="phone">Phone</label>
                        <InputNumber id="phone" v-model="form.phone" aria-describedby="phone-help" required
                            :useGrouping="false" fluid />
                        <InputError :message="form.errors.phone?.[0]" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="date">Date to Appoint</label>
                        <DatePicker :disabledDays="[0, 6]"
                            :min-date="new Date(new Date().setDate(new Date().getDate() + 3))" id="date"
                            v-model="form.appointment_date" aria-describedby="date-help" required />
                        <InputError :message="form.errors.appointment_date" />
                    </div>
                    <div class="pt-4">
                        <Button type="submit" severity="success" label="submit" class="w-full" />
                    </div>
                </div>
            </form>
        </template>
        <template v-else>
            <div class="">this is your code this serves to track the status of your appointment of adoption</div>
            <div class="font-bold text-2xl text-center pt-5">{{ code }}</div>
        </template>
    </Dialog>

</template>
<script setup lang="ts">
import { AnimalTypes } from '@/Pages/Animal/Types/AnimalTypes';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { Dialog, InputNumber, InputText, Button, DatePicker } from 'primevue';
import { inject, ref } from 'vue';
import { AdoptionFormTypes } from './Types/AdoptionTypes';
import { useToast } from 'primevue';
import axios from 'axios';

const toast = useToast()
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)
const code = ref<string>()
const form = useForm<AdoptionFormTypes>({
    id: undefined,
    name: '',
    email: '',
    phone: null,
    appointment_date: null
})

function open(animal: AnimalTypes) {
    form.defaults({ animal: animal })
    form.reset()
    visible.value = true
}

function close() {
    code.value = ''
    visible.value = false
    reloadTable()
}

async function submit() {
    axios.post(route('customers.appointments.store'), {...form})
    .then((res) => {
        code.value = res.data
        toast.add({ severity: 'success', summary: 'Success', detail: `Appointment Created Successfully`, life: 3000 });
        form.reset()
    })
    .catch((err) => {
        if(err.response.data.errors?.message) {
            toast.add({ severity: 'error', summary: 'Error', detail: `Details is outdated record will be refreshed`, life: 3000 });
        } else {
            form.setError(err.response.data.errors)
        }
    })
}



defineExpose({
    open
})
</script>