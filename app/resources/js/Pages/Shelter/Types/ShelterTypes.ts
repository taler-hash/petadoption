import { AdoptionTypes } from "@/Pages/Adoption/Types/AdoptionTypes"
import { AnimalTypes } from "@/Pages/Animal/Types/AnimalTypes"
import { AppointmentTypes } from "@/Pages/Appointment/Types/AppointmentTypes"

export interface FilterShelterTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface ShelterTypes {
    id?: number|null,
    name?: string,
    location?: string,
    appointments?: AppointmentTypes[],
    adoptions?: AdoptionTypes[],
    animals?: AnimalTypes[]
}

export interface ShelterPaginationTypes extends PaginationTypes {
    data:  ShelterTypes[]
}