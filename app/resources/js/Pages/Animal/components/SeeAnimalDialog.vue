<template>
    <Dialog v-model:visible="visible" modal :header="`Pet`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex items-center lg:flex-row flex-col space-x-2">
                <div class="w-full lg:w-fit space-y-3">
                    <div class="flex flex-col gap-2">
                        <label for="status">Status</label>
                        <InputText id="status" v-model="form.status" aria-describedby="status-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="name">Name</label>
                        <InputText id="name" v-model="form.name" aria-describedby="name-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="type">Type</label>
                        <Select id="type" v-model="form.type" :options="['dog', 'cat']" aria-describedby="type-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="color">color</label>
                        <InputText id="color" v-model="form.color" aria-describedby="color-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="breed">breed</label>
                        <InputText id="breed" v-model="form.breed" aria-describedby="breed-help" disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="description">description</label>
                        <InputText id="description" v-model="form.description" aria-describedby="description-help"
                            disabled />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="age">age</label>
                        <InputNumber id="age" v-model="form.age" aria-describedby="age-help" disabled />
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-64 order-first lg:order-last">
                    <img v-if="form.media?.[0].original_url" :src="form.media?.[0].original_url" alt="Image" class="shadow-md rounded-xl w-64" />
                </div>
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { InputText, Select, InputNumber } from 'primevue';
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AnimalTypes } from '../Types/AnimalTypes'
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<AnimalTypes>({
    id: null,
    type: '',
    name: '',
    color: '',
    breed: '',
    description: '',
    age: 0,
    image: null,
    status: 'available'
})
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: AnimalTypes) {
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