<template>
    <Dialog v-model:visible="visible" modal :header="`Add Feedback`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex items-center">
                <div class="w-full">
                    <div class="flex flex-col gap-2">
                        <label for="animal_id">Pet</label>
                        <Select id="animal_id" v-model="form.animal_id" :options="adoptedAnimals" option-label="name" option-value="id" aria-describedby="animal_id-help" required />
                        <InputError :message="form.errors.animal_id" />
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
import { DatePicker , Select, Textarea } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AnimalTypes } from '../Types/AnimalTypes'
import { useToast } from 'primevue';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import axios from 'axios';
import { MonitorFormTypes } from '../Types/MonitorTypes';

const page = usePage()
const toast = useToast()
const form = useForm<MonitorFormTypes>({
    user_id: page.props.auth.user.id,
    adopter_id: null,
    animal_id: null,
    date: null,
    feedback: ''
})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)
const adoptedAnimals = ref<AnimalTypes[]>([])

watch(visible, (newValue) => {
    if (newValue) {
        getAdoptedAnimals()
    }
});

async function getAdoptedAnimals(): Promise<void> {
    const res = await axios.get(route('animals.getAdoptedAnimals'))

    if(res.status === 200) {
        adoptedAnimals.value = res.data
    }
}

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.post(route('monitor.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Added Feedback Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>