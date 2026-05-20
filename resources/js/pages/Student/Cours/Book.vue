<template>
    <div class="flex h-screen overflow-hidden font-sans bg-[#FAFAF8]">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <main class="flex-1 overflow-hidden flex relative">

                <!-- ══════════════════════════════════════
                     ZONE PRINCIPALE
                ══════════════════════════════════════ -->
                <div class="flex-1 flex flex-col overflow-hidden min-w-0 transition-all duration-300"
                    >
                    <div class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin">

                        <!-- ── HEADER ── -->
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-7">
                            <div>
                                <span
                                    class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-[0.12em] uppercase mb-2"
                                    :style="`color:${THEME.accent}`">
                                    {{ THEME.pageLabel }}
                                </span>
                                <h1 class="text-[22px] font-bold text-gray-900">{{ THEME.pageTitle }}</h1>
                                <p class="text-[13px] text-gray-400 mt-0.5">
                                    <span class="font-medium text-gray-700">{{ filteredAndSorted.length }}</span>
                                    {{ THEME.pageSubtitle }}
                                    <span v-if="activeFilter !== 'all'" class="ml-1">· filtre actif</span>
                                </p>
                            </div>

                            <!-- Search + Sort -->
                            <div class="flex items-center gap-2.5">
                                <div class="relative">
                                    <input v-model="search" type="text"
                                        :placeholder="`Rechercher un ${THEME.itemName}...`"
                                        class="w-56 pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-shadow"
                                        :style="`--tw-ring-color:${THEME.accent}40`" />
                                    <i
                                        class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                </div>

                                <div class="relative">
                                    <select v-model="sortKey"
                                        class="appearance-none bg-white border border-gray-200 rounded-xl text-sm text-gray-700 pl-3 pr-8 py-2.5 focus:outline-none focus:ring-2 focus:border-transparent cursor-pointer transition-shadow"
                                        :style="`--tw-ring-color:${THEME.accent}40`">
                                        <option value="recent">Plus récent</option>
                                        <option value="title">Titre A→Z</option>
                                        <option value="progress_asc">Progression ↑</option>
                                        <option value="progress_desc">Progression ↓</option>
                                        <option value="level">Niveau</option>
                                    </select>
                                    <i
                                        class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- ── FILTER TABS ── -->
                        <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-100 flex-wrap">
                            <button v-for="tab in filterTabs" :key="tab.id" @click="activeFilter = tab.id"
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-[12px] font-semibold transition-all duration-200"
                                :class="activeFilter === tab.id
                                    ? ''
                                    : 'text-gray-400 hover:text-gray-600 hover:bg-white'" :style="activeFilter === tab.id
                                        ? `background:${THEME.accent}; color:${THEME.accentText}`
                                        : ''">
                                {{ tab.label }}
                                <span class="px-1.5 py-0.5 text-[10px] rounded-full font-bold"
                                    :class="activeFilter === tab.id ? 'bg-black/10' : 'bg-gray-100 text-gray-500'">
                                    {{ tab.count }}
                                </span>
                            </button>
                        </div>

                        <!-- ── GRILLE DE COURS ── -->
                        <div v-if="filteredAndSorted.length > 0"
                            class="grid grid-cols-[repeat(auto-fill,minmax(220px,1fr))] gap-4">
                            <div v-for="enrollment in filteredAndSorted" :key="enrollment.id"
                                @click="selectEnrollment(enrollment)"
                                class="group relative bg-white rounded-2xl overflow-hidden cursor-pointer transition-all duration-300 hover:-translate-y-1"
                                :class="selectedEnrollment?.id === enrollment.id
                                    ? 'shadow-lg'
                                    : 'border border-gray-100 hover:shadow-md'" :style="selectedEnrollment?.id === enrollment.id
                                        ? `box-shadow: 0 0 0 2px ${THEME.accent}, 0 8px 24px rgba(0,0,0,0.08)`
                                        : ''">
                                <!-- Thumbnail -->
                                <div class="h-36 relative overflow-hidden flex items-center justify-center"
                                    :style="`background: ${enrollment.course.color || THEME.defaultCardBg}`">
                                    <!-- Motif décoratif -->
                                    <div class="absolute inset-0 opacity-10"
                                        :style="`background: repeating-linear-gradient(45deg, ${THEME.accent} 0px, ${THEME.accent} 1px, transparent 0, transparent 50%) / 16px 16px`">
                                    </div>

                                    <!-- Image du cours si disponible -->
                                    <img v-if="enrollment.course.image" :src="enrollment.course.image"
                                        :alt="enrollment.course.title"
                                        class="absolute inset-0 w-full h-full object-cover opacity-20" />

                                    <!-- Icône centrale -->
                                    <div class="relative z-10 flex flex-col items-center gap-2">
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shadow-sm"
                                            :style="`background:${THEME.accent}20; color:${THEME.accent}`">
                                            <i :class="enrollment.course.icon || THEME.defaultIcon"></i>
                                        </div>
                                    </div>

                                    <!-- Badge format -->
                                    <div class="absolute top-2.5 right-2.5">
                                        <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-1 rounded-lg"
                                            :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                                            {{ enrollment.course.format }}
                                        </span>
                                    </div>

                                    <!-- Badge complété -->
                                    <div v-if="enrollment.progress === 100" class="absolute top-2.5 left-2.5">
                                        <span
                                            class="text-[9px] font-bold bg-emerald-500 text-white px-2 py-1 rounded-lg flex items-center gap-1">
                                            <i class="fas fa-check text-[8px]"></i> Terminé
                                        </span>
                                    </div>
                                </div>

                                <!-- Corps carte -->
                                <div class="p-4">
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full mb-2 inline-block"
                                        :class="levelClass(enrollment.course.level)">
                                        {{ enrollment.course.level }}
                                    </span>

                                    <h4
                                        class="text-[13px] font-bold text-gray-900 leading-snug mb-1 line-clamp-2 transition-colors">
                                        {{ enrollment.course.title }}
                                    </h4>

                                    <p class="text-[11px] text-gray-400 mb-3 flex items-center gap-1">
                                        <i class="fas fa-clock text-[9px]"></i>
                                        {{ enrollment.course.duration || '—' }}
                                    </p>

                                    <!-- Barre de progression -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[10px] text-gray-400">Progression</span>
                                            <span class="text-[11px] font-bold text-gray-800">
                                                {{ enrollment.progress }}%
                                            </span>
                                        </div>
                                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-700"
                                                :style="`width:${enrollment.progress}%; background:${progressColor(enrollment.progress)}`">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── EMPTY STATE ── -->
                        <div v-else class="flex flex-col items-center justify-center py-24 text-center">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                                :style="`background:${THEME.accent}15`">
                                <i :class="THEME.icon" class="text-2xl" :style="`color:${THEME.accent}`"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 mb-1">Aucun {{ THEME.itemName }} trouvé</h3>
                            <p class="text-xs text-gray-400">Essayez un autre filtre ou terme de recherche</p>
                        </div>

                    </div>
                </div>

                <!-- ══════════════════════════════════════
                     PANNEAU DÉTAIL (slide droite)
                ══════════════════════════════════════ -->
                <CourseDetail v-if="selectedEnrollment" :enrollement="selectedEnrollment" :theme="THEME"
                    @close-course-detail="closeEnrollementDetails" />
            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import CourseDetail from '@/Components/Admin/CourseDetail.vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'
