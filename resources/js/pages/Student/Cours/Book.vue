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
                    :class="selectedEnrollment ? 'lg:mr-[380px]' : ''">
                    <div class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin">

                        <!-- ── HEADER ── -->
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-7">
                            <div>
                                <span
                                    class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-[0.12em] uppercase mb-2"
                                    :style="`color:${THEME.accent}`">
                                    <i :class="THEME.icon" class="text-[10px]"></i>
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
                                    <div v-if="enrollment.course.progress === 100" class="absolute top-2.5 left-2.5">
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
                                                {{ enrollment.course.progress }}%
                                            </span>
                                        </div>
                                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-700"
                                                :style="`width:${enrollment.course.progress}%; background:${progressColor(enrollment.course.progress)}`">
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
                <Transition name="slide-panel">
                    <aside v-if="selectedEnrollment"
                        class="fixed right-0 top-0 h-full w-[380px] bg-white border-l border-gray-100 shadow-2xl flex flex-col z-30 overflow-hidden">
                        <!-- Header panneau -->
                        <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-50">
                            <span class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">
                                Détail du {{ THEME.itemName }}
                            </span>
                            <button @click="selectedEnrollment = null"
                                class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors text-gray-500 text-xs">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Body scrollable -->
                        <div class="flex-1 overflow-y-auto scrollbar-thin">

                            <!-- Couverture décorative -->
                            <div class="h-52 relative flex items-center justify-center overflow-hidden"
                                :style="`background:${selectedEnrollment.course.color || THEME.defaultCardBg}`">
                                <div class="absolute inset-0 opacity-10"
                                    :style="`background: repeating-linear-gradient(45deg, ${THEME.accent} 0px, ${THEME.accent} 1px, transparent 0, transparent 50%) / 16px 16px`">
                                </div>

                                <!-- Image de fond si disponible -->
                                <img v-if="selectedEnrollment.course.image" :src="selectedEnrollment.course.image"
                                    :alt="selectedEnrollment.course.title"
                                    class="absolute inset-0 w-full h-full object-cover opacity-15" />

                                <!-- Cercles déco -->
                                <div class="absolute -bottom-8 -right-8 w-32 h-32 rounded-full opacity-20"
                                    :style="`background:${THEME.accent}`"></div>
                                <div class="absolute -top-4 -left-4 w-20 h-20 rounded-full opacity-10"
                                    :style="`background:${THEME.accent}`"></div>

                                <!-- Icône centrale -->
                                <div class="relative z-10 flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-lg"
                                        :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                                        <i :class="selectedEnrollment.course.icon || THEME.defaultIcon"></i>
                                    </div>
                                </div>

                                <!-- Badge progression -->
                                <div class="absolute bottom-3 right-3">
                                    <div
                                        class="bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-bold text-gray-800 shadow-sm">
                                        {{ selectedEnrollment.course.progress }}% complété
                                    </div>
                                </div>
                            </div>

                            <!-- Infos principales -->
                            <div class="px-5 py-5">

                                <!-- Badges statut -->
                                <div class="flex items-center gap-2 mb-3 flex-wrap">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide"
                                        :class="levelClass(selectedEnrollment.course.level)">
                                        {{ selectedEnrollment.course.level }}
                                    </span>
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide"
                                        :style="`background:${THEME.accent}20; color:${THEME.accent}`">
                                        {{ selectedEnrollment.course.format }}
                                    </span>
                                    <span v-if="selectedEnrollment.course.status"
                                        class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 uppercase tracking-wide">
                                        {{ selectedEnrollment.course.status }}
                                    </span>
                                </div>

                                <!-- Titre -->
                                <h2 class="text-[17px] font-bold text-gray-900 leading-snug mb-2">
                                    {{ selectedEnrollment.course.title }}
                                </h2>

                                <!-- Description -->
                                <p v-if="selectedEnrollment.course.description"
                                    class="text-[12.5px] text-gray-500 leading-relaxed mb-5">
                                    {{ selectedEnrollment.course.description }}
                                </p>

                                <!-- Méta-données : grille 2 colonnes -->
                                <div class="grid grid-cols-2 gap-3 mb-5">
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Durée</p>
                                        <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                            <i class="fas fa-clock text-[11px]" :style="`color:${THEME.accent}`"></i>
                                            {{ selectedEnrollment.course.duration || '—' }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Catégorie</p>
                                        <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                            <i class="fas fa-tag text-[11px]" :style="`color:${THEME.accent}`"></i>
                                            {{ selectedEnrollment.course.category || '—' }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Étudiants</p>
                                        <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                            <i class="fas fa-users text-[11px]" :style="`color:${THEME.accent}`"></i>
                                            {{ selectedEnrollment.course.students ?? 0 }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Prix</p>
                                        <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                            <i class="fas fa-coins text-[11px]" :style="`color:${THEME.accent}`"></i>
                                            {{ selectedEnrollment.course.price > 0
                                                ? selectedEnrollment.course.price + ' FCFA'
                                                : 'Gratuit' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Progression détaillée -->
                                <div class="mb-5">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-semibold text-gray-600">Votre progression</span>
                                        <span class="text-sm font-bold"
                                            :style="`color:${progressColor(selectedEnrollment.course.progress)}`">
                                            {{ selectedEnrollment.course.progress }}%
                                        </span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700"
                                            :style="`width:${selectedEnrollment.course.progress}%; background:${progressColor(selectedEnrollment.course.progress)}`">
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1.5">
                                        Inscrit le {{ formatDate(selectedEnrollment.created_at) }}
                                    </p>
                                </div>

                                <div class="border-t border-gray-100 mb-5"></div>

                                <!-- Aperçu image -->
                                <div v-if="selectedEnrollment.course.image" class="mb-5">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-2">
                                        Aperçu</p>
                                    <img :src="selectedEnrollment.course.image" :alt="selectedEnrollment.course.title"
                                        class="w-full h-32 object-cover rounded-xl border border-gray-100" />
                                </div>
                            </div>
                        </div>

                        <!-- ── CTA FOOTER ── -->
                        <div class="px-5 py-4 border-t border-gray-100 bg-white">

                            <!-- Cours terminé -->
                            <div v-if="selectedEnrollment.course.progress === 100" class="flex items-center gap-3">
                                <div class="flex-1 flex items-center gap-2 bg-emerald-50 rounded-xl px-4 py-3">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                    <span class="text-sm font-semibold text-emerald-700">Cours terminé</span>
                                </div>
                                <a v-if="selectedEnrollment.course.file" :href="selectedEnrollment.course.file"
                                    target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center border border-gray-200 hover:bg-gray-50 transition-colors text-gray-500 text-sm"
                                    title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>

                            <!-- Cours en cours -->
                            <div v-else class="flex items-center gap-3">
                                <a v-if="selectedEnrollment.course.file" :href="selectedEnrollment.course.file"
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex-1 inline-flex items-center justify-center gap-2.5 font-bold text-[13px] py-3 rounded-xl border-none cursor-pointer transition-all hover:opacity-90 hover:shadow-md no-underline"
                                    :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                                    <i :class="THEME.ctaIcon"></i>
                                    {{ selectedEnrollment.course.progress > 0 ? THEME.ctaContinue : THEME.ctaStart }}
                                </a>
                                <button v-else disabled
                                    class="flex-1 inline-flex items-center justify-center gap-2.5 font-bold text-[13px] py-3 rounded-xl border-none cursor-not-allowed opacity-50"
                                    :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                                    <i class="fas fa-ban"></i> Fichier indisponible
                                </button>
                            </div>
                        </div>
                    </aside>
                </Transition>

                <!-- Overlay mobile -->
                <Transition name="fade">
                    <div v-if="selectedEnrollment" class="lg:hidden fixed inset-0 bg-black/30 z-20 backdrop-blur-sm"
                        @click="selectedEnrollment = null"></div>
                </Transition>

            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

// ──────────────────────────────────────────────────────────────
// THÈME — Modifiez ici pour adapter à Vidéo / Audio / PDF
// ──────────────────────────────────────────────────────────────
const THEME = {
    format: 'pdf',
    accent: '#F4B400',
    accentText: '#1a1a1a',
    defaultCardBg: '#fef9e7',
    pageLabel: 'Bibliothèque PDF',
    pageTitle: 'Mes livres & PDF',
    pageSubtitle: 'ressources PDF disponibles',
    itemName: 'livre',
    icon: 'fas fa-book-open',
    defaultIcon: 'fas fa-file-pdf',
    ctaIcon: 'fas fa-book-reader',
    ctaStart: 'Commencer la lecture',
    ctaContinue: 'Continuer la lecture',
} as const

// ──────────────────────────────────────────────────────────────
// TYPES
// ──────────────────────────────────────────────────────────────
interface Course {
    id: number
    title: string
    description: string
    category: string
    teacher_id: number
    duration: string
    price: number
    image: string
    format: string
    progress: number
    icon: string
    color: string
    level: string
    file: string
    students: number
    status: string
}

interface EnrollmentItem {
    id: number
    student_id: number
    course_id: number
    video_id: number | null
    audio_id: number | null
    course: Course
    created_at: string
    updated_at: string
}

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
            (e) => e.course.progress > 0 && e.course.progress < 100
        ).length,
    },
    {
        id: 'completed' as FilterId,
        label: 'Terminés',
        count: enrollments.value.filter(
            (e) => e.course.progress === 100
        ).length,
    },
    {
        id: 'new' as FilterId,
        label: 'Non commencés',
        count: enrollments.value.filter(
            (e) => e.course.progress === 0
        ).length,
    },
])

// ──────────────────────────────────────────────────────────────
// PIPELINE : FILTRE + RECHERCHE + TRI
// ──────────────────────────────────────────────────────────────
const LEVEL_ORDER: Record<string, number> = {
    'Débutant': 0,
    'Intermédiaire': 1,
    'Avancé': 2,
}

const filteredAndSorted = computed<EnrollmentItem[]>(() => {
    let list = [...enrollments.value]

    // ── Filtre onglet
    if (activeFilter.value === 'in-progress') {
        list = list.filter((e) => e.course.progress > 0 && e.course.progress < 100)
    } else if (activeFilter.value === 'completed') {
        list = list.filter((e) => e.course.progress === 100)
    } else if (activeFilter.value === 'new') {
        list = list.filter((e) => e.course.progress === 0)
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
                return a.course.progress - b.course.progress
            case 'progress_desc':
                return b.course.progress - a.course.progress
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
    selectedEnrollment.value =
        selectedEnrollment.value?.id === enrollment.id ? null : enrollment
}

// ──────────────────────────────────────────────────────────────
// HELPERS
// ──────────────────────────────────────────────────────────────
function progressColor(progress: number): string {
    if (progress === 100) {
        return '#10B981'
    }

    if (progress >= 50) {
        return '#F4B400'
    }

    return '#F97316'
}

function levelClass(level: string): string {
    const map: Record<string, string> = {
        'Débutant': 'bg-emerald-50 text-emerald-600',
        'Intermédiaire': 'bg-blue-50 text-blue-600',
        'Avancé': 'bg-purple-50 text-purple-600',
    }

    return map[level] ?? 'bg-gray-100 text-gray-500'
}

function formatDate(dateStr: string): string {
    return new Date(dateStr).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
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
