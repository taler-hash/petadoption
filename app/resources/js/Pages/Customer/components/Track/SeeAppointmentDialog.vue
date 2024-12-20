<template>
    <Dialog v-model:visible="visible" modal header="Appointment">
        <div class="w-72">
            <div class="flex flex-col gap-2 mb-4">
                <label for="pet">Status</label>
                <Badge :value="appointment?.status" :class="AppointmentStatusSeverity(appointment?.status)"
                    size="xlarge" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="pet">Shelter</label>
                <InputText id="pet" :value="appointment?.animal.shelter?.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="pet">Shelter Location</label>
                <InputText id="pet" :value="appointment?.animal.shelter?.location" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="pet">Appointment Date</label>
                <InputText id="pet" :value="appointment?.parsed_appointment_date" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="pet">Pet Name</label>
                <InputText id="pet" :value="appointment?.animal.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="pet">Adopter Name</label>
                <InputText id="pet" :value="appointment?.adopter.name" aria-describedby="name-help" disabled />
            </div>
        </div>
    </Dialog>
</template>
<script setup lang="ts">
import { Badge, InputText, Dialog } from 'primevue';
import { AppointmentStatusSeverity } from '@/api/AppointmentStatusSeverity';
import { AppointmentTypes } from '@/Pages/Appointment/Types/AppointmentTypes';
import { ref } from 'vue';

const visible = ref<boolean>(false)
const appointment = ref<AppointmentTypes>()

function open(_appointment: AppointmentTypes) {
    appointment.value = _appointment
    visible.value = true
}

defineExpose({
    open
})
</script>