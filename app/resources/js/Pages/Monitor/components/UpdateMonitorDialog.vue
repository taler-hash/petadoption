<template>
    <Dialog v-model:visible="visible" modal :header="`Update Feedback`" @hide="close">
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
                        <label for="date">Feedback Date</label>
                        <DatePicker id="date" v-model="form.date" aria-describedby="date-help"
                           rows="5" cols="30" required />
                        <InputError :message="form.errors.date" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="feedback">Feedback</label>
                        <Textarea id="feedback" v-model="form.feedback" aria-describedby="feedback-help"
                           rows="5" cols="30" required />
                        <InputError :message="form.errors.feedback" />
                    </div>
                    <div class="pt-4">
                        <Button type="submit" severity="success" label="submit" class="w-full" />
                    </div>
                </div>
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, DatePicker, Textarea } from 'primevue';
import InputError from '../../../Components/InputError.vue'
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

async function submit() {
    form.put(route('animals.update'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated Pet Details Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>