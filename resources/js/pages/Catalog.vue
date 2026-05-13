<template>
    <div class="min-h-screen bg-linear-to-b from-white via-yellow-50 to-white">
        <!-- Navbar -->
        <Navigation />

        <!-- Main Content -->
        <main class="pt-24 pb-12">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-6 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                            Apprenez à votre <span class="text-yellow-600">rythme</span>
                        </h1>
                        <p class="text-lg text-gray-600 mb-6">
                            Découvrez une vaste collection de cours en ligne, disponibles en audio, vidéo et PDF.
                            Progressez dans vos domaines préférés avec des instructeurs experts.
                        </p>
                        <button
                            class="bg-linear-to-r from-yellow-400 to-yellow-600 text-white font-bold px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                            Explorez le catalogue
                        </button>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-full h-64 bg-linear-to-r from-yellow-200 to-yellow-400 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-8xl opacity-20"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Filters & Products -->
            <section class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Sidebar Filters -->
                    <FilterSidebar @filter="handleFilter" />

                    <!-- Products Grid -->
                    <div class="lg:col-span-3">
                        <!-- Results Info -->
                        <div class="mb-6 flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Tous les cours
                                <span class="text-sm text-gray-500 font-normal">({{ filteredProducts.length }}
                                    résultats)</span>
                            </h2>
                        </div>

                        <!-- Products Grid -->
                        <div v-if="filteredProducts.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product" />
                        </div>

                        <!-- Empty State -->
                        <div v-else class="flex flex-col items-center justify-center py-16 text-center">
                            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun cours trouvé</h3>
                            <p class="text-gray-600 mb-6">Essayez d'ajuster vos filtres ou votre recherche</p>
                            <button @click="resetFilters"
                                class="text-yellow-600 hover:text-yellow-700 font-semibold transition-colors">
                                Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="mt-20 py-12 bg-linear-to-r from-yellow-400 to-yellow-600">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">50K+</div>
                            <p class="text-yellow-100">Étudiants actifs</p>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">500+</div>
                            <p class="text-yellow-100">Cours disponibles</p>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">98%</div>
                            <p class="text-yellow-100">Satisfaction client</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { Product } from '@/types/Product'
import FilterSidebar from '@/Components/FilterSidebar.vue'
import ProductCard from '@/Components/ProductCard.vue'
import Footer from '@/Components/Public/Footer.vue'
import Navigation from '@/Components/Public/Navigation.vue'

// Mock Data
const allProducts: Product[] = [
    {
        id: 1,
        title: 'Web Design Mastery',
        students: 3250,
        duration: '4h 30m',
        price: 45.99,
        oldPrice: 89.99,
        level: 'Débutant',
        image: 'https://placehold.co/400x300/ddd6fe/7c3aed?text=Web+Design',
        format: 'Video'
    },
    {
        id: 2,
        title: 'Education Software and PHP and JS System Script',
        students: 4280,
        duration: '2h 15m',
        price: 33.99,
        oldPrice: 69.99,
        level: 'Intermédiaire',
        image: 'https://placehold.co/400x300/fef3c7/78350f?text=PHP+JS+System',
        format: 'Video'
    },
    {
        id: 3,
        title: 'The Complete Financial Analyst Training & Investing',
        students: 5957,
        duration: '5h 49m',
        price: 45.99,
        level: 'Avancé',
        image: 'https://placehold.co/400x300/fce7f3/be185d?text=Financial+Analyst',
        format: 'Audio'
    },
    {
        id: 4,
        title: 'Digital Marketing Fundamentals',
        students: 2150,
        duration: '3h 20m',
        price: 29.99,
        level: 'Débutant',
        image: 'https://placehold.co/400x300/fef3c7/d97706?text=Digital+Marketing',
        format: 'PDF'
    },
    {
        id: 5,
        title: 'Advanced JavaScript Patterns',
        students: 3890,
        duration: '4h 45m',
        price: 55.99,
        oldPrice: 99.99,
        level: 'Avancé',
        image: 'https://placehold.co/400x300/fef3c7/f59e0b?text=JavaScript',
        format: 'Video'
    },
    {
        id: 6,
        title: 'UI/UX Design Principles',
        students: 2780,
        duration: '3h 15m',
        price: 39.99,
        level: 'Intermédiaire',
        image: 'https://placehold.co/400x300/ddd6fe/6366f1?text=UI+UX+Design',
        format: 'Video'
    },
    {
        id: 7,
        title: 'Python for Data Science',
        students: 6420,
        duration: '6h 30m',
        price: 49.99,
        oldPrice: 99.99,
        level: 'Intermédiaire',
        image: 'https://placehold.co/400x300/fef3c7/ca8a04?text=Python+Data',
        format: 'Audio'
    },
    {
        id: 8,
        title: 'SEO Mastery Course',
        students: 1950,
        duration: '2h 40m',
        price: 34.99,
        level: 'Débutant',
        image: 'https://placehold.co/400x300/fef3c7/b45309?text=SEO+Mastery',
        format: 'PDF'
    },
    {
        id: 9,
        title: 'Cloud Architecture with AWS',
        students: 4560,
        duration: '5h 20m',
        price: 59.99,
        level: 'Avancé',
        image: 'https://placehold.co/400x300/fef3c7/92400e?text=AWS+Cloud',
        format: 'Video'
    }
]

const filteredProducts = ref<Product[]>(allProducts)
const currentFilters = ref({
    search: '',
    formats: ['Audio', 'Video', 'PDF'],
    levels: ['Débutant', 'Intermédiaire', 'Avancé'],
    maxPrice: 200,
    sortBy: 'newest'
})

const handleFilter = (filters: any): void => {
    currentFilters.value = filters

    const results = allProducts.filter(product => {
        const matchesSearch = product.title.toLowerCase().includes(filters.search.toLowerCase())
        const matchesFormat = filters.formats.includes(product.format)
        const matchesLevel = filters.levels.includes(product.level)
        const matchesPrice = product.price <= filters.maxPrice

        return matchesSearch && matchesFormat && matchesLevel && matchesPrice
    })

    // Apply sorting
    switch (filters.sortBy) {
        case 'popular':
            results.sort((a, b) => b.students - a.students)
            break
        case 'price-low':
            results.sort((a, b) => a.price - b.price)
            break
        case 'price-high':
            results.sort((a, b) => b.price - a.price)
            break
        case 'newest':
        default:
            // Keep original order
            break
    }

    filteredProducts.value = results
}

const resetFilters = (): void => {
    currentFilters.value = {
        search: '',
        formats: ['Audio', 'Video', 'PDF'],
        levels: ['Débutant', 'Intermédiaire', 'Avancé'],
        maxPrice: 200,
        sortBy: 'newest'
    }
    filteredProducts.value = allProducts
}
</script>
