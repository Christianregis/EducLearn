<template>
    <div class="flex h-screen overflow-hidden bg-[#F8F7F4] font-sans">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" @new-course="showNewCourseModal = true" />

            <!-- ── PAGE CONTENT ── -->
            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-12 scrollbar-thin scrollbar-thumb-gray-200">

                <!-- ── HEADER ── -->
                <div class="flex items-start justify-between mb-7">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-amber-500">Espace
                                Enseignant</span>
                        </div>
                        <h1 class="text-[24px] font-extrabold text-gray-900 leading-tight tracking-tight">
                            Bonjour, {{ firstName }}
                        </h1>
                        <p class="text-[13px] text-gray-400 mt-1">
                            {{ today }} — voici l'état de vos cours en temps réel.
                        </p>
                    </div>

                    <button
                        class="hidden sm:inline-flex items-center gap-2 text-[13px] font-bold px-5 py-2.5 rounded-[11px] transition-all duration-200 cursor-pointer border-none"
                        style="background: linear-gradient(135deg, #F4B400 0%, #E09000 100%); color: #0F1117; box-shadow: 0 4px 14px rgba(244,180,0,0.35)">
                        <i class="fas fa-plus text-[10px]"></i>
                        Nouveau cours
                    </button>
                </div>

                <!-- ── KPI STRIP ── -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
                    <div v-for="kpi in kpis" :key="kpi.label"
                        class="bg-white rounded-2xl p-4 flex flex-col gap-3 border border-gray-100/80 hover:shadow-md transition-shadow cursor-default group">
                        <div class="flex items-center justify-between">
                            <span class="w-9 h-9 rounded-xl flex items-center justify-center text-[13px]"
                                :style="`background:${kpi.iconBg}; color:${kpi.iconColor}`">
                                <i :class="kpi.icon"></i>
                            </span>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-gray-400 mb-0.5">{{ kpi.label }}</p>
                            <p class="text-[28px] font-extrabold text-gray-900 leading-none">{{ kpi.value }}</p>
                        </div>
                    </div>
                </div>
                <!-- /KPI STRIP -->

                <!-- ── MAIN GRID ── -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

                    <!-- ── RECENT COURSES (span 2) ── -->
                    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100/80 overflow-hidden">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                            <h2 class="text-[14px] font-bold text-gray-900">Mes cours publiés</h2>
                            <a href="#"
                                class="text-[11px] font-semibold text-amber-500 hover:text-amber-600 transition-colors flex items-center gap-1">
                                Voir tout <i class="fas fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>

                        <!-- Table header -->
                        <div
                            class="grid grid-cols-12 gap-2 px-5 py-2.5 bg-gray-50/60 text-[10px] font-bold uppercase tracking-widest text-gray-400 border-b border-gray-50">
                            <span class="col-span-6">Titre du cours</span>
                            <span class="col-span-2 text-center">Format</span>
                            <span class="col-span-2 text-center">Inscrits</span>
                            <span class="col-span-2 text-center">Statut</span>
                        </div>

                        <!-- Rows -->
                        <div class="divide-y divide-gray-50">
                            <div v-for="course in courses" :key="course.id"
                                class="grid grid-cols-12 gap-2 px-5 py-3.5 items-center hover:bg-gray-50/50 transition-colors cursor-pointer group">
                                <!-- Title + Icon -->
                                <div class="col-span-6 flex items-center gap-3 min-w-0">
                                    <span
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-[12px] shrink-0"
                                        :style="`background:${course.iconBg}; color:${course.iconColor}`">
                                        <i :class="course.icon"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <p
                                            class="text-[12.5px] font-semibold text-gray-800 truncate group-hover:text-amber-600 transition-colors">
                                            {{ course.title }}
                                        </p>
                                        <p class="text-[10.5px] text-gray-400 mt-0.5">{{ course.category }}</p>
                                    </div>
                                </div>

                                <!-- Format badge -->
                                <div class="col-span-2 flex justify-center">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full"
                                        :style="`background:${course.formatBg}; color:${course.formatColor}`">
                                        {{ course.format }}
                                    </span>
                                </div>

                                <!-- Students -->
                                <div class="col-span-2 text-center">
                                    <span class="text-[13px] font-bold text-gray-800">{{ course.students }}</span>
                                    <p class="text-[9px] text-gray-400">étudiants</p>
                                </div>

                                <!-- Status -->
                                <div class="col-span-2 flex justify-center">
                                    <span
                                        class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full"
                                        :class="course.status === 'Publié'
                                            ? 'bg-emerald-50 text-emerald-600'
                                            : 'bg-amber-50 text-amber-500'">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                            :class="course.status === 'Publié' ? 'bg-emerald-500' : 'bg-amber-400'"></span>
                                        {{ course.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── RIGHT COLUMN ── -->
                    <div class="xl:col-span-1 flex flex-col gap-5">

                        <!-- Quick actions -->
                        <div class="bg-white rounded-2xl border border-gray-100/80 p-5">
                            <h2 class="text-[14px] font-bold text-gray-900 mb-4">Actions rapides</h2>
                            <div class="grid grid-cols-2 gap-3">
                                <button v-for="action in quickActions" :key="action.label"
                                    class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/40 transition-all group cursor-pointer">
                                    <span
                                        class="w-9 h-9 rounded-xl flex items-center justify-center text-[13px] transition-colors"
                                        :style="`background:${action.bg}; color:${action.color}`">
                                        <i :class="action.icon"></i>
                                    </span>
                                    <span
                                        class="text-[11px] font-semibold text-gray-600 group-hover:text-gray-900 text-center leading-tight transition-colors">
                                        {{ action.label }}
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Top students -->
                        <!-- <div class="bg-white rounded-2xl border border-gray-100/80 p-5 flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-[14px] font-bold text-gray-900">Top étudiants</h2>
                                <span class="text-[10px] text-gray-400 font-medium">cette semaine</span>
                            </div>
                            <div class="flex flex-col gap-3">
                                <div v-for="(student, i) in topStudents" :key="student.name"
                                    class="flex items-center gap-3">
                                    <span
                                        class="w-5 h-5 rounded-full flex items-center justify-center text-[9px] font-extrabold shrink-0"
                                        :class="i === 0 ? 'bg-amber-400 text-amber-900' : i === 1 ? 'bg-gray-200 text-gray-600' : 'bg-orange-100 text-orange-600'">
                                        {{ i + 1 }}
                                    </span>

                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white shrink-0"
                                        :style="`background: ${student.avatarColor}`">
                                        {{ student.initials }}
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-[12px] font-semibold text-gray-800 truncate">{{ student.name }}
                                        </p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <div class="flex-1 h-1 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full bg-amber-400 transition-all duration-500"
                                                    :style="`width:${student.progress}%`"></div>
                                            </div>
                                            <span class="text-[9px] font-bold text-gray-400 shrink-0">{{
                                                student.progress }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <!-- /RIGHT COLUMN -->
                </div>
                <!-- /MAIN GRID -->

                <!-- ── BOTTOM BAND: Recent Activity ── -->
                <!-- <div class="mt-5 bg-white rounded-2xl border border-gray-100/80 px-5 py-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-[14px] font-bold text-gray-900">Activité récente</h2>
                        <span class="text-[10px] text-gray-400">Aujourd'hui</span>
                    </div>
                    <div class="flex flex-col gap-3.5">
                        <div v-for="event in recentActivity" :key="event.id" class="flex items-start gap-3.5">
                            <span
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-[11px] shrink-0 mt-0.5"
                                :style="`background:${event.iconBg}; color:${event.iconColor}`">
                                <i :class="event.icon"></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[12.5px] font-semibold text-gray-800">{{ event.title }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ event.subtitle }}</p>
                            </div>
                            <span class="text-[10px] text-gray-300 font-medium shrink-0 mt-0.5">{{ event.time }}</span>
                        </div>
                    </div>
                </div> -->

            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import Navbar from '@/Components/Teacher/Layout/Navbar.vue'
import Sidebar from '@/Components/Teacher/Layout/Sidebar.vue'

/* ── Types ── */
interface User { name: string; email: string }
interface Course {
    id: number; title: string; category: string; format: string
    icon: string; iconBg: string; iconColor: string
    formatBg: string; formatColor: string
    students: number; status: string
}

/* ── Auth ── */
const page = usePage()
const user = page.props.auth.user as User

/* ── Computed ── */
const firstName = computed(() => user.name.split(' ')[0])

const today = computed(() => {
    return new Intl.DateTimeFormat('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' }).format(new Date())
})

/* ── Reactive state ── */
const showNewCourseModal = ref(false)

/* ── KPIs ── */
const kpis = [
    {
        label: 'Cours publiés',
        value: '21',
        icon: 'fas fa-book-open',
        iconBg: '#FEF3C7',
        iconColor: '#D97706',
        badge: '+3 ce mois',
        badgeBg: '#ECFDF5',
        badgeColor: '#059669',
    },
    {
        label: 'Étudiants inscrits',
        value: '348',
        icon: 'fas fa-users',
        iconBg: '#EFF6FF',
        iconColor: '#3B82F6',
        badge: '+24 / sem.',
        badgeBg: '#EFF6FF',
        badgeColor: '#3B82F6',
    },
    {
        label: 'Taux de complétion',
        value: '67%',
        icon: 'fas fa-chart-pie',
        iconBg: '#F5F3FF',
        iconColor: '#7C3AED',
        badge: '↑ 4pts',
        badgeBg: '#ECFDF5',
        badgeColor: '#059669',
    },
    {
        label: 'Revenus du mois',
        value: '1 840€',
        icon: 'fas fa-coins',
        iconBg: '#FEF3C7',
        iconColor: '#F4B400',
        badge: '+12%',
        badgeBg: '#ECFDF5',
        badgeColor: '#059669',
    },
]

/* ── Courses table ── */
const courses: Course[] = [
    {
        id: 1, title: 'JavaScript Avancé — Patterns & Architecture', category: 'Développement Web',
        format: 'Vidéo', icon: 'fas fa-code', iconBg: '#FEF3C7', iconColor: '#D97706',
        formatBg: '#FEF3C7', formatColor: '#D97706', students: 112, status: 'Publié',
    },
    {
        id: 2, title: 'Fondamentaux UX/UI Design', category: 'Design',
        format: 'PDF', icon: 'fas fa-paint-brush', iconBg: '#EDE9FE', iconColor: '#7C3AED',
        formatBg: '#FEE2E2', formatColor: '#DC2626', students: 78, status: 'Publié',
    },
    {
        id: 3, title: 'Python pour la Data Science', category: 'Data & IA',
        format: 'Audio', icon: 'fas fa-brain', iconBg: '#ECFDF5', iconColor: '#059669',
        formatBg: '#EFF6FF', formatColor: '#3B82F6', students: 95, status: 'Publié',
    },
    {
        id: 4, title: 'Marketing Digital & SEO Avancé', category: 'Marketing',
        format: 'PDF', icon: 'fas fa-bullhorn', iconBg: '#FFF7ED', iconColor: '#EA580C',
        formatBg: '#FEE2E2', formatColor: '#DC2626', students: 63, status: 'Brouillon',
    },
    {
        id: 5, title: 'React 18 — Hooks & Performance', category: 'Développement Web',
        format: 'Vidéo', icon: 'fas fa-atom', iconBg: '#ECFEFF', iconColor: '#0891B2',
        formatBg: '#FEF3C7', formatColor: '#D97706', students: 134, status: 'Publié',
    },
]

/* ── Quick actions ── */
const quickActions = [
    { label: 'Ajouter une vidéo', icon: 'fas fa-circle-play', bg: '#FEF3C7', color: '#D97706' },
    { label: 'Ajouter un PDF', icon: 'fas fa-file-pdf', bg: '#FEE2E2', color: '#DC2626' },
    { label: 'Ajouter un audio', icon: 'fas fa-microphone', bg: '#EFF6FF', color: '#3B82F6' },
    { label: 'Voir les stats', icon: 'fas fa-chart-bar', bg: '#F5F3FF', color: '#7C3AED' },
]

</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-gray-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
    border-radius: 99px
}
</style>
