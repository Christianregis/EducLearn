export interface Product {
    id: number
    title: string
    students: number
    duration: string
    price: number
    oldPrice?: number
    level: 'Débutant' | 'Intermédiaire' | 'Avancé'
    image: string
    file: string
    format: 'Audio' | 'Video' | 'PDF'
}
