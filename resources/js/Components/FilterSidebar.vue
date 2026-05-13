<template>
    <aside class="w-full lg:w-72 bg-white rounded-xl border border-yellow-100 p-6 h-fit sticky top-24">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Filtres</h3>
            <button @click="resetFilters" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                Réinitialiser
            </button>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input v-model="searchQuery" type="text" placeholder="Rechercher un cours..."
                class="w-full px-4 py-2.5 border border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all text-sm" />
        </div>

        <!-- Format Filter -->
        <div class="mb-6 pb-6 border-b border-yellow-100">
            <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Format</h4>
            <div class="space-y-2">
                <label v-for="format in formats" :key="format" class="flex items-center gap-3 cursor-pointer group">
                    <input v-model="selectedFormats" type="checkbox" :value="format"
                        class="w-4 h-4 rounded border-yellow-300 text-yellow-500 focus:ring-yellow-400 cursor-pointer" />
                    <span class="text-sm text-gray-700 group-hover:text-yellow-600 transition-colors">{{ format }}</span>
                </label>
            </div>
        </div>

        <!-- Level Filter -->
        <div class="mb-6 pb-6 border-b border-yellow-100">
            <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Niveau</h4>
            <div class="space-y-2">
                <label v-for="level in levels" :key="level" class="flex items-center gap-3 cursor-pointer group">
                    <input v-model="selectedLevels" type="checkbox" :value="level"
                        class="w-4 h-4 rounded border-yellow-300 text-yellow-500 focus:ring-yellow-400 cursor-pointer" />
                    <span class="text-sm text-gray-700 group-hover:text-yellow-600 transition-colors">{{ level }}</span>
                </label>
            </div>
        </div>

        <!-- Price Range -->
        <div class="mb-6 pb-6 border-b border-yellow-100">
            <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Prix Max</h4>
            <div class="space-y-3">
                <input v-model.number="maxPrice" type="range" min="0" max="200" step="5"
                    class="w-full h-2 bg-yellow-200 rounded-lg appearance-none cursor-pointer accent-yellow-500" />
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">$0</span>
                    <span class="font-bold text-yellow-600">${{ maxPrice }}</span>
                </div>
            </div>
        </div>

        <!-- Sort -->
        <div class="mb-6">
            <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Trier par</h4>
            <select v-model="sortBy"
                class="w-full px-4 py-2.5 border border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all text-sm bg-white cursor-pointer">
                <option value="newest">Plus récent</option>
                <option value="popular">Plus populaire</option>
                <option value="price-low">Prix: bas à haut</option>
                <option value="price-high">Prix: haut à bas</option>
            </select>
        </div>

        <!-- Apply Button -->
        <button @click="applyFilters"
            class="w-full bg-linear-to-r from-yellow-400 to-yellow-600 text-white font-bold py-2.5 rounded-lg hover:shadow-lg transition-shadow">
            Appliquer les filtres
        </button>
    </aside>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const searchQuery = ref('')
const selectedFormats = ref<string[]>(['Audio', 'Video', 'PDF'])
const selectedLevels = ref<string[]>(['Débutant', 'Intermédiaire', 'Avancé'])
const maxPrice = ref(200)
const sortBy = ref('newest')

const formats = ['Audio', 'Video', 'PDF']
const levels = ['Débutant', 'Intermédiaire', 'Avancé']

const emit = defineEmits<{
    (e: 'filter', payload: {
        search: string
        formats: string[]
        levels: string[]
        maxPrice: number
        sortBy: string
    }): void
}>()

const applyFilters = (): void => {
    emit('filter', {
        search: searchQuery.value,
        formats: selectedFormats.value,
        levels: selectedLevels.value,
        maxPrice: maxPrice.value,
        sortBy: sortBy.value
    })
}

const resetFilters = (): void => {
    searchQuery.value = ''
    selectedFormats.value = ['Audio', 'Video', 'PDF']
    selectedLevels.value = ['Débutant', 'Intermédiaire', 'Avancé']
    maxPrice.value = 200
    sortBy.value = 'newest'
    applyFilters()
}
</script>
