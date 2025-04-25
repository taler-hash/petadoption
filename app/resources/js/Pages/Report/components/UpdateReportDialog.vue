<template>
    <Dialog
        v-model:visible="visible"
        modal
        :header="`Update Report Details`"
        @hide="close"
    >
        <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-4">
                <div class="flex flex-col gap-2">
                    <label for="location">Location</label>
                    <InputText
                        id="location"
                        v-model="form.location"
                        aria-describedby="location-help"
                        disabled
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="landmark">Landmark</label>
                    <InputText
                        id="landmark"
                        v-model="form.landmark"
                        aria-describedby="landmark-help"
                        disabled
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="contact_number">Contact Number</label>
                    <InputText
                        id="contact_number"
                        v-model="form.contact_number"
                        aria-describedby="contact_number-help"
                        disabled
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="animal_status">Animal Status</label>
                    <InputText
                        id="animal_status"
                        v-model="form.animal_status"
                        aria-describedby="animal_status-help"
                        disabled
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="status">Status</label>
                    <Select
                        id="status"
                        v-model="form.status"
                        aria-describedby="status-help"
                        :options="['pending', 'rescued']"
                    />
                </div>
                <div class="pt-4">
                <Button type="submit" severity="success" label="submit" class="w-full" :disabled="!form.isDirty" />
            </div>
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { InputText } from "primevue";
import { Dialog } from "primevue";
import { inject, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ReportTypes } from "../Types/ReportTypes";
import { useToast } from "primevue";
import { Select, Button } from "primevue";

const toast = useToast();
const form = useForm<ReportTypes>({
    id: 0,
    location: '',
    landmark: '',
    animal_status: 'healthy',
    status: 'pending'
});

const reloadTable = inject<any>("reloadTable");
const visible = ref<boolean>(false);

function open(props: ReportTypes) {
    form.defaults(props);
    form.reset();
    visible.value = true;
}

function close() {
    visible.value = false;
    form.reset();
    reloadTable();
}

async function submit() {
    form.put(route("reports.update"), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: `Updated Report Details Successfully`,
                life: 3000,
            });
            close();
            form.reset();
        },
    });
}

defineExpose({
    open,
});
</script>
