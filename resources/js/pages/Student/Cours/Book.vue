<template>
    <!-- ── ROOT LAYOUT ── -->
    <div class="flex h-screen overflow-hidden font-sans bg-dark-50">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">
                <!-- ── SECTION HEADING ── -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h1 class="text-[22px] font-bold text-dark">Mes cours</h1>
                        <p class="text-[13px] text-dark-500 mt-0.5">12 cours inscrits · 7 terminés · 5 en cours</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher un cours..."
                                class="w-64 pl-10 pr-4 py-2.5 bg-white border border-dark-200 rounded-[9px] text-sm text-dark placeholder-dark-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" />
                            <i
                                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-dark-400 text-sm"></i>
                        </div>
                        <button
                            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-dark font-bold text-[13px] px-4.5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors">
                            <i class="fas fa-plus"></i> Nouveau cours
                        </button>
                    </div>
                </div>

                <!-- ── FILTER TABS ── -->
                <div class="flex items-center gap-2 mb-6 pb-1 border-b border-dark-100">
                    <button v-for="filter in filters" :key="filter.id" @click="activeFilter = filter.id"
                        class="px-4 py-2 text-sm font-medium rounded-[9px] transition-colors" :class="activeFilter === filter.id
                            ? 'bg-amber-500 text-dark'
                            : 'text-dark-500 hover:bg-dark-100'">
                        {{ filter.label }}
                        <span class="ml-1.5 px-1.5 py-0.5 text-[10px] font-semibold rounded-full"
                            :class="activeFilter === filter.id ? 'bg-dark text-white' : 'bg-dark-100 text-dark-500'">
                            {{ filter.count }}
                        </span>
                    </button>
                </div>

                <!-- ── COURSES GRID ── -->
                <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-5">
                    <div v-for="c in filteredCourses" :key="c.id"
                        class="bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer group">
                        <!-- Thumb -->
                        <div class="h-24 flex items-center justify-center text-[36px] text-amber-900 relative overflow-hidden"
                            :style="`background:${c.color}`">
                            <div
                                class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <i :class="c.icon" class="relative z-10"></i>
                        </div>

                        <!-- Body -->
                        <div class="px-5 py-4">
                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="text-[10px] font-semibold bg-dark-100 text-dark-500 px-2.5 py-1 rounded-full uppercase tracking-wide">
                                    {{ c.format }}
                                </span>
                                <span class="text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wide"
                                    :class="{
                                        'bg-emerald-50 text-emerald-600': c.level.toLowerCase() === 'débutant',
                                        'bg-blue-50 text-blue-600': c.level.toLowerCase() === 'intermédiaire',
                                        'bg-orange-50 text-orange-600': c.level.toLowerCase() === 'avancé',
                                    }">
                                    {{ c.level }}
                                </span>
                            </div>

                            <!-- Title & instructor -->
                            <h4
                                class="text-sm font-bold text-dark leading-[1.4] mb-1.5 group-hover:text-amber-600 transition-colors">
                                {{ c.title }}
                            </h4>
                            <p class="text-xs text-dark-400 mb-3">{{ c.instructor }}</p>

                            <!-- Progress bar -->
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[10px] font-medium text-dark-500">Progression</span>
                                    <span class="text-xs font-bold text-dark">{{ c.progress }}%</span>
                                </div>
                                <div class="h-1.5 bg-dark-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-[width] duration-500 ease-out"
                                        :style="`width:${c.progress}%; background:${c.progress === 100 ? '#10B981' : '#F4B400'}`">
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-3 border-t border-dark-100">
                                <span v-if="c.progress === 100"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600">
                                    <i class="fas fa-check-circle"></i> Terminé
                                </span>
                                <button v-else
                                    class="inline-flex items-center gap-2 bg-brand hover:bg-brand-dark text-dark font-bold text-xs px-4 py-2 rounded-[9px] border-none cursor-pointer transition-all">
                                    <i class="fas fa-play text-[10px]"></i> Continuer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /COURSES GRID -->

                <!-- Empty state -->
                <div v-if="filteredCourses.length === 0"
                    class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-3xl text-dark-400"></i>
                    </div>
                    <h3 class="text-base font-semibold text-dark mb-2">Aucun cours trouvé</h3>
                    <p class="text-sm text-dark-500 mb-6">Commencez par ajouter un nouveau cours à votre liste</p>
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

interface Course {
    id: number
    title: string
    instructor: string
    format: string
    progress: number
    icon: string
    color: string
    level: string
}

const inProgressCourses: Course[] = [
    { id: 1, title: 'JavaScript Avancé — Patterns & Architecture', instructor: 'Jean Dupont', format: 'Vidéo', progress: 72, icon: 'fas fa-code', color: '#fef3c7', level: 'Avancé' },
    { id: 2, title: 'UX/UI Design Fundamentals', instructor: 'Sarah Mbaye', format: 'Vidéo', progress: 45, icon: 'fas fa-paint-brush', color: '#ede9fe', level: 'Intermédiaire' },
    { id: 3, title: 'Python pour la Data Science', instructor: 'Carlos Torres', format: 'Audio', progress: 88, icon: 'fas fa-brain', color: '#ecfdf5', level: 'Intermédiaire' },
    { id: 4, title: 'Marketing Digital & SEO', instructor: 'Fatou Sow', format: 'PDF', progress: 23, icon: 'fas fa-bullhorn', color: '#fff7ed', level: 'Débutant' },
]

const allCourses: Course[] = [
    ...inProgressCourses,
    { id: 5, title: 'Web Design Mastery', instructor: 'Marc Leblanc', format: 'Vidéo', progress: 100, icon: 'fas fa-desktop', color: '#fef3c7', level: 'Débutant' },
    { id: 6, title: 'Financial Analyst Training', instructor: 'Aïcha Diop', format: 'Audio', progress: 100, icon: 'fas fa-chart-line', color: '#ecfdf5', level: 'Avancé' },
]

const user = usePage().props.auth.user

const activeFilter = ref('all')

const filters = [
    { id: 'all', label: 'Tous', count: allCourses.length },
    { id: 'in-progress', label: 'En cours', count: allCourses.filter(c => c.progress < 100).length },
    { id: 'completed', label: 'Terminés', count: allCourses.filter(c => c.progress === 100).length },
]

const filteredCourses = computed(() => {
    switch (activeFilter.value) {
        case 'in-progress':
            return allCourses.filter(c => c.progress < 100)
        case 'completed':
            return allCourses.filter(c => c.progress === 100)
        default:
            return allCourses
    }
})
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB
}
</style>