import { BOOKTHEME } from '@/types/bookTheme'
import type { EnrollmentItem } from '@/types/enrollement'
import { levelClass } from '@/utils/levelClass'
import { LEVEL_ORDER } from '@/utils/levelOrder'
import { progressColor } from '@/utils/progressColor'

// ──────────────────────────────────────────────────────────────
// THÈME — Modifiez ici pour adapter à Vidéo / Audio / PDF
// ──────────────────────────────────────────────────────────────
const THEME = BOOKTHEME

// ──────────────────────────────────────────────────────────────
// TYPES
// ──────────────────────────────────────────────────────────────


interface PageProps {
    books: {
        data: EnrollmentItem[]
    }
}

// ──────────────────────────────────────────────────────────────
// PAGE PROPS
// ──────────────────────────────────────────────────────────────
const page = usePage()
const user = page.props.auth.user
const props = defineProps<PageProps>()
const rawData = props.books?.data ?? []

// ──────────────────────────────────────────────────────────────
// FILTRE PAR FORMAT
// ──────────────────────────────────────────────────────────────
const enrollments = computed<EnrollmentItem[]>(() =>
    rawData.filter(
        (e) => e.course?.format?.toLowerCase() === THEME.format.toLowerCase()
    )
)

// ──────────────────────────────────────────────────────────────
// ÉTAT LOCAL
// ──────────────────────────────────────────────────────────────
type FilterId = 'all' | 'in-progress' | 'completed' | 'new'
type SortKey = 'recent' | 'title' | 'progress_asc' | 'progress_desc' | 'level'

