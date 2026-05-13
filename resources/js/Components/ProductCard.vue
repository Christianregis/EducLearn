<template>
    <div
        class="group bg-white rounded-xl overflow-hidden border border-yellow-100 hover:border-yellow-300 hover:shadow-lg transition-all duration-300">
        <!-- Image Container -->
        <div class="relative overflow-hidden bg-linear-to-br from-yellow-50 to-yellow-100 h-48">
            <img :src="product.image" :alt="product.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />

            <!-- Format Badge -->
            <div
                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-yellow-700 flex items-center gap-1">
                <i :class="getFormatIcon(product.format)"></i>
                {{ product.format }}
            </div>

            <!-- Discount Badge (if applicable) -->
            <div v-if="product.oldPrice && product.oldPrice > product.price"
                class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                -{{ Math.round(((product.oldPrice - product.price) / product.oldPrice) * 100) }}%
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300"></div>
        </div>

        <!-- Content -->
        <div class="p-4 flex flex-col h-full">
            <!-- Title -->
            <h3 class="font-bold text-gray-900 line-clamp-2 mb-2 group-hover:text-yellow-600 transition-colors">
                {{ product.title }}
            </h3>

            <!-- Meta Info -->
            <div class="flex items-center gap-4 text-xs text-gray-600 mb-3">
                <span class="flex items-center gap-1">
                    <i class="fas fa-users"></i>
                    {{ product.students }}
                </span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-clock"></i>
                    {{ product.duration }}
                </span>
            </div>

            <!-- Level Badge -->
            <div class="mb-3">
                <span :class="[
                    'text-xs font-semibold px-2 py-1 rounded-full',
                    product.level === 'Débutant' ? 'bg-green-100 text-green-700' :
                        product.level === 'Intermédiaire' ? 'bg-blue-100 text-blue-700' :
                            'bg-purple-100 text-purple-700'
                ]">
                    {{ product.level }}
                </span>
            </div>

            <!-- Spacer -->
            <div class="flex-1"></div>

            <!-- Price & Button -->
            <div class="flex items-center justify-between gap-2 pt-3 border-t border-yellow-100">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-gray-900">${{ product.price.toFixed(2) }}</span>
                    <span v-if="product.oldPrice" class="text-xs text-gray-400 line-through">
                        ${{ product.oldPrice.toFixed(2) }}
                    </span>
                </div>
                <button @click="addToCart" :disabled="isLoading"
                    class="p-2 bg-linear-to-r from-yellow-400 to-yellow-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50">
                    <i class="fas fa-shopping-cart text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { Product } from '@/types/Product';
import { useCartStore } from '../store/cartStore';



const props = defineProps<{
    product: Product
}>()

const cartStore = useCartStore()
const isLoading = ref(false)

const getFormatIcon = (format: string): string => {
    const icons: Record<string, string> = {
        'Audio': 'fas fa-headphones',
        'Video': 'fas fa-play-circle',
        'PDF': 'fas fa-file-pdf'
    }

    return icons[format] || 'fas fa-file'
}

const addToCart = async (): Promise<void> => {
    isLoading.value = true

    try {
        await new Promise(resolve => setTimeout(resolve, 300))
        cartStore.addItem({
            id: props.product.id,
            title: props.product.title,
            price: props.product.price,
            image: props.product.image,
            format: props.product.format
        })
    } finally {
        isLoading.value = false
    }
}
</script>
