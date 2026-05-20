export function progressColor(progress: number): string {
    if (progress === 100) {
        return '#10B981'
    }

    if (progress >= 50) {
        return '#F4B400'
    }

    return '#F97316'
}
