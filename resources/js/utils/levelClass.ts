export function levelClass(level: string): string {
    const map: Record<string, string> = {
        'Débutant': 'bg-emerald-50 text-emerald-600',
        'Intermédiaire': 'bg-blue-50 text-blue-600',
        'Avancé': 'bg-purple-50 text-purple-600',
    }

    return map[level] ?? 'bg-gray-100 text-gray-500'
}
