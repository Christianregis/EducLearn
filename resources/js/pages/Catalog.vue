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
                            <!-- Wrapper clickable autour de chaque ProductCard -->
                            <div v-for="product in filteredProducts" :key="product.id" class="cursor-pointer"
                                @click="openDetail(product)">
                                <ProductCard :product="product" />
                            </div>
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

        <!-- ── DETAIL DRAWER (right sidebar) ── -->
        <Transition name="drawer">
            <div v-if="selectedProduct" class="fixed inset-0 z-50 flex justify-end">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]" @click="selectedProduct = null">
                </div>

                <!-- Panel -->
                <div class="relative w-full max-w-md bg-white h-full overflow-y-auto shadow-2xl flex flex-col z-10">

                    <!-- ── HEADER ── -->
                    <div
                        class="px-6 py-5 flex items-center justify-between border-b border-gray-100 sticky top-0 bg-white z-10">
                        <!-- Format badge -->
                        <span class="inline-flex items-center gap-2 text-[12px] font-bold px-3 py-1.5 rounded-full"
                            :class="formatConfig(selectedProduct.format).badgeClass">
                            <i :class="formatConfig(selectedProduct.format).icon + ' text-[10px]'"></i>
                            {{ selectedProduct.format }}
                        </span>

                        <!-- Close -->
                        <button @click="selectedProduct = null"
                            class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors cursor-pointer text-[11px]">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- ── COVER / MEDIA ZONE ── -->
                    <!-- PDF: image de couverture avec badge PDF -->
                    <div v-if="selectedProduct.format === 'PDF'" class="relative w-full overflow-hidden"
                        style="background: linear-gradient(135deg,#FEF3C7 0%,#FDE68A 100%); min-height:200px">
                        <img v-if="selectedProduct.image" :src="selectedProduct.image" class="w-full h-48 object-cover"
                            :alt="selectedProduct.title" />
                        <div v-else class="w-full h-48 flex items-center justify-center">
                            <i class="fas fa-file-pdf text-[72px] text-red-300 opacity-60"></i>
                        </div>
                        <!-- PDF watermark -->
                        <span
                            class="absolute bottom-3 left-3 text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1"
                            style="background:rgba(220,38,38,0.12); color:#DC2626; border:1px solid rgba(220,38,38,0.2)">
                            <i class="fas fa-file-pdf text-[9px]"></i> Document PDF
                        </span>
                    </div>

                    <!-- VIDEO: thumbnail avec bouton play stylisé -->
                    <div v-else-if="selectedProduct.format === 'Video'"
                        class="relative w-full overflow-hidden bg-gray-900" style="min-height:200px">
                        <img v-if="selectedProduct.image" :src="selectedProduct.image"
                            class="w-full h-48 object-cover opacity-80" :alt="selectedProduct.title" />
                        <div v-else class="w-full h-48 flex items-center justify-center"
                            style="background:linear-gradient(135deg,#1e1b4b 0%,#312e81 100%)">
                            <i class="fas fa-film text-[72px] text-indigo-200 opacity-30"></i>
                        </div>
                        <!-- Play button overlay -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-xl"
                                style="background:rgba(255,255,255,0.9); backdrop-filter:blur(4px)">
                                <i class="fas fa-play text-indigo-600 text-[18px] ml-1"></i>
                            </div>
                        </div>
                        <span
                            class="absolute bottom-3 left-3 text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1"
                            style="background:rgba(0,0,0,0.5); color:#fff; backdrop-filter:blur(4px)">
                            <i class="fas fa-clock text-[9px]"></i> {{ selectedProduct.duration }}
                        </span>
                    </div>

                    <!-- AUDIO: artwork + waveform décorative -->
                    <div v-else-if="selectedProduct.format === 'Audio'"
                        class="relative w-full overflow-hidden flex flex-col items-center justify-center gap-4 py-6"
                        style="background:linear-gradient(160deg,#FDF4FF 0%,#FAE8FF 100%); min-height:200px">
                        <!-- Album art circle -->
                        <div class="w-24 h-24 rounded-full shadow-xl flex items-center justify-center"
                            style="background:linear-gradient(135deg,#D946EF,#9333EA)">
                            <img v-if="selectedProduct.image" :src="selectedProduct.image"
                                class="w-full h-full object-cover rounded-full" />
                            <i v-else class="fas fa-music text-white text-[32px]"></i>
                        </div>
                        <!-- Fake waveform -->
                        <div class="flex items-end gap-0.75 h-8 w-3/4 justify-center">
                            <div v-for="(h, i) in audioWaveBars" :key="i" class="rounded-full flex-1 max-w-1.25"
                                style="background:#D946EF; opacity:0.45" :style="`height:${h}%`"></div>
                        </div>
                        <span class="text-[11px] font-bold px-3 py-1 rounded-full flex items-center gap-1"
                            style="background:rgba(217,70,239,0.12); color:#9333EA; border:1px solid rgba(217,70,239,0.2)">
                            <i class="fas fa-headphones text-[9px]"></i> Cours audio · {{ selectedProduct.duration }}
                        </span>
                    </div>

                    <!-- ── CONTENT ── -->
                    <div class="p-6 flex flex-col gap-5 flex-1">

                        <!-- Title + lock indicator -->
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <h2 class="text-[19px] font-extrabold text-gray-900 leading-snug">
                                    {{ selectedProduct.title }}
                                </h2>
                            </div>
                            <!-- Cadenas si cours payant -->
                            <div v-if="selectedProduct.price > 0"
                                class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                style="background:#FEF3C7" title="Cours payant – accès restreint">
                                <i class="fas fa-lock text-yellow-600 text-[15px]"></i>
                            </div>
                            <div v-else class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                style="background:#D1FAE5" title="Cours gratuit – accès libre">
                                <i class="fas fa-lock-open text-emerald-600 text-[15px]"></i>
                            </div>
                        </div>

                        <!-- Prix + ancien prix -->
                        <div class="flex items-center gap-3">
                            <span v-if="selectedProduct.price > 0" class="text-[22px] font-extrabold text-yellow-600">
                                {{ selectedProduct.price }} €
                            </span>
                            <span v-else class="text-[22px] font-extrabold text-emerald-600">
                                Gratuit
                            </span>
                            <span v-if="selectedProduct.oldPrice && selectedProduct.price > 0"
                                class="text-[14px] text-gray-400 line-through font-medium">
                                {{ selectedProduct.oldPrice }} €
                            </span>
                            <!-- Réduction badge -->
                            <span v-if="selectedProduct.oldPrice && selectedProduct.price > 0"
                                class="text-[11px] font-bold px-2 py-0.5 rounded-full"
                                style="background:#FEF3C7; color:#D97706">
                                -{{ Math.round((1 - selectedProduct.price / selectedProduct.oldPrice) * 100) }}%
                            </span>
                        </div>

                        <!-- Metadata pills -->
                        <div class="flex flex-wrap gap-2">
                            <!-- Niveau -->
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full"
                                :class="levelBadgeClass(selectedProduct.level)">
                                <i class="fas fa-signal text-[9px]"></i>
                                {{ selectedProduct.level }}
                            </span>
                            <!-- Durée -->
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-600">
                                <i class="fas fa-clock text-[9px]"></i>
                                {{ selectedProduct.duration }}
                            </span>
                            <!-- Étudiants -->
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-600">
                                <i class="fas fa-users text-[9px]"></i>
                                {{ selectedProduct.students.toLocaleString('fr-FR') }} étudiants
                            </span>
                        </div>

                        <!-- Séparateur -->
                        <hr class="border-gray-100" />

                        <!-- Accès restreint — bloc cadenas détaillé (cours payant uniquement) -->
                        <div v-if="selectedProduct.price > 0" class="rounded-2xl p-4 flex items-start gap-4"
                            style="background:#FFFBEB; border:1px solid #FDE68A">
                            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-lock text-yellow-600 text-[15px]"></i>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-yellow-800 mb-0.5">Contenu protégé</p>
                                <p class="text-[12px] text-yellow-700 leading-relaxed">
                                    Ce cours est payant. Achetez-le pour débloquer l'accès complet
                                    <span class="font-bold">
                                        {{ formatConfig(selectedProduct.format).accessLabel }}
                                    </span>.
                                </p>
                            </div>
                        </div>

                        <!-- Accès libre (cours gratuit) -->
                        <div v-else class="rounded-2xl p-4 flex items-start gap-4"
                            style="background:#F0FDF4; border:1px solid #BBF7D0">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-lock-open text-emerald-600 text-[15px]"></i>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-emerald-800 mb-0.5">Accès libre</p>
                                <p class="text-[12px] text-emerald-700 leading-relaxed">
                                    Ce cours est gratuit. Commencez à apprendre dès maintenant sans aucun prérequis.
                                </p>
                            </div>
                        </div>

                        <!-- Contenu spécifique au format -->

                        <!-- PDF: aperçu info -->
                        <div v-if="selectedProduct.format === 'PDF'" class="rounded-2xl p-4 flex items-start gap-4"
                            style="background:#FEF2F2; border:1px solid #FECACA">
                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-[15px]"></i>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-red-800 mb-0.5">Document PDF</p>
                                <p class="text-[12px] text-red-700 leading-relaxed">
                                    Téléchargeable et consultable hors ligne. Lisez à votre rythme, surlignez et annotez
                                    librement.
                                </p>
                            </div>
                        </div>

                        <!-- VIDEO: info lecteur -->
                        <div v-else-if="selectedProduct.format === 'Video'"
                            class="rounded-2xl p-4 flex items-start gap-4"
                            style="background:#EEF2FF; border:1px solid #C7D2FE">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-video text-indigo-500 text-[15px]"></i>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-indigo-800 mb-0.5">Cours vidéo HD</p>
                                <p class="text-[12px] text-indigo-700 leading-relaxed">
                                    Visionnez en streaming depuis n'importe quel appareil. Contrôle de vitesse et
                                    sous-titres disponibles.
                                </p>
                            </div>
                        </div>

                        <!-- AUDIO: info lecteur -->
                        <div v-else-if="selectedProduct.format === 'Audio'"
                            class="rounded-2xl p-4 flex items-start gap-4"
                            style="background:#FDF4FF; border:1px solid #E9D5FF">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                style="background:#FAE8FF">
                                <i class="fas fa-headphones text-[15px]" style="color:#9333EA"></i>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold mb-0.5" style="color:#581C87">Cours audio</p>
                                <p class="text-[12px] leading-relaxed" style="color:#7E22CE">
                                    Écoutez en déplacement. Compatible avec tous les lecteurs audio modernes, idéal pour
                                    apprendre en mobilité.
                                </p>
                            </div>
                        </div>

                        <!-- ── CTA BUTTON ── -->
                        <div class="mt-auto pt-2">
                            <button v-if="selectedProduct.price > 0"
                                class="w-full py-3 rounded-xl text-[14px] font-bold transition-all flex items-center justify-center gap-2 cursor-pointer border-none"
                                style="background:linear-gradient(135deg,#F4B400 0%,#E09000 100%); color:#0F1117; box-shadow:0 4px 14px rgba(244,180,0,0.35)">
                                <i class="fas fa-lock text-[11px]"></i>
                                Acheter · {{ selectedProduct.price }} €
                            </button>
                            <button v-else
                                class="w-full py-3 rounded-xl text-[14px] font-bold transition-all flex items-center justify-center gap-2 cursor-pointer border-none"
                                style="background:linear-gradient(135deg,#10B981 0%,#059669 100%); color:#fff; box-shadow:0 4px 14px rgba(16,185,129,0.30)">
                                <i class="fas fa-play text-[11px]"></i>
                                Commencer gratuitement
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </Transition>
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

