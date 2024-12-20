<template>
    <Dialog v-model:visible="visible" modal :header="`Shelter`" @hide="close">
        <div class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <InputText id="name" v-model="form.name" aria-describedby="name-help" disabled />
            </div>
            <div class="flex flex-col gap-2">
                <label for="location">Location</label>
                <InputText id="location" v-model="form.location" aria-describedby="location-help" disabled />
            </div>
        </div>
    </Dialog>
</template>
<script setup lang="ts">
import { InputText, Select, InputNumber } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ShelterTypes } from '../Types/ShelterTypes'
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<ShelterTypes>({
    id: null,
    name: '',
    location: ''
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: ShelterTypes) {
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