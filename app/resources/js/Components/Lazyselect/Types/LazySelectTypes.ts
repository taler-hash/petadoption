export interface FilterLazySelectTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
}


export interface PaginationLazySelectTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
    data: any[]
}