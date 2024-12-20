<template>
    <Dialog v-model:visible="visible" modal :header="`Update Shelter Details`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <InputText id="name" v-model="form.name" aria-describedby="name-help" required />
                <InputError :message="form.errors.name" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="location">Location</label>
                <InputText id="location" v-model="form.location" aria-describedby="location-help" required />
                <InputError :message="form.errors.location" />
            </div>
            <div class="pt-4">
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText } from 'primevue';
import InputError from '../../../Components/InputError.vue'
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
    form.defaults(props)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.put(route('shelters.update'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated Shelter Details Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>