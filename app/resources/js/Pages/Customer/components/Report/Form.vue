<template>
    <div class="w-full p-4 px-8 grid place-items-center">
        <Shelters
            v-if="!formOpen"
            v-model="filters.shelter"
            @callback="getShelter"
        />
        <div v-else class="w-96">
            <form @submit.prevent="submit" class="space-y-4">
                <div class="flex items-center justify-between">
                    <p>Shelter: {{ shelter.name }}</p>
                    <Button severity="ghost" @click="handleBack">
                        <ChevronLeft />
                    </Button>
                </div>
                <div class="flex flex-col gap-2 w-full order-first lg:order-last items-center">
                    <img v-if="form.image" :src="form.image" alt="Image" class="shadow-md rounded-xl w-64" />
                    <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary" choose-label="Choose Image"
                        class="p-button-outlined" />
                    <InputError :message="form.errors.image" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="location">Location</label>
                    <InputText
                        id="location"
                        v-model="form.location"
                        aria-describedby="location-help"
                        required
                    />
                    <InputError :message="form.errors.location" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="landmark">Landmark</label>
                    <InputText
                        id="landmark"
                        v-model="form.landmark"
                        aria-describedby="landmark-help"
                        required
                    />
                    <InputError :message="form.errors.landmark" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="animal_status">animal_status</label>
                    <Select
                        id="animal_status"
                        v-model="form.animal_status"
                        :options="['healthy', 'injury']"
                        aria-describedby="animal_status-help"
                        required
                    />
                    <InputError :message="form.errors.animal_status" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="contact_number">Contact Number</label>
                    <InputText
                        id="contact_number"
                        v-model="form.contact_number"
                        aria-describedby="contact_number-help"
                        required
                    />
                    <InputError :message="form.errors.contact_number" />
                </div>
                <div class="pt-4">
                    <Button
                        type="submit"
                        severity="success"
                        label="submit"
                        class="w-full"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { useForm } from "@inertiajs/vue3";
import Shelters from "./Shelters.vue";
import { FilterAnimalTypes } from "@/Pages/Animal/Types/AnimalTypes";
import { ref } from "vue";
import axios from "axios";
import { InputText, Button, Select, useToast, FileUpload } from "primevue";
import { ShelterTypes } from "@/Pages/Shelter/Types/ShelterTypes";
import { ChevronLeft } from "lucide-vue-next";
import InputError from "@/Components/InputError.vue";

const toast = useToast();
const formOpen = ref<boolean>(false);
const shelter = ref<ShelterTypes>({});
const filters = ref<FilterAnimalTypes>({
    page: 1,
    sortBy: "id",
    sortType: "desc",
    rows: 10,
    searchString: "",
    type: "dog",
    status: "available",
    shelter: undefined,
});

const form = useForm<any>({
    shelter_id: "",
    location: "",
    landmark: "",
    animal_status: "healthy",
    status: "pending",
    contact_number: "",
    image: null,
});

function getShelter() {
    axios
        .get(route("customers.shelters.show"), {
            params: { id: filters.value.shelter },
        })
        .then((res) => {
            form.shelter_id = res.data.id;
            formOpen.value = true;
            shelter.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });

}

function handleBack() {
    filters.value.shelter = undefined;
    shelter.value = {};
    form.reset();
    formOpen.value = false;
}

function onFileSelect(event: any) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        form.image = e.target?.result;
    };

    reader.readAsDataURL(file);
}

async function submit() {
    form.post(route("customers.report.store"), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: `Added Report Successfully`,
                life: 3000,
            });
            close();
            form.reset();
            handleBack()
        },
    });
}
</script>
