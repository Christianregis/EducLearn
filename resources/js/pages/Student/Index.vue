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
                        <h1 class="text-[22px] font-bold text-dark">Tableau de bord</h1>
                        <p class="text-[13px] text-dark-500 mt-0.5">Bienvenue Aminata — voici votre progression du jour
                        </p>
                    </div>
                    <button
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-dark font-bold text-[13px] px-4.5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors">
                        <i class="fas fa-plus"></i> Nouveau cours
                    </button>
                </div>

                <!-- ── KPI GRID (avec largeurs différentes) ── -->
                <div class="grid grid-cols-12 gap-4 mb-6">
                    <!-- Cours inscrits (larger card - 6 colonnes) -->
                    <div
                        class="col-span-12 md:col-span-6 bg-white rounded-2xl p-[18px_16px] flex items-start gap-3.5 transition-shadow hover:shadow-lg">
                        <div
                            class="w-[42px] h-[42px] rounded-[11px] flex items-center justify-center text-base flex-shrink-0 bg-brand-light text-amber-600">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <p class="text-xs text-dark-500 font-medium mb-1">Cours inscrits</p>
                            <h3 class="text-[26px] font-bold text-dark leading-none">12</h3>
                            <p class="text-[11px] text-emerald-600 mt-[5px] flex items-center gap-1">
                                <i class="fas fa-arrow-up text-[9px]"></i> +2 ce mois
                            </p>
                        </div>
                    </div>

                    <!-- Cours terminés (3 colonnes) -->
                    <div
                        class="col-span-6 md:col-span-3 bg-white rounded-2xl p-[18px_16px] flex items-start gap-3.5 transition-shadow hover:shadow-lg">
                        <div
                            class="w-[42px] h-[42px] rounded-[11px] flex items-center justify-center text-base flex-shrink-0 bg-emerald-50 text-emerald-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-xs text-dark-500 font-medium mb-1">Cours terminés</p>
                            <h3 class="text-[26px] font-bold text-dark leading-none">7</h3>
                            <p class="text-[11px] text-emerald-600 mt-[5px] flex items-center gap-1">
                                <i class="fas fa-arrow-up text-[9px]"></i> +1 cette semaine
                            </p>
                        </div>
                    </div>

                    <!-- Heures d'apprentissage (4 colonnes) -->
                    <div
                        class="col-span-6 md:col-span-3 bg-white rounded-2xl p-[18px_16px] flex items-start gap-3.5 transition-shadow hover:shadow-lg">
                        <div
                            class="w-[42px] h-[42px] rounded-[11px] flex items-center justify-center text-base flex-shrink-0 bg-blue-50 text-blue-600">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-xs text-dark-500 font-medium mb-1">Heures d'apprentissage totale</p>
                            <h3 class="text-[26px] font-bold text-dark leading-none">84h</h3>
                        </div>
                    </div>
                </div>
                <!-- /KPI GRID -->

                <!-- ── CHARTS ROW ── -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-dark">
                                Activité hebdomadaire
                                <span class="text-dark-400 font-normal text-xs ml-1.5">heures d'apprentissage</span>
                            </h3>
                            <div class="flex items-center gap-3 text-[11px] text-dark-500">
                                <span class="w-2 h-2 rounded-full inline-block bg-brand"></span><span>Cette
                                    semaine</span>
                                <span class="w-2 h-2 rounded-full inline-block bg-dark-200"></span><span>Semaine
                                    dernière</span>
                            </div>
                        </div>
                        <div class="relative" style="height: 220px;">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut Chart -->
                    <div class="bg-white rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-dark">
                                Répartition
                                <span class="text-dark-400 font-normal text-xs ml-1.5">par format</span>
                            </h3>
                        </div>
                        <div class="relative" style="height: 220px;">
                            <canvas id="formatChart"></canvas>
                        </div>
                        <div class="flex flex-col gap-1.5 mt-3">
                            <div class="flex items-center gap-2 text-xs text-dark-500">
                                <span class="w-2 h-2 rounded-full inline-block flex-shrink-0"
                                    style="background:#F4B400"></span>
                                Vidéo 58%
                            </div>
                            <div class="flex items-center gap-2 text-xs text-dark-500">
                                <span class="w-2 h-2 rounded-full inline-block flex-shrink-0"
                                    style="background:#111827"></span>
                                Audio 24%
                            </div>
                            <div class="flex items-center gap-2 text-xs text-dark-500">
                                <span class="w-2 h-2 rounded-full inline-block flex-shrink-0"
                                    style="background:#E5E7EB"></span>
                                PDF 18%
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /CHARTS ROW -->

                <!-- ── BOTTOM ROW ── -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Cours en cours -->
                    <div class="bg-white rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-dark">Cours en cours</h3>
                            <a href="#" class="text-xs text-brand font-medium no-underline flex items-center gap-1">
                                Voir tout <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="flex flex-col gap-3.5">
                            <div v-for="c in inProgressCourses" :key="c.id" class="flex items-center gap-3">
                                <!-- Thumb -->
                                <div class="w-[42px] h-[42px] rounded-[10px] flex items-center justify-center text-amber-900 text-base flex-shrink-0"
                                    :style="`background:${c.color}`">
                                    <i :class="c.icon"></i>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-semibold text-dark truncate">{{ c.title }}</p>
                                    <p class="text-[11px] text-dark-400 mt-0.5 mb-1.5">{{ c.instructor }} · {{ c.format
                                        }}</p>
                                    <div class="h-1 bg-dark-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-[width] duration-400"
                                            :style="`width:${c.progress}%; background:${c.progress >= 80 ? '#10B981' : '#F4B400'}`">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right -->
                                <div class="flex flex-col items-center gap-1.5 flex-shrink-0">
                                    <span class="text-xs font-bold text-dark">{{ c.progress }}%</span>
                                    <button
                                        class="w-7 h-7 rounded-full bg-brand hover:bg-brand-dark border-none cursor-pointer flex items-center justify-center text-dark text-[10px] transition-colors">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Cours en cours -->
                </div>
                <!-- /BOTTOM ROW -->

            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import Chart from 'chart.js/auto'
