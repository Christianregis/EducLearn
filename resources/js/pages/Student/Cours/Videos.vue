<template>
    <!-- ── ROOT LAYOUT ── -->
    <div class="flex h-screen overflow-hidden font-sans bg-dark-50">
        <!-- Sidebar -->
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <!-- Navbar -->
            <Navbar :user="user" />

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">
                <!-- ── SECTION HEADING ── -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                <i class="fas fa-video text-xl text-amber-500"></i>
                            </div>
                            <h1 class="text-[22px] font-bold text-dark">Mes cours vidéo</h1>
                        </div>
                        <p class="text-[13px] text-dark-500 mt-0.5">
                            {{ videos.length }} cours · {{ completedCount }} terminés · {{ inProgressCount }} en cours
                        </p>
                    </div>
                    <button
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-dark font-bold text-[13px] px-4.5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors self-start">
                        <i class="fas fa-plus"></i> Nouveau cours
                    </button>
                </div>

                <!-- ── FILTERS & SORT BAR ── -->
                <div class="bg-white rounded-2xl p-4 mb-6 border border-amber-200">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- Search -->
                        <div class="relative flex-1">
                            <input v-model="searchQuery" type="text" placeholder="Rechercher un cours vidéo..."
                                class="w-full pl-10 pr-4 py-2.5 bg-dark-50 border border-dark-200 rounded-[9px] text-sm text-dark placeholder-dark-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" />
                            <i
                                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-dark-400 text-sm"></i>
                        </div>

                        <!-- Filter by Status -->
                        <div class="flex items-center gap-2">
                            <button v-for="filter in statusFilters" :key="filter.id"
                                @click="activeStatusFilter = filter.id"
                                class="px-4 py-2.5 text-sm font-medium rounded-[9px] transition-all border" :class="activeStatusFilter === filter.id
                                    ? 'bg-amber-500 text-dark border-amber-500'
                                    : 'bg-white text-dark-500 border-dark-200 hover:border-amber-300 hover:bg-amber-50'">
                                {{ filter.label }}
                                <span class="ml-1.5 px-1.5 py-0.5 text-[10px] font-semibold rounded-full"
                                    :class="activeStatusFilter === filter.id ? 'bg-dark text-white' : 'bg-dark-100 text-dark-500'">
                                    {{ filter.count }}
                                </span>
                            </button>
                        </div>

                        <!-- Sort -->
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-dark-500 font-medium whitespace-nowrap">Trier par :</label>
                            <select v-model="sortBy"
                                class="px-4 py-2.5 bg-white border border-dark-200 rounded-[9px] text-sm text-dark focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 cursor-pointer">
                                <option value="date-desc">Plus récents</option>
                                <option value="date-asc">Plus anciens</option>
                                <option value="progress-desc">Progression (décroissant)</option>
                                <option value="progress-asc">Progression (croissant)</option>
                                <option value="title-asc">Titre (A-Z)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ── VIDEOS GRID ── -->
                <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-5">
                    <div v-for="video in filteredVideos" :key="video.id"
                        class="bg-white rounded-2xl overflow-hidden border border-amber-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-amber-300 group">

                        <!-- Video Thumbnail -->
                        <div
                            class="relative h-40 bg-linear-to-br from-amber-100 via-yellow-50 to-orange-100 overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 opacity-10">
                                <div class="absolute inset-0"
                                    :style="`background-image: radial-gradient(circle, #F59E0B 1px, transparent 1px); background-size: 20px 20px;`">
                                </div>
                            </div>

                            <!-- Video Icon Center -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-play-circle text-[40px] text-amber-500"></i>
                                </div>
                            </div>

                            <!-- Duration Badge -->
                            <div class="absolute bottom-2 right-2 px-2 py-1 bg-dark/80 backdrop-blur-sm rounded-lg">
                                <span class="text-[10px] font-semibold text-amber-400">{{ video.duration }}</span>
                            </div>

                            <!-- Progress Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-dark-200">
                                <div class="h-full bg-emerald-500 transition-all duration-500"
                                    :style="`width:${video.progress}%`"></div>
                            </div>

                            <!-- Level Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wide"
                                    :class="{
                                        'bg-emerald-500 text-white': video.level.toLowerCase() === 'débutant',
                                        'bg-blue-500 text-white': video.level.toLowerCase() === 'intermédiaire',
                                        'bg-orange-500 text-white': video.level.toLowerCase() === 'avancé',
                                    }">
                                    {{ video.level }}
                                </span>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="px-5 py-4">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-amber-50 text-amber-600">
                                    <i class="fas fa-video text-[9px]"></i>
                                    Vidéo
                                </span>
                                <span class="text-[10px] font-medium text-dark-400">
                                    #{{ video.id.toString().padStart(4, '0') }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h4
                                class="text-[15px] font-bold text-dark leading-[1.4] mb-2 group-hover:text-amber-600 transition-colors line-clamp-2">
                                {{ video.title }}
                            </h4>

                            <!-- Instructor -->
                            <p class="text-[12px] text-dark-400 mb-4 flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-[10px] text-amber-500"></i>
                                {{ video.instructor }}
                            </p>

                            <!-- Progress Info -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span
                                        class="text-[10px] font-medium text-dark-500 uppercase tracking-wide">Progression</span>
                                    <span class="text-sm font-bold text-dark">{{ video.progress }}%</span>
                                </div>
                                <div class="h-2 bg-dark-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-[width] duration-500 ease-out"
                                        :style="`width:${video.progress}%; background:${video.progress === 100 ? '#10B981' : '#F59E0B'}`">
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <button v-if="video.progress === 100"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[11px] px-4 py-2.5 rounded-xl transition-all duration-200">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                    Terminé
                                </button>
                                <button v-else
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-dark font-bold text-[11px] px-4 py-2.5 rounded-xl transition-all duration-200">
                                    <i class="fas fa-play text-[10px]"></i>
                                    {{ video.progress > 0 ? 'Continuer' : 'Commencer' }}
                                </button>
                                <button
                                    class="w-10 h-10 rounded-xl border border-amber-200 text-dark-400 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 flex items-center justify-center transition-all duration-200">
                                    <i class="fas fa-bookmark text-[12px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /VIDEOS GRID -->

                <!-- Empty state -->
                <div v-if="filteredVideos.length === 0"
                    class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-video text-3xl text-amber-500"></i>
                    </div>
                    <h3 class="text-base font-semibold text-dark mb-2">Aucun cours vidéo trouvé</h3>
                    <p class="text-sm text-dark-500 mb-6">Essaie de modifier tes filtres ou ajoute un nouveau cours</p>
                    <button
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-dark font-bold text-sm px-5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors">
                        <i class="fas fa-plus"></i> Ajouter un cours
                    </button>
                </div>

            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

