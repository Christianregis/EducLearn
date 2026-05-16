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
import FilterSidebar from '@/Components/FilterSidebar.vue'
import ProductCard from '@/Components/ProductCard.vue'
import Footer from '@/Components/Public/Footer.vue'
import Navigation from '@/Components/Public/Navigation.vue'
import type { Product } from '@/types/Product'

interface Props {
    products: {
        data: Product[]
    }
}
const props = defineProps<Props>()
// Mock Data
const allProducts: Product[] = props.products.data

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
