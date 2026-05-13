<template>
    <!-- ── ROOT LAYOUT ── -->
    <div class="flex h-screen overflow-hidden font-sans bg-dark-50">

        <Sidebar />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            <Navbar />

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">

                <!-- ── SECTION HEADING ── -->
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-[22px] font-bold text-dark">Mes cours</h1>
                        <p class="text-[13px] text-dark-500 mt-0.5">12 cours inscrits · 7 terminés · 5 en cours</p>
                    </div>
                </div>

                <!-- ── COURSES GRID ── -->
                <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4">

                    <div v-for="c in allCourses" :key="c.id" class="bg-white border border-dark-200 rounded-2xl overflow-hidden
                   transition-shadow duration-200 hover:shadow-course">
                        <!-- Thumb -->
                        <div class="h-22.5 flex items-center justify-center text-[32px] text-amber-900"
                            :style="`background:${c.color}`">
                            <i :class="c.icon"></i>
                        </div>

                        <!-- Body -->
                        <div class="px-4 py-3.5">

                            <!-- Badges -->
                            <div class="flex items-center gap-1.5 mb-2">
                                <span
                                    class="text-[10px] font-semibold bg-dark-100 text-dark-500 px-2 py-0.5 rounded-full">
                                    {{ c.format }}
                                </span>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full" :class="{
                                    'bg-emerald-50  text-emerald-600': c.level.toLowerCase() === 'débutant',
                                    'bg-blue-50     text-blue-600': c.level.toLowerCase() === 'intermédiaire',
                                    'bg-orange-50   text-orange-600': c.level.toLowerCase() === 'avancé',
                                }">
                                    {{ c.level }}
                                </span>
                            </div>

                            <!-- Title & instructor -->
                            <h4 class="text-sm font-bold text-dark leading-[1.3] mb-1">{{ c.title }}</h4>
                            <p class="text-xs text-dark-400">{{ c.instructor }}</p>

                            <!-- Progress bar -->
                            <div class="h-1 bg-dark-100 rounded-full overflow-hidden mt-2">
                                <div class="h-full rounded-full transition-[width] duration-400"
                                    :style="`width:${c.progress}%; background:${c.progress === 100 ? '#10B981' : '#F4B400'}`">
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between mt-2.5">
                                <span class="text-xs font-bold text-dark">{{ c.progress }}%</span>

                                <span v-if="c.progress === 100" class="inline-flex items-center gap-1 text-[11px] font-semibold
                         text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                                    <i class="fas fa-check"></i> Terminé
                                </span>

                                <button v-else class="inline-flex items-center gap-1.5 bg-brand hover:bg-brand-dark text-dark
                         font-bold text-xs px-3 py-1.5 rounded-[9px] border-none cursor-pointer
                         transition-colors">
                                    <i class="fas fa-play"></i> Continuer
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /COURSES GRID -->

            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
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
</script>

<!-- Minimal scoped styles — only for scrollbar (no Tailwind plugin needed) -->
<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB
}
</style>
