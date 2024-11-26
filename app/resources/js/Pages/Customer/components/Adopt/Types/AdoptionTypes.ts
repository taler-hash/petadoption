import { AnimalTypes } from "@/Pages/Animal/Types/AnimalTypes";

export interface AdoptionTypes {
    id?: number,
    name?: string|null,
    email?: string|null,
    phone?: number|null,
    appointment_date: any
}

export interface AdoptionFormTypes extends AdoptionTypes {
    animal?: AnimalTypes
}