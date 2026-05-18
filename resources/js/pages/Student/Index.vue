<template>
    <div class="flex h-screen overflow-hidden font-sans bg-[#FAFAF8]">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">

                <!-- ── EN-TÊTE ── -->
                <div class="flex items-start justify-between mb-7">
                    <div>
                        <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-amber-500 mb-1">
                            Tableau de bord
                        </p>
                        <h1 class="text-[22px] font-bold text-gray-900 leading-tight">
                            Bonjour, {{ user.name.split(' ')[0] }}
                        </h1>
                        <p class="text-[13px] text-gray-400 mt-0.5">Voici votre progression du jour</p>
                    </div>
                    <button
                        class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold text-[13px] px-4 py-2.5 rounded-xl border-none cursor-pointer transition-all shadow-sm hover:shadow-md">
                        <i class="fas fa-plus text-[11px]"></i> Nouveau cours
                    </button>
                </div>

                <!-- ── KPI GRID ── -->
                <div class="grid grid-cols-12 gap-4 mb-6">
                    <!-- Cours inscrits -->
                    <div
                        class="col-span-12 md:col-span-6 bg-white rounded-2xl p-5 flex items-center gap-4 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                            <i class="fas fa-book-open text-amber-500 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1">Cours inscrits
                            </p>
                            <div class="flex items-end gap-3">
                                <h3 class="text-3xl font-bold text-gray-900 leading-none">{{ stats.totalEnrollments }}
                                </h3>
                                <span class="text-[11px] text-emerald-500 font-semibold mb-0.5 flex items-center gap-1">
                                    <i class="fas fa-arrow-up text-[9px]"></i>
                                    {{ stats.newThisMonth }} ce mois
                                </span>
                            </div>
                        </div>
                        <!-- Mini bar sparkline visuelle -->
                        <div class="flex items-end gap-0.5 shrink-0">
                            <div v-for="(h, i) in [3, 5, 4, 7, 6, 8, 9]" :key="i" class="w-1.5 rounded-sm bg-amber-200"
                                :style="`height:${h * 4}px; opacity:${0.4 + i * 0.09}`">
                            </div>
                        </div>
                    </div>

                    <!-- Cours terminés -->
                    <div
                        class="col-span-6 md:col-span-3 bg-white rounded-2xl p-5 flex items-start gap-3 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1">Terminés</p>
                            <h3 class="text-2xl font-bold text-gray-900 leading-none">{{ stats.completedCourses }}</h3>

                        </div>
                    </div>

                    <!-- Heures -->
                    <div
                        class="col-span-6 md:col-span-3 bg-white rounded-2xl p-5 flex items-start gap-3 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                            <i class="fas fa-clock text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1">Heures totales
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900 leading-none">{{ stats.totalHours }}h</h3>
                            <p class="text-[11px] text-gray-400 mt-1">de contenu suivi</p>
                        </div>
                    </div>
                </div>
                <!-- /KPI GRID -->

                <!-- ── CHARTS ROW ── -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Bar Chart (plus large) -->
                    <div class="lg:col-span-3 bg-white rounded-2xl p-5 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Activité hebdomadaire</h3>
                                <p class="text-[11px] text-gray-400 mt-0.5">heures d'apprentissage par jour</p>
                            </div>
                            <div class="flex items-center gap-4 text-[11px] text-gray-400">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                                    Cette semaine
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-gray-200 inline-block"></span>
                                    Semaine dernière
                                </span>
                            </div>
                        </div>
                        <div class="relative" style="height:200px">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut (plus compact) -->
                    <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-gray-100 flex flex-col">
                        <div class="mb-3">
                            <h3 class="text-sm font-semibold text-gray-900">Répartition</h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">par format de contenu</p>
                        </div>
                        <div class="relative flex-1" style="min-height:160px">
                            <canvas id="formatChart"></canvas>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-4">
                            <div v-for="fmt in formatStats" :key="fmt.label"
                                class="flex flex-col items-center gap-1 bg-gray-50 rounded-xl py-2 px-1">
                                <span class="w-2 h-2 rounded-full" :style="`background:${fmt.color}`"></span>
                                <span class="text-[10px] text-gray-400">{{ fmt.label }}</span>
                                <span class="text-[13px] font-bold text-gray-800">{{ fmt.pct }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /CHARTS ROW -->

                <!-- ── COURS EN COURS ── -->
                <div class="bg-white rounded-2xl border border-gray-100">
                    <!-- Header -->
                    <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-50">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Cours en cours</h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ inProgressCourses.length }} cours actifs</p>
                        </div>
                        <a href="#"
                            class="text-[12px] font-semibold text-amber-500 hover:text-amber-600 no-underline flex items-center gap-1 transition-colors">
                            Voir tout <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    <!-- Liste -->
                    <div class="divide-y divide-gray-50">
                        <div v-for="enrollment in inProgressCourses" :key="enrollment.id"
                            class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50/60 transition-colors group">

                            <!-- Thumbnail / Icône -->
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 text-base"
                                :style="`background:${enrollment.course.color}`">
                                <i :class="enrollment.course.icon || 'fas fa-book'" class="text-white"></i>
                            </div>

                            <!-- Infos -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-[13px] font-semibold text-gray-900 truncate">
                                        {{ enrollment.course.title }}
                                    </p>
                                    <span class="shrink-0 text-[10px] font-medium px-2 py-0.5 rounded-full"
                                        :class="levelBadge(enrollment.course.level).class">
                                        {{ enrollment.course.level }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[11px] text-gray-400">{{ enrollment.course.format }}</span>
                                    <span class="text-gray-200">·</span>
                                    <span class="text-[11px] text-gray-400">{{ enrollment.course.duration }}</span>
                                </div>
                                <!-- Barre de progression -->
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500"
                                        :style="`width:${enrollment.course.progress}%; background:${progressColor(enrollment.course.progress)}`">
                                    </div>
                                </div>
                            </div>

                            <!-- Droite : % + bouton -->
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ enrollment.course.progress
                                        }}%</span>
                                    <p class="text-[10px] text-gray-400 mt-0.5">complété</p>
                                </div>
                                <button
                                    class="w-8 h-8 rounded-full bg-amber-400 hover:bg-amber-500 border-none cursor-pointer flex items-center justify-center text-gray-900 text-[11px] transition-all hover:scale-110 shadow-sm">
                                    <i class="fas fa-play ml-0.5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div v-if="inProgressCourses.length === 0"
                        class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mb-3">
                            <i class="fas fa-book-open text-amber-400 text-xl"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">Aucun cours en cours</p>
                        <p class="text-[12px] text-gray-400 mt-1">Inscrivez-vous à un cours pour commencer</p>
                    </div>
                </div>
                <!-- /COURS EN COURS -->

            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import Chart from 'chart.js/auto'
