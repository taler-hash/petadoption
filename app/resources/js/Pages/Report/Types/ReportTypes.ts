import { ShelterTypes } from "@/Pages/Shelter/Types/ShelterTypes";

export interface FilterReportTypes {
    trash?: boolean,
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

export interface ReportTypes {
    id: number;
    shelter_id?: number;
    location: string;
    landmark: string;
    animal_status: 'healthy' | 'injury';
    status: 'pending' | 'rescued';
    contact_number?: string;
    shelter?: ShelterTypes;
    media?: {
        original_url?: string
    }[],
    image?: any,
}

export interface ReportPaginationTypes extends PaginationTypes {
    data:  ReportTypes[]
}