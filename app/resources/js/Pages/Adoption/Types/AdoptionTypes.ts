import { AdopterTypes } from "@/Pages/Adopter/Types/AdopterTypes";
import { AnimalTypes } from "@/Pages/Animal/Types/AnimalTypes";

export interface FilterAdoptionTypes {
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

export interface AdoptionTypes {
    adoption_date: string|null,
    animal: AnimalTypes,
    adopter: AdopterTypes,
    parsed_adoption_date: string,
    status: string
}

export interface AdoptionPaginationTypes extends PaginationTypes {
    data: AdoptionTypes[]
}