const search = ref<string>('')
const sortKey = ref<SortKey>('recent')
const activeFilter = ref<FilterId>('all')
const selectedEnrollment = ref<EnrollmentItem | null>(null)

// ──────────────────────────────────────────────────────────────
// ONGLETS DE FILTRE
// ──────────────────────────────────────────────────────────────
const filterTabs = computed(() => [
    {
        id: 'all' as FilterId,
        label: 'Tous',
        count: enrollments.value.length,
    },
    {
        id: 'in-progress' as FilterId,
        label: 'En cours',
        count: enrollments.value.filter(
            (e) => e.progress > 0 && e.progress < 100
        ).length,
    },
    {
        id: 'completed' as FilterId,
        label: 'Terminés',
        count: enrollments.value.filter(
            (e) => e.progress === 100
        ).length,
    },
    {
        id: 'new' as FilterId,
        label: 'Non commencés',
        count: enrollments.value.filter(
            (e) => e.progress === 0
        ).length,
    },
])

// ──────────────────────────────────────────────────────────────
// PIPELINE : FILTRE + RECHERCHE + TRI
// ──────────────────────────────────────────────────────────────
const filteredAndSorted = computed<EnrollmentItem[]>(() => {
    let list = [...enrollments.value]

    // ── Filtre onglet
    if (activeFilter.value === 'in-progress') {
        list = list.filter((e) => e.progress > 0 && e.course.progress < 100)
    } else if (activeFilter.value === 'completed') {
        list = list.filter((e) => e.progress === 100)
    } else if (activeFilter.value === 'new') {
        list = list.filter((e) => e.progress === 0)
    }

    // ── Recherche textuelle
    const q = search.value.trim().toLowerCase()

    if (q) {
        list = list.filter(
            (e) =>
                e.course.title.toLowerCase().includes(q) ||
                e.course.description?.toLowerCase().includes(q) ||
                e.course.category?.toLowerCase().includes(q)
        )
    }

    // ── Tri
    list.sort((a, b) => {
        switch (sortKey.value) {
            case 'title':
                return a.course.title.localeCompare(b.course.title, 'fr')
            case 'progress_asc':
                return a.progress - b.progress
            case 'progress_desc':
                return b.progress - a.progress
            case 'level':
                return (LEVEL_ORDER[a.course.level] ?? 9) - (LEVEL_ORDER[b.course.level] ?? 9)
            case 'recent':
            default:
                return new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        }
    })

    return list
})

// ──────────────────────────────────────────────────────────────
// ACTIONS
// ──────────────────────────────────────────────────────────────
function selectEnrollment(enrollment: EnrollmentItem): void {
    selectedEnrollment.value = selectedEnrollment.value?.id === enrollment.id ? null : enrollment

}
function closeEnrollementDetails(isClose: boolean) {
    if (isClose) {
        selectedEnrollment.value = null;
    }
}
</script>

<style scoped>
/* ── Scrollbar custom ── */
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #E5E7EB;
    border-radius: 9999px
}

/* ── Line clamp ── */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── Transition panneau latéral ── */
.slide-panel-enter-active,
.slide-panel-leave-active {
    transition:
        transform 0.28s cubic-bezier(0.4, 0, 0.2, 1),
        opacity 0.22s ease;
}

.slide-panel-enter-from,
.slide-panel-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

/* ── Transition overlay ── */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0
}
</style>
