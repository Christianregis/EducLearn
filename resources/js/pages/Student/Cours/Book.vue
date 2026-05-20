<template>
    <div class="flex h-screen overflow-hidden font-sans" style="background:#F4F5F7">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <main class="flex-1 overflow-hidden flex relative">

                <!-- ══════════════════════════════════════
                     ZONE PRINCIPALE
                ══════════════════════════════════════ -->
                <div class="flex-1 flex flex-col overflow-hidden min-w-0 transition-all duration-300">
                    <div class="flex-1 overflow-y-auto px-8 pt-8 pb-12 scrollbar-thin">

                        <!-- ── HEADER ── -->
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-8">
                            <div>
                                <!-- Label pill -->
                                <span
                                    class="inline-flex items-center gap-1.5 text-[10px] font-bold tracking-[0.15em] uppercase mb-3 px-3 py-1 rounded-full"
                                    :style="`color:${THEME.accent}; background:${THEME.accent}14`">
                                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" :style="`background:${THEME.accent}`"></span>
                                    {{ THEME.pageLabel }}
                                </span>

                                <h1 class="text-[26px] font-extrabold text-gray-900 tracking-tight leading-tight">
                                    {{ THEME.pageTitle }}
                                </h1>

                                <p class="text-[13px] text-gray-400 mt-1.5 flex items-center gap-1.5">
                                    <span class="font-bold text-gray-700 text-[14px]">{{ filteredAndSorted.length }}</span>
                                    {{ THEME.pageSubtitle }}
                                    <span v-if="activeFilter !== 'all'"
                                        class="inline-flex items-center gap-1 ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                        :style="`background:${THEME.accent}15; color:${THEME.accent}`">
                                        <i class="fas fa-filter text-[8px]"></i> filtre actif
                                    </span>
                                </p>
                            </div>

                            <!-- Search + Sort -->
                            <div class="flex items-center gap-2.5">
                                <!-- Search -->
                                <div class="relative">
                                    <input v-model="search" type="text"
                                        :placeholder="`Rechercher un ${THEME.itemName}...`"
                                        class="w-60 pl-10 pr-4 py-2.5 bg-white rounded-xl text-[13px] text-gray-800 placeholder-gray-300 focus:outline-none transition-all duration-200"
                                        style="border:1.5px solid #E8E8EC; box-shadow:0 1px 3px rgba(0,0,0,0.04)"
                                        :style="`--tw-ring-color:${THEME.accent}40`"
                                        @focus="e => (e.target as HTMLInputElement).style.borderColor = THEME.accent"
                                        @blur="e => (e.target as HTMLInputElement).style.borderColor = '#E8E8EC'" />
                                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-[11px]"></i>
                                </div>

                                <!-- Sort -->
                                <div class="relative">
                                    <select v-model="sortKey"
                                        class="appearance-none bg-white rounded-xl text-[13px] text-gray-700 pl-3.5 pr-9 py-2.5 focus:outline-none cursor-pointer transition-all duration-200"
                                        style="border:1.5px solid #E8E8EC; box-shadow:0 1px 3px rgba(0,0,0,0.04)">
                                        <option value="recent">Plus récent</option>
                                        <option value="title">Titre A→Z</option>
                                        <option value="progress_asc">Progression ↑</option>
                                        <option value="progress_desc">Progression ↓</option>
                                        <option value="level">Niveau</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 text-[9px] pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- ── FILTER TABS ── -->
                        <div class="flex items-center gap-1.5 mb-7 flex-wrap">
                            <button v-for="tab in filterTabs" :key="tab.id"
                                @click="activeFilter = tab.id"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[12px] font-bold transition-all duration-200 border"
                                :style="activeFilter === tab.id
                                    ? `background:${THEME.accent}; color:${THEME.accentText}; border-color:${THEME.accent}; box-shadow:0 4px 12px ${THEME.accent}35`
                                    : 'background:#fff; color:#9CA3AF; border-color:#EBEBEF; box-shadow:0 1px 2px rgba(0,0,0,0.03)'">
                                {{ tab.label }}
                                <span
                                    class="min-w-5 h-5 px-1.5 text-[10px] rounded-lg font-extrabold flex items-center justify-center"
                                    :style="activeFilter === tab.id
                                        ? 'background:rgba(0,0,0,0.15); color:inherit'
                                        : 'background:#F3F4F6; color:#6B7280'">
                                    {{ tab.count }}
                                </span>
                            </button>
                        </div>

                        <!-- ── GRILLE DE COURS ── -->
                        <div v-if="filteredAndSorted.length > 0"
                            class="grid grid-cols-[repeat(auto-fill,minmax(230px,1fr))] gap-4">
                            <div v-for="(enrollment, idx) in filteredAndSorted" :key="enrollment.id"
                                @click="selectEnrollment(enrollment)"
                                class="group relative bg-white rounded-2xl overflow-hidden cursor-pointer transition-all duration-300 hover:-translate-y-1 card-appear"
                                :style="`
                                    animation-delay:${idx * 40}ms;
                                    ${selectedEnrollment?.id === enrollment.id
                                        ? `box-shadow: 0 0 0 2.5px ${THEME.accent}, 0 12px 32px rgba(0,0,0,0.10)`
                                        : 'border:1.5px solid #EBEBEF; box-shadow:0 1px 4px rgba(0,0,0,0.04)'
                                    }
                                `">

                                <!-- Thumbnail -->
                                <div class="h-38 relative overflow-hidden flex items-center justify-center"
                                    style="height:152px"
                                    :style="`background: ${enrollment.course.color || THEME.defaultCardBg}`">

                                    <!-- Motif décoratif subtil -->
                                    <div class="absolute inset-0"
                                        :style="`background: repeating-linear-gradient(45deg, ${THEME.accent} 0px, ${THEME.accent} 1px, transparent 0, transparent 50%) / 18px 18px; opacity:0.07`">
                                    </div>
                                    <!-- Orbe lumineux en coin -->
                                    <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full blur-2xl opacity-30"
                                        :style="`background:${THEME.accent}`"></div>

                                    <!-- Image du cours -->
                                    <img v-if="enrollment.course.image"
                                        :src="enrollment.course.image"
                                        :alt="enrollment.course.title"
                                        class="absolute inset-0 w-full h-full object-cover opacity-15 group-hover:opacity-25 transition-opacity duration-300" />

                                    <!-- Icône centrale -->
                                    <div class="relative z-10 flex flex-col items-center gap-2">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-[22px] shadow-lg group-hover:scale-110 transition-transform duration-300"
                                            :style="`background:${THEME.accent}25; color:${THEME.accent}; backdrop-filter:blur(4px)`">
                                            <i :class="enrollment.course.icon || THEME.defaultIcon"></i>
                                        </div>
                                    </div>

                                    <!-- Badge format -->
                                    <div class="absolute top-2.5 right-2.5">
                                        <span class="text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-lg"
                                            :style="`background:${THEME.accent}; color:${THEME.accentText}; box-shadow:0 2px 8px ${THEME.accent}50`">
                                            {{ enrollment.course.format }}
                                        </span>
                                    </div>

                                    <!-- Badge complété -->
                                    <div v-if="enrollment.progress === 100" class="absolute top-2.5 left-2.5">
                                        <span class="text-[9px] font-bold bg-emerald-500 text-white px-2.5 py-1 rounded-lg flex items-center gap-1 shadow-md">
                                            <i class="fas fa-check text-[8px]"></i> Terminé
                                        </span>
                                    </div>
                                </div>

                                <!-- Corps carte -->
                                <div class="p-4 pt-3.5">
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full mb-2.5 inline-block"
                                        :class="levelClass(enrollment.course.level)">
                                        {{ enrollment.course.level }}
                                    </span>

                                    <h4 class="text-[13px] font-bold text-gray-900 leading-snug mb-1.5 line-clamp-2 group-hover:text-gray-700 transition-colors">
                                        {{ enrollment.course.title }}
                                    </h4>

                                    <p class="text-[11px] text-gray-400 mb-3.5 flex items-center gap-1.5">
                                        <i class="fas fa-clock text-[9px] opacity-60"></i>
                                        {{ enrollment.course.duration || '—' }}
                                    </p>

                                    <!-- Barre de progression -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1.5">
                                            <span class="text-[10px] text-gray-400 font-medium">Progression</span>
                                            <span class="text-[11px] font-extrabold"
                                                :style="`color:${progressColor(enrollment.progress)}`">
                                                {{ enrollment.progress }}%
                                            </span>
                                        </div>
                                        <div class="h-1.5 rounded-full overflow-hidden" style="background:#F0F0F4">
                                            <div class="h-full rounded-full transition-all duration-700"
                                                :style="`width:${enrollment.progress}%; background:${progressColor(enrollment.progress)}; box-shadow:0 0 6px ${progressColor(enrollment.progress)}60`">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sélection indicator bottom -->
                                <div v-if="selectedEnrollment?.id === enrollment.id"
                                    class="absolute bottom-0 left-0 right-0 h-0.5 rounded-b-2xl"
                                    :style="`background:${THEME.accent}`">
                                </div>
                            </div>
                        </div>

                        <!-- ── EMPTY STATE ── -->
                        <div v-else class="flex flex-col items-center justify-center py-28 text-center">
                            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-5 shadow-sm"
                                :style="`background:${THEME.accent}12`">
                                <i :class="THEME.icon" class="text-[28px]" :style="`color:${THEME.accent}`"></i>
                            </div>
                            <h3 class="text-[15px] font-bold text-gray-800 mb-1.5">Aucun {{ THEME.itemName }} trouvé</h3>
                            <p class="text-[13px] text-gray-400">Essayez un autre filtre ou terme de recherche</p>
                        </div>

                    </div>
                </div>

                <!-- ══════════════════════════════════════
                     PANNEAU DÉTAIL (slide droite)
                ══════════════════════════════════════ -->
                <CourseDetail
                    v-if="selectedEnrollment"
                    :enrollement="selectedEnrollment"
                    :theme="THEME"
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
        selectedEnrollment.value = null
    }
}
</script>

<style scoped>
/* ── Scrollbar custom ── */
.scrollbar-thin::-webkit-scrollbar { width: 4px }
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #DDDDE8;
    border-radius: 9999px;
}

/* ── Line clamp ── */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── Card appear stagger ── */
@keyframes cardAppear {
    from { opacity: 0; transform: translateY(12px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0)    scale(1); }
}
.card-appear {
    opacity: 0;
    animation: cardAppear 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

/* ── Transition panneau latéral ── */
.slide-panel-enter-active,
.slide-panel-leave-active {
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.22s ease;
}
.slide-panel-enter-from,
.slide-panel-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

/* ── Transition overlay ── */
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease }
.fade-enter-from, .fade-leave-to { opacity: 0 }

/* ── Pulse dot ── */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}
.animate-pulse { animation: pulse 2s ease-in-out infinite; }
</style>
