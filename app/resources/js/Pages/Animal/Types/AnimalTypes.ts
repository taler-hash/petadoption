import { AppointmentTypes } from "@/Pages/Appointment/Types/AppointmentTypes"

export interface FilterAnimalTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
    type?: string|null,
    status?: string|null
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface AnimalTypes {
    id?: number|null,
    type?: string|null,
    name?: string,
    color?: string,
    breed?: string,
    description?: string,
    age?: number,
    image?: any,
    updated_at?: string,
    created_at?: string,
    status?: string| null,
    media?: {
        original_url?: string
    }[],
    appointment?: AppointmentTypes
}

export interface AnimalPaginationTypes extends PaginationTypes {
    data:  AnimalTypes[]
}