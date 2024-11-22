export interface FilterWithRoleTypes {
    page?: number,
    sortBy?: string,
    sortType?: 'desc'|'asc'|string,
    rows?: number,
    searchString?: string,
    role?: string
}

export interface PaginationTypes {
    current_page: number,
    from: number,
    per_page:number,
    to: number,
    total: number,
}

export interface UserTypes {
    id?: number|null,
    username?: string,
    name?: string,
    password?:string|null,
    updated_at?: string,
    created_at?: string,
    status?: string| null
}

export interface UserPaginationTypes extends PaginationTypes {
    data:  UserTypes[]
}