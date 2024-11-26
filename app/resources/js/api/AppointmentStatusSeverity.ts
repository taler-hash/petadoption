export function AppointmentStatusSeverity(status: string) {
    const statuses: {[status:string]: string} = {
        pending: '!bg-amber-500',
        confirmed: '!bg-blue-500',
        completed: '!bg-green-500',
        cancelled: '!bg-red-500'
    }
    return statuses[status]
}