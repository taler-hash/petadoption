import { AdopterTypes } from "@/Pages/Adopter/Types/AdopterTypes";
import { AnimalTypes } from "@/Pages/Animal/Types/AnimalTypes";
import { UserTypes } from "@/Pages/Staff/Types/StaffTypes";

export interface FilterMonitorTypes {
    trash: boolean,
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

export interface MonitorTypes {
    id?: number|null,
    date: string|null,
    animal: AnimalTypes,
    adopter: AdopterTypes,
    staff: UserTypes,
    feedback: string,
    parsed_date: Date|null,
}

export interface MonitorFormTypes {
    id?: number|null,
    user_id: number|null, 
    adopter_id: number|null, 
    animal_id: number|null, 
    date: Date|null, 
    feedback: string
}

export interface MonitorPaginationTypes extends PaginationTypes {
    data: MonitorTypes[]
}