import { computed, onMounted, onUnmounted } from 'vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

/* ─── Types ─────────────────────────────────── */
interface Course {
    id: number
    title: string
    description: string
    category: string
    teacher_id: number
    duration: string
    price: number
    image: string
    format: 'pdf' | 'audio' | 'video'
    progress: number
    icon: string
    color: string
    level: string
    file: string
    students: number
    status: string
}

interface Enrollment {
    enrollments: {
        data: {
            id: number
            student_id: number
            course_id: number
            video_id: number | null
            audio_id: number | null
            course: Course
            created_at: string
            updated_at: string
        }[]
    }
}

/* ─── Props Inertia ──────────────────────────── */
const props = defineProps<Enrollment>()
const page = usePage()
const user = page.props.auth.user as { name: string; email: string }
const enrollments = (props.enrollments.data ?? []);

/* ─── Cours en cours (progress < 100) ───────── */
const inProgressCourses = computed(() =>
    enrollments
        .filter(e => e.course && e.course.progress < 100)
        .sort((a, b) => b.course.progress - a.course.progress)
)

/* ─── Stats calculées depuis les enrollements ── */
const stats = computed(() => {
    const total = enrollments.length
    const completed = enrollments.filter(e => e.course?.progress === 100).length

    // Heures totales : on parse la durée (ex: "4h30", "2h", "90min")
    const totalMinutes = enrollments.reduce((acc, e) => {
        const dur = e.course?.duration ?? ''
        const h = parseInt(dur.match(/(\d+)h/)?.[1] ?? '0') * 60
        const m = parseInt(dur.match(/(\d+)min/)?.[1] ?? '0')

        return acc + h + m
    }, 0)
    const totalHours = Math.round(totalMinutes / 60) || 84

    // Nouveaux ce mois (basé sur created_at)
    const now = new Date()
    const newThisMonth = enrollments.filter(e => {
        const d = new Date(e.created_at)

        return d.getMonth() === now.getMonth() && d.getFullYear() === now.getFullYear()
    }).length

    return { totalEnrollments: total, completedCourses: completed, totalHours, newThisMonth }
})

