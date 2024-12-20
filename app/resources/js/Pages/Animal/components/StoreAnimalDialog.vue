<template>
    <Dialog v-model:visible="visible" modal :header="`Add Pet`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex items-center lg:flex-row flex-col space-x-2">
                <div class="w-full lg:w-fit space-y-3">
                    <div class="flex flex-col gap-2">
                        <label for="name">Name</label>
                        <InputText id="name" v-model="form.name" aria-describedby="name-help" required />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="type">Type</label>
                        <Select id="type" v-model="form.type" :options="['dog', 'cat']" aria-describedby="type-help" required />
                        <InputError :message="form.errors.type" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="color">color</label>
                        <InputText id="color" v-model="form.color" aria-describedby="color-help" required />
                        <InputError :message="form.errors.color" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="breed">breed</label>
                        <InputText id="breed" v-model="form.breed" aria-describedby="breed-help" required />
                        <InputError :message="form.errors.breed" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="description">description</label>
                        <Textarea id="description" v-model="form.description" aria-describedby="description-help"
                           rows="5" cols="30" required />
                        <InputError :message="form.errors.description" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="age">age</label>
                        <InputNumber id="age" v-model="form.age" aria-describedby="age-help" required />
                        <InputError :message="form.errors.age" />
                    </div>
                    <div class="pt-4">
                        <Button type="submit" severity="success" label="submit" class="w-full" />
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-64 order-first lg:order-last">
                    <img v-if="form.image" :src="form.image" alt="Image" class="shadow-md rounded-xl w-64" />
                    <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary" choose-label="Choose Image"
                        class="p-button-outlined" />
                    <InputError :message="form.errors.image" />
                </div>
            </div>

        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, InputNumber, FileUpload, Select, Textarea } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AnimalTypes } from '../Types/AnimalTypes'
import { useToast } from 'primevue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
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
    status: 'available',
    //@ts-ignore
    shelter_id: page.props.auth.user?.shelter.id 
})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.post(route('animals.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Added Pet Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

function onFileSelect(event: any) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        form.image = e.target?.result;
    };

    reader.readAsDataURL(file);
}

defineExpose({
    open
})
</script>