import { onMounted, ref } from 'vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

/* ─── Types ─────────────────────────────────── */
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

/* ─── Data ───────────────────────────────────── */
const inProgressCourses: Course[] = [
    { id: 1, title: 'JavaScript Avancé — Patterns & Architecture', instructor: 'Jean Dupont', format: 'Vidéo', progress: 72, icon: 'fas fa-code', color: '#fef3c7', level: 'Avancé' },
    { id: 2, title: 'UX/UI Design Fundamentals', instructor: 'Sarah Mbaye', format: 'Vidéo', progress: 45, icon: 'fas fa-paint-brush', color: '#ede9fe', level: 'Intermédiaire' },
    { id: 3, title: 'Python pour la Data Science', instructor: 'Carlos Torres', format: 'Audio', progress: 88, icon: 'fas fa-brain', color: '#ecfdf5', level: 'Intermédiaire' },
    { id: 4, title: 'Marketing Digital & SEO', instructor: 'Fatou Sow', format: 'PDF', progress: 23, icon: 'fas fa-bullhorn', color: '#fff7ed', level: 'Débutant' },
]

/* ─── Chart instances pour les détruire proprement ── */
const activityChartRef = ref<any>(null)
const formatChartRef = ref<any>(null)

/* ─── Charts ─────────────────────────────────── */
onMounted(() => {
    /* Activity Bar Chart */
    const actCanvas = document.getElementById('activityChart') as HTMLCanvasElement
    const actCtx = actCanvas?.getContext('2d')

    if (actCtx) {
        activityChartRef.value = new Chart(actCtx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [
                    {
                        label: 'Cette semaine',
                        data: [1.5, 2.2, 0.8, 3.1, 2.5, 1.0, 0.5],
                        backgroundColor: '#F4B400',
                        borderRadius: 6,
                        barThickness: 18,
                    },
                    {
                        label: 'Semaine dernière',
                        data: [1.0, 1.8, 1.2, 2.0, 1.5, 0.8, 1.1],
                        backgroundColor: '#E5E7EB',
                        borderRadius: 6,
                        barThickness: 18,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { color: '#9CA3AF', font: { size: 11 } },
                    },
                    y: {
                        grid: { color: '#F3F4F6' },
                        border: { display: false },
                        ticks: { color: '#9CA3AF', font: { size: 11 }, callback: (v: any) => v + 'h' },
                    },
                },
            },
        })
    }

    /* Doughnut Chart */
    const fmtCanvas = document.getElementById('formatChart') as HTMLCanvasElement
    const fmtCtx = fmtCanvas?.getContext('2d')

    if (fmtCtx) {
        formatChartRef.value = new Chart(fmtCtx, {
            type: 'doughnut',
            data: {
                labels: ['Vidéo', 'Audio', 'PDF'],
                datasets: [{
                    data: [58, 24, 18],
                    backgroundColor: ['#F4B400', '#111827', '#E5E7EB'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (c: any) => ` ${c.label}: ${c.raw}%` } },
                },
            },
        })
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