/* ─── Répartition par format ─────────────────── */
const formatStats = computed(() => {
    const counts: Record<string, number> = {}
    enrollments.forEach(e => {
        const fmt = e.course?.format ?? 'Autre'
        counts[fmt] = (counts[fmt] ?? 0) + 1
    })
    const total = enrollments.length || 1
    const palette: Record<string, string> = {
        'video': '#F4B400',
        'audio': '#111827',
        'pdf': '#E5E7EB',
        'Autre': '#A78BFA',
    }

    return Object.entries(counts).map(([label, count]) => ({
        label,
        pct: Math.round((count / total) * 100),
        color: palette[label] ?? '#6B7280',
    }))
})

/* ─── Helpers ────────────────────────────────── */
function progressColor(p: number): string {

    if (p >= 80) {
        return '#10B981'
    }

    if (p >= 40) {
        return '#F4B400'

    }

    {
        return '#F97316'

    }
}

function levelBadge(level: string): { class: string } {
    const map: Record<string, string> = {
        'Débutant': 'bg-emerald-50 text-emerald-600',
        'Intermédiaire': 'bg-blue-50 text-blue-600',
        'Avancé': 'bg-purple-50 text-purple-600',
    }

    return { class: map[level] ?? 'bg-gray-100 text-gray-500' }
}

/* ─── Charts ─────────────────────────────────── */
let actChart: Chart | null = null
let fmtChart: Chart | null = null

onMounted(() => {
    // ── Activity Bar Chart ─────────────────────
    const actCtx = (document.getElementById('activityChart') as HTMLCanvasElement)?.getContext('2d')

    if (actCtx) {
        actChart = new Chart(actCtx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [
                    {
                        label: 'Cette semaine',
                        data: [1.5, 2.2, 0.8, 3.1, 2.5, 1.0, 0.5],
                        backgroundColor: '#F4B400',
                        borderRadius: 6,
                        barThickness: 16,
                    },
                    {
                        label: 'Semaine dernière',
                        data: [1.0, 1.8, 1.2, 2.0, 1.5, 0.8, 1.1],
                        backgroundColor: '#F3F4F6',
                        borderRadius: 6,
                        barThickness: 16,
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
                        grid: { color: '#F9FAFB' },
                        border: { display: false },
                        ticks: { color: '#9CA3AF', font: { size: 11 }, callback: (v: any) => v + 'h' },
                    },
                },
            },
        })
    }

    // ── Doughnut Format Chart ──────────────────
    const fmtCtx = (document.getElementById('formatChart') as HTMLCanvasElement)?.getContext('2d')

    if (fmtCtx) {
        const data = formatStats.value
        fmtChart = new Chart(fmtCtx, {
            type: 'doughnut',
            data: {
                labels: data.map(f => f.label),
                datasets: [{
                    data: data.map(f => f.pct),
                    backgroundColor: data.map(f => f.color),
                    borderWidth: 0,
                    hoverOffset: 8,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '74%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (c: any) => ` ${c.label}: ${c.raw}%` } },
                },
            },
        })
    }
})

onUnmounted(() => {
    actChart?.destroy()
    fmtChart?.destroy()
})
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
    border-radius: 9999px
}
</style>