const allProducts: Product[] = props.products.data

const filteredProducts = ref<Product[]>(allProducts)
const currentFilters = ref({
    search: '',
    formats: ['Audio', 'Video', 'PDF'],
    levels: ['Débutant', 'Intermédiaire', 'Avancé'],
    maxPrice: 200,
    sortBy: 'newest'
})

/* ── Detail drawer state ── */
const selectedProduct = ref<Product | null>(null)

/* ── Decorative audio waveform bars ── */
const audioWaveBars = [25, 60, 80, 45, 70, 95, 40, 65, 85, 50, 75, 35, 90, 55, 70, 42, 78, 60, 30, 88]

/* ── Helpers ── */
function openDetail(product: Product): void {
    selectedProduct.value = product
}

type Format = 'PDF' | 'Video' | 'Audio'

interface FormatConfig {
    icon: string
    badgeClass: string
    accessLabel: string
}

function formatConfig(format: Format): FormatConfig {
    const map: Record<Format, FormatConfig> = {
        PDF: { icon: 'fas fa-file-pdf', badgeClass: 'bg-red-50 text-red-600', accessLabel: 'au document PDF' },
        Video: { icon: 'fas fa-video', badgeClass: 'bg-indigo-50 text-indigo-600', accessLabel: 'aux vidéos du cours' },
        Audio: { icon: 'fas fa-headphones', badgeClass: 'bg-fuchsia-50 text-fuchsia-600', accessLabel: 'aux pistes audio' },
    }

    return map[format]
}

