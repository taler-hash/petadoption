export function AnimalStatusSeverity(status: string) {
    const statuses: {[status:string]: string} = {
        pending: '!bg-amber-500',
        adopted: '!bg-green-500',
        available: '!bg-blue-500'
    }
    return statuses[status]
}