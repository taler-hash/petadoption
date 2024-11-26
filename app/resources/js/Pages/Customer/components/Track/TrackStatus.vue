<template>
    <div class="w-full p-4 px-8 grid place-items-center">
        <div class="max-w-7xl text-center space-y-7 space-y-10 flex flex-wrap justify-center mt-10 pb-[11.42rem]">
            <div class="flex flex-col space-y-4">
                <IftaLabel>
                    <InputText id="username" v-model="code" variant="filled" class="!w-72" />
                    <label for="username">Track Status</label>
                </IftaLabel>
                <Button label="Check" severity="success" @click="submit" />
            </div>
        </div>
    </div>
    <SeeAppointmentDialog ref="sed" />
</template>
<script setup lang="ts">
import SeeAppointmentDialog from './SeeAppointmentDialog.vue';
import { AppointmentTypes } from '@/Pages/Appointment/Types/AppointmentTypes';
import axios from 'axios';
import { InputText, IftaLabel, Button, useToast } from 'primevue';
import { ref } from 'vue';

const toast = useToast()
const code = ref<string>();
const appointment = ref<AppointmentTypes>()
const sed = ref<any>()

function submit() {
    axios.get(route('customers.appointments.show'), { params: { code: code.value } })
        .then((res) => {

            if(JSON.stringify(res.data) === '{}') {
                toast.add({ severity: 'info', summary: 'Info', detail: `No Appointment Found`, life: 3000 });
            } else {
                toast.add({ severity: 'success', summary: 'Success', detail: `Appointment Found`, life: 3000 });
                appointment.value = res.data
                sed.value.open(appointment.value)
            }
        })
        .catch((err) => {
            if(err.status === 422) {
                toast.add({ severity: 'error', summary: 'Error', detail: `Code not valid`, life: 3000 });
            }
        })
}
</script>