interface Video {
    id: number
    title: string
    instructor: string
    progress: number
    duration: string
    level: string
}

const videos: Video[] = [
    { id: 1, title: 'JavaScript Avancé — Patterns & Architecture', instructor: 'Jean Dupont', progress: 72, duration: '4h 32min', level: 'Avancé' },
    { id: 2, title: 'UX/UI Design Fundamentals', instructor: 'Sarah Mbaye', progress: 45, duration: '3h 18min', level: 'Intermédiaire' },
    { id: 3, title: 'React & Redux Complete Guide', instructor: 'Carlos Torres', progress: 88, duration: '5h 45min', level: 'Intermédiaire' },
    { id: 4, title: 'Marketing Digital & SEO', instructor: 'Fatou Sow', progress: 23, duration: '2h 56min', level: 'Débutant' },
    { id: 5, title: 'Web Design Mastery', instructor: 'Marc Leblanc', progress: 100, duration: '4h 12min', level: 'Débutant' },
    { id: 6, title: 'Python pour la Data Science', instructor: 'Aïcha Diop', progress: 100, duration: '6h 20min', level: 'Avancé' },
]

const user = usePage().props.auth.user

// Search & filters
const searchQuery = ref('')
const activeStatusFilter = ref('all')
const sortBy = ref('date-desc')

const statusFilters = [
    { id: 'all', label: 'Tous', count: videos.length },
    { id: 'in-progress', label: 'En cours', count: videos.filter(v => v.progress > 0 && v.progress < 100).length },
    { id: 'completed', label: 'Terminés', count: videos.filter(v => v.progress === 100).length },
    { id: 'not-started', label: 'Non commencés', count: videos.filter(v => v.progress === 0).length },
]

// Computed counts
const completedCount = computed(() => videos.filter(v => v.progress === 100).length)
const inProgressCount = computed(() => videos.filter(v => v.progress > 0 && v.progress < 100).length)

// Filtered & sorted videos
const filteredVideos = computed(() => {
    let result = [...videos]

    // Apply search
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        result = result.filter(v =>
            v.title.toLowerCase().includes(query) ||
            v.instructor.toLowerCase().includes(query)
        )
    }

    // Apply status filter
    switch (activeStatusFilter.value) {
        case 'in-progress':
            result = result.filter(v => v.progress > 0 && v.progress < 100)
            break
        case 'completed':
            result = result.filter(v => v.progress === 100)
            break
        case 'not-started':
            result = result.filter(v => v.progress === 0)
            break
    }

    // Apply sort
    switch (sortBy.value) {
        case 'progress-desc':
            result.sort((a, b) => b.progress - a.progress)
            break
        case 'progress-asc':
            result.sort((a, b) => a.progress - b.progress)
            break
        case 'title-asc':
            result.sort((a, b) => a.title.localeCompare(b.title))
            break
        case 'date-desc':
        case 'date-asc':
        default:
            // Keep original order or reverse
            if (sortBy.value === 'date-asc') {
                result.reverse()
            }

            break
    }

    return result
})
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
