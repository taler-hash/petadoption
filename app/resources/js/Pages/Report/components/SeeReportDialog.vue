<template>
    <Dialog v-model:visible="visible" modal :header="`Report`" @hide="close">
        <div class="space-y-4">
            <div class="flex flex-col gap-2 w-64 order-first lg:order-last">
                <img v-if="form.media?.[0].original_url" :src="form.media?.[0].original_url" alt="Image"
                    class="shadow-md rounded-xl w-64" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="location">Location</label>
                <InputText id="location" v-model="form.location" aria-describedby="location-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="landmark">Landmark</label>
                <InputText id="landmark" v-model="form.landmark" aria-describedby="landmark-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="contact_number">Contact Number</label>
                <InputText id="contact_number" v-model="form.contact_number" aria-describedby="contact_number-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="animal_status">Animal Status</label>
                <InputText id="animal_status" v-model="form.animal_status" aria-describedby="animal_status-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="status">Status</label>
                <InputText id="status" v-model="form.status" aria-describedby="status-help" disabled />
            </div>
        </div>
    </Dialog>
</template>
<script setup lang="ts">
import { InputText, Select, InputNumber } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ReportTypes } from '../Types/ReportTypes'
import { useToast } from 'primevue';

const form = useForm<ReportTypes>({
    id: 0,
    location: '',
    landmark: '',
    animal_status: 'healthy',
    status: 'pending',
    image: null
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: ReportTypes) {
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