function levelBadgeClass(level: string): string {
    const map: Record<string, string> = {
        'Débutant': 'bg-emerald-50 text-emerald-600',
        'Intermédiaire': 'bg-blue-50 text-blue-600',
        'Avancé': 'bg-purple-50 text-purple-600',
    }

    return map[level] ?? 'bg-gray-100 text-gray-600'
}

/* ── Filter logic (inchangée) ── */
const handleFilter = (filters: any): void => {
    currentFilters.value = filters

    const results = allProducts.filter(product => {
        const matchesSearch = product.title.toLowerCase().includes(filters.search.toLowerCase())
        const matchesFormat = filters.formats.includes(product.format)
        const matchesLevel = filters.levels.includes(product.level)
        const matchesPrice = product.price <= filters.maxPrice

        return matchesSearch && matchesFormat && matchesLevel && matchesPrice
    })

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

<style scoped>
/* Drawer slide-in from right */
.drawer-enter-active,
.drawer-leave-active {
    transition: opacity 0.25s ease;
}

.drawer-enter-active .relative,
.drawer-leave-active .relative {
    transition: transform 0.3s cubic-bezier(0.32, 0.72, 0, 1);
}

.drawer-enter-from {
    opacity: 0
}

.drawer-enter-from .relative {
    transform: translateX(100%)
}

.drawer-leave-to {
    opacity: 0
}

.drawer-leave-to .relative {
    transform: translateX(100%)
}
</style>
