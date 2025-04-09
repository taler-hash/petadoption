<template>
    <Dialog v-model:visible="visible" modal :header="`Monitor Details`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex items-center">
                <div class="w-full">
                    <div class="flex flex-col gap-2">
                        <label for="animal">Pet</label>
                        <InputText disabled id="animal" :value="fieldVal?.animal.name" aria-describedby="animal-help" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="adopter">Adopter</label>
                        <InputText disabled id="adopter" :value="fieldVal?.adopter.name" aria-describedby="adopter-help" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="staff">Staff</label>
                        <InputText disabled id="staff" :value="fieldVal?.staff.name" aria-describedby="staff-help" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="parsed_date">Date</label>
                        <InputText disabled id="parsed_date" :value="fieldVal?.parsed_date" aria-describedby="parsed_date-help" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="feedback">Feedback</label>
                        <Textarea disabled id="feedback" v-model="form.feedback" aria-describedby="feedback-help"
                           rows="5" cols="30" required />
                    </div>
                </div>
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, DatePicker, Textarea } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { MonitorFormTypes, MonitorTypes } from '../Types/MonitorTypes';

const toast = useToast()
const fieldVal = ref<MonitorTypes>()
const form = useForm<MonitorFormTypes>({
    id: null,
    user_id: null, 
    adopter_id: null, 
    animal_id: null, 
    date: null, 
    feedback: ''
})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: MonitorTypes) {
    fieldVal.value = props

    let fields = {
        id: props.id,
        user_id: props.staff.id,
        adopter_id: props.adopter.id,
        animal_id: props.animal.id,
        date: props.parsed_date,
        feedback: props.feedback,
    }

    form.defaults(fields)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

defineExpose({
    open
})
</script>