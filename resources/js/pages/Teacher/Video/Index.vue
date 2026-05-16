<template>
    <FlashMessage />
    <div class="flex h-screen overflow-hidden bg-[#F0F2FF] font-sans">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-12 scrollbar-thin scrollbar-thumb-indigo-100">

                <!-- ── HEADER ── -->
                <div class="flex items-start justify-between mb-7">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-indigo-500">
                                Espace Enseignant
                            </span>
                        </div>
                        <h1 class="text-[24px] font-extrabold text-gray-900 leading-tight tracking-tight">
                            Cours Vidéo publiés
                        </h1>
                        <p class="text-[13px] text-gray-400 mt-1">
                            {{ filteredBooks.length }} cours{{ filteredBooks.length !== 1 ? '' : '' }} trouvé{{
                                filteredBooks.length !== 1 ? 's' : '' }}
                        </p>
                    </div>

                    <Link :href="teacherCoursesCreate()"
                        class="hidden sm:inline-flex items-center gap-2 text-[13px] font-bold px-5 py-2.5 rounded-[11px] transition-all duration-200 cursor-pointer border-none no-underline"
                        style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); color: #fff; box-shadow: 0 4px 14px rgba(99,102,241,0.35)">
                        <i class="fas fa-plus text-[10px]"></i>
                        Ajouter une vidéo
                    </Link>
                </div>

                <!-- ── FILTERS BAR ── -->
                <div class="flex items-center gap-3 mb-6 flex-wrap">
                    <!-- Search -->
                    <div class="relative flex-1 min-w-50 max-w-xs">
                        <i
                            class="fas fa-magnifying-glass text-[11px] text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input v-model="search" type="text" placeholder="Rechercher un cours vidéo…"
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-indigo-100 bg-white text-[13px] font-medium text-gray-800 placeholder-gray-300 outline-none transition-all focus:border-indigo-400 focus:shadow-[0_0_0_3px_rgba(99,102,241,0.12)]" />
                    </div>

                    <!-- Category filter -->
                    <div class="relative">
                        <select v-model="filterCategory"
                            class="pl-4 pr-8 py-2.5 rounded-xl border border-indigo-100 bg-white text-[12px] font-semibold text-gray-700 outline-none cursor-pointer appearance-none transition-all focus:border-indigo-400">
                            <option value="">Toutes catégories</option>
                            <option v-for="cat in allCategories" :key="cat" :value="cat">{{ cat }}</option>
                        </select>
                        <i
                            class="fas fa-chevron-down text-[9px] text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <!-- Level filter -->
                    <div class="relative">
                        <select v-model="filterLevel"
                            class="pl-4 pr-8 py-2.5 rounded-xl border border-indigo-100 bg-white text-[12px] font-semibold text-gray-700 outline-none cursor-pointer appearance-none transition-all focus:border-indigo-400">
                            <option value="">Tous niveaux</option>
                            <option v-for="lvl in allLevels" :key="lvl" :value="lvl">{{ lvl }}</option>
                        </select>
                        <i
                            class="fas fa-chevron-down text-[9px] text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <!-- View toggle -->
                    <div class="flex items-center bg-white border border-indigo-100 rounded-xl p-1 gap-0.5 ml-auto">
                        <button @click="view = 'grid'"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-[12px] transition-all cursor-pointer border-none"
                            :class="view === 'grid' ? 'bg-indigo-500 text-white' : 'bg-transparent text-gray-400 hover:text-gray-700'">
                            <i class="fas fa-grip"></i>
                        </button>
                        <button @click="view = 'list'"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-[12px] transition-all cursor-pointer border-none"
                            :class="view === 'list' ? 'bg-indigo-500 text-white' : 'bg-transparent text-gray-400 hover:text-gray-700'">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <!-- ── EMPTY STATE ── -->
                <div v-if="filteredBooks.length === 0" class="flex flex-col items-center justify-center py-20 gap-4">
                    <span class="w-16 h-16 rounded-2xl flex items-center justify-center text-[24px]"
                        style="background:#E0E7FF; color:#6366F1">
                        <i class="fas fa-film"></i>
                    </span>
                    <p class="text-[15px] font-bold text-gray-700">Aucune vidéo trouvée</p>
                    <p class="text-[13px] text-gray-400">Modifiez vos filtres ou ajoutez un nouveau cours vidéo.</p>
                </div>

                <!-- ── GRID VIEW ── -->
                <div v-else-if="view === 'grid'"
                    class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
                    <div v-for="book in filteredBooks" :key="book.id"
                        class="bg-white rounded-2xl border border-indigo-50 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 cursor-pointer group"
                        @click="openDetail(book)">

                        <!-- Thumbnail zone with play overlay -->
                        <div class="h-40 flex items-center justify-center relative overflow-hidden"
                            :style="`background: linear-gradient(135deg, ${book.color}18 0%, ${book.color}35 100%)`">
                            <img v-if="book.image" :src="book.image"
                                class="w-full h-full object-cover absolute inset-0" />
                            <i v-else :class="(book.icon || 'fas fa-film') + ' text-[40px] opacity-20'"
                                :style="`color:${book.color}`"></i>

                            <!-- Play button overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span
                                    class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-200"
                                    style="background: rgba(255,255,255,0.92); backdrop-filter: blur(4px)">
                                    <i class="fas fa-play text-indigo-600 text-[14px] ml-0.5"></i>
                                </span>
                            </div>

                            <!-- Duration badge bottom left -->
                            <span
                                class="absolute bottom-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1"
                                style="background:rgba(0,0,0,0.55); color:#fff; backdrop-filter:blur(4px)">
                                <i class="fas fa-clock text-[8px]"></i>
                                {{ book.duration }}
                            </span>

                            <!-- Status pill -->
                            <span
                                class="absolute top-3 right-3 text-[10px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1"
                                :class="book.status === 'Publié' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'">
                                <span class="w-1.5 h-1.5 rounded-full"
                                    :class="book.status === 'Publié' ? 'bg-emerald-500' : 'bg-amber-400'"></span>
                                {{ book.status }}
                            </span>

                            <!-- Format badge -->
                            <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded-full"
                                style="background:#EDE9FE; color:#6D28D9">
                                <i class="fas fa-video mr-1 text-[8px]"></i>Vidéo
                            </span>
                        </div>

                        <!-- Body -->
                        <div class="p-4">
                            <p
                                class="text-[13px] font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors mb-1">
                                {{ book.title }}
                            </p>
                            <p class="text-[11px] text-gray-400 mb-3">{{ book.category }}</p>

                            <!-- Meta row -->
                            <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users text-[9px] text-gray-400"></i>
                                    {{ book.students }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ml-auto"
                                    :class="levelBadge(book.level).class">
                                    {{ book.level }}
                                </span>
                            </div>

                            <!-- Progress bar -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-gray-400 font-medium">Complétion</span>
                                    <span class="text-[10px] font-bold text-gray-700">{{ book.progress }}%</span>
                                </div>
                                <div class="h-1.5 bg-indigo-50 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700"
                                        :style="`width:${book.progress}%; background:${book.color}`"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 border-t border-indigo-50 flex items-center justify-between">
                            <span class="text-[13px] font-extrabold" :style="`color:${book.color}`">
                                {{ book.price ? `${book.price} €` : 'Gratuit' }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <button @click.stop="confirmDelete(book)"
                                    class="w-7 h-7 rounded-lg border border-gray-200 bg-gray-50 hover:border-red-200 hover:bg-red-50 flex items-center justify-center text-[11px] text-gray-500 hover:text-red-500 transition-all cursor-pointer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── LIST VIEW ── -->
                <div v-else class="bg-white rounded-2xl border border-indigo-50 overflow-hidden">
                    <div
                        class="grid grid-cols-12 gap-2 px-5 py-3 bg-indigo-50/40 text-[10px] font-bold uppercase tracking-widest text-gray-400 border-b border-indigo-50">
                        <span class="col-span-5">Titre du cours</span>
                        <span class="col-span-2 text-center">Catégorie</span>
                        <span class="col-span-1 text-center">Niveau</span>
                        <span class="col-span-1 text-center">Durée</span>
                        <span class="col-span-1 text-center">Prix</span>
                        <span class="col-span-1 text-center">Statut</span>
                        <span class="col-span-1 text-center">Actions</span>
                    </div>

                    <div class="divide-y divide-indigo-50/60">
                        <div v-for="book in filteredBooks" :key="book.id"
                            class="grid grid-cols-12 gap-2 px-5 py-3.5 items-center hover:bg-indigo-50/30 transition-colors cursor-pointer group"
                            @click="openDetail(book)">
                            <!-- Title + play chip -->
                            <div class="col-span-5 flex items-center gap-3 min-w-0">
                                <span
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-[12px] shrink-0 relative"
                                    :style="`background:${book.color}20; color:${book.color}`">
                                    <i class="fas fa-play ml-0.5"></i>
                                </span>
                                <div class="min-w-0">
                                    <p
                                        class="text-[12.5px] font-semibold text-gray-800 truncate group-hover:text-indigo-600 transition-colors">
                                        {{ book.title }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] text-gray-400">{{ book.students }} étudiants</span>
                                        <div class="flex-1 max-w-20 h-1 bg-indigo-50 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full"
                                                :style="`width:${book.progress}%; background:${book.color}`"></div>
                                        </div>
                                        <span class="text-[10px] text-gray-400">{{ book.progress }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 text-center">
                                <span class="text-[11px] text-gray-600 font-medium">{{ book.category }}</span>
                            </div>

                            <div class="col-span-1 flex justify-center">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                    :class="levelBadge(book.level).class">{{ book.level }}</span>
                            </div>

                            <div class="col-span-1 text-center">
                                <span class="text-[12px] font-semibold text-gray-700">{{ book.duration }}</span>
                            </div>

                            <div class="col-span-1 text-center">
                                <span class="text-[12px] font-bold" :style="`color:${book.color}`">
                                    {{ book.price ? `${book.price} €` : 'Gratuit' }}
                                </span>
                            </div>

                            <div class="col-span-1 flex justify-center">
                                <span
                                    class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full"
                                    :class="book.status === 'Publié' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-500'">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                        :class="book.status === 'Publié' ? 'bg-emerald-500' : 'bg-amber-400'"></span>
                                    {{ book.status }}
                                </span>
                            </div>

                            <div class="col-span-1 flex justify-center gap-1.5" @click.stop>
                                <button @click="confirmDelete(book)"
                                    class="w-7 h-7 rounded-lg border border-gray-200 bg-gray-50 hover:border-red-200 hover:bg-red-50 flex items-center justify-center text-[11px] text-gray-500 hover:text-red-500 transition-all cursor-pointer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        <!-- ── DETAIL DRAWER ── -->
        <Transition name="drawer">
            <div v-if="selectedBook" class="fixed inset-0 z-50 flex justify-end">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]" @click="selectedBook = null"></div>

                <div class="relative w-full max-w-lg bg-[#0F1021] h-full overflow-y-auto shadow-2xl flex flex-col z-10">
                    <!-- Header -->
                    <div class="px-6 py-5 flex items-center justify-between border-b border-white/5">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center text-[16px]"
                                :style="`background:${selectedBook.color}30; color:${selectedBook.color}`">
                                <i class="fas fa-film"></i>
                            </span>
                            <div>
                                <p class="text-[13px] font-bold text-white">Détail du cours vidéo</p>
                                <p class="text-[11px] text-indigo-300">{{ selectedBook.category }}</p>
                            </div>
                        </div>
                        <button @click="selectedBook = null"
                            class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-white/60 hover:text-white transition-colors cursor-pointer text-[11px]">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- ── VIDEO PLAYER ── -->
                    <div class="relative w-full bg-black" style="aspect-ratio:16/9">
                        <video v-if="selectedBook.file" :src="selectedBook.file" controls controlsList="nodownload"
                            class="w-full h-full object-contain" :poster="selectedBook.image || undefined">
                            Votre navigateur ne supporte pas la lecture vidéo.
                        </video>
                        <!-- Placeholder if no file -->
                        <div v-else class="w-full h-full flex flex-col items-center justify-center gap-3"
                            style="background: linear-gradient(135deg,#1a1a3e 0%,#0f0f22 100%)">
                            <i class="fas fa-video-slash text-[32px] text-white/20"></i>
                            <p class="text-[12px] text-white/30 font-medium">Aucun fichier vidéo disponible</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex flex-col gap-5 flex-1">
                        <div>
                            <h2 class="text-[18px] font-extrabold text-white leading-snug mb-1">
                                {{ selectedBook.title }}
                            </h2>
                            <p class="text-[12.5px] text-indigo-200/70 leading-relaxed">
                                {{ selectedBook.description || 'Aucune description disponible.' }}
                            </p>
                        </div>

                        <!-- Stats grid -->
                        <div class="grid grid-cols-2 gap-3">
                            <div v-for="stat in bookStats(selectedBook)" :key="stat.label"
                                class="rounded-xl p-3 flex flex-col gap-1.5"
                                style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.06)">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-300/60">{{
                                    stat.label }}</span>
                                <div class="flex items-center gap-2">
                                    <i :class="stat.icon + ' text-[11px]'" :style="`color:${selectedBook.color}`"></i>
                                    <span class="text-[14px] font-extrabold text-white">{{ stat.value }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11px] font-bold text-indigo-200/70">Taux de complétion</span>
                                <span class="text-[11px] font-extrabold" :style="`color:${selectedBook.color}`">
                                    {{ selectedBook.progress }}%
                                </span>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden" style="background:rgba(255,255,255,0.08)">
                                <div class="h-full rounded-full transition-all duration-700"
                                    :style="`width:${selectedBook.progress}%; background:${selectedBook.color}`"></div>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full"
                                :class="selectedBook.status === 'Publié' ? 'bg-emerald-500/15 text-emerald-400' : 'bg-amber-500/15 text-amber-400'">
                                <span class="w-2 h-2 rounded-full"
                                    :class="selectedBook.status === 'Publié' ? 'bg-emerald-500' : 'bg-amber-400'"></span>
                                {{ selectedBook.status }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full"
                                style="background:rgba(139,92,246,0.15); color:#a78bfa">
                                <i class="fas fa-video text-[9px]"></i>Vidéo
                            </span>
                            <span class="text-[11px] font-bold px-3 py-1.5 rounded-full"
                                :class="levelBadge(selectedBook.level).class">{{ selectedBook.level }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- ── DELETE CONFIRM MODAL ── -->
        <Transition name="fade">
            <div v-if="bookToDelete" class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]" @click="bookToDelete = null"></div>
                <div
                    class="relative bg-white rounded-2xl border border-gray-100 shadow-2xl p-6 w-full max-w-sm mx-4 z-10">
                    <span
                        class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 text-[18px] mx-auto mb-4">
                        <i class="fas fa-triangle-exclamation"></i>
                    </span>
                    <h3 class="text-[16px] font-extrabold text-gray-900 text-center mb-2">Supprimer le cours ?</h3>
                    <p class="text-[12.5px] text-gray-500 text-center mb-6">
                        « <strong class="text-gray-800">{{ bookToDelete.title }}</strong> » sera définitivement
                        supprimé. Cette action est irréversible.
                    </p>
                    <div class="flex items-center gap-3">
                        <button @click="bookToDelete = null"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-[13px] font-bold text-gray-700 hover:bg-gray-100 transition-all cursor-pointer">
                            Annuler
                        </button>
                        <Link :href="teacherCourseVideoDelete(bookToDelete.id)" :method="'delete'" @click="bookToDelete = null"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-[13px] font-bold transition-all cursor-pointer border-none text-center no-underline block">
                            Supprimer
                        </Link>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import Navbar from '@/Components/Teacher/Layout/Navbar.vue'
import Sidebar from '@/Components/Teacher/Layout/Sidebar.vue'
import {teacherCoursesCreate, teacherCourseVideoDelete } from '@/routes'

/* ── Auth ── */
interface User { name: string; email: string }
const page = usePage()
const user = page.props.auth.user as User

/* ── Types ── */
interface Book {
    id: number
    title: string
    description?: string
    category: string
    duration: string
    price?: number | null
    image?: string | null
    format: 'pdf' | 'video' | 'audio'
    progress: number
    icon?: string
    color: string
    level: string
    file: string
    students: number | null
    status: string
}

const props = defineProps<{
    books: {
        data: Book[]
    }
}>()

/* ── State ── */
const view = ref<'grid' | 'list'>('grid')
const search = ref('')
const filterCategory = ref('')
const filterLevel = ref('')
const selectedBook = ref<Book | null>(null)
const bookToDelete = ref<Book | null>(null)

const bookList = ref<Book[]>(props.books.data)

/* ── Derived data ── */
const allCategories = computed(() => [...new Set(bookList.value.map(b => b.category))])
const allLevels = computed(() => [...new Set(bookList.value.map(b => b.level))])

const filteredBooks = computed(() => {
    return props.books.data.filter(b => {
        const q = search.value.toLowerCase()
        const matchSearch = !q || b.title.toLowerCase().includes(q) || b.category.toLowerCase().includes(q)
        const matchCat = !filterCategory.value || b.category === filterCategory.value
        const matchLevel = !filterLevel.value || b.level === filterLevel.value

        return matchSearch && matchCat && matchLevel
    })
})

/* ── Helpers ── */
function levelBadge(level: string) {
    const map: Record<string, { class: string }> = {
        'Débutant': { class: 'bg-emerald-50 text-emerald-600' },
        'Intermédiaire': { class: 'bg-blue-50 text-blue-600' },
        'Avancé': { class: 'bg-purple-50 text-purple-600' },
        'Expert': { class: 'bg-red-50 text-red-600' },
    }

    return map[level] ?? { class: 'bg-gray-100 text-gray-600' }
}

function bookStats(book: Book) {
    return [
        { label: 'Étudiants', icon: 'fas fa-users', value: book.students?.toString() },
        { label: 'Durée', icon: 'fas fa-clock', value: book.duration },
        { label: 'Prix', icon: 'fas fa-tag', value: book.price ? `${book.price} €` : 'Gratuit' },
        { label: 'Progression', icon: 'fas fa-chart-pie', value: `${book.progress}%` },
    ]
}

/* ── Actions ── */
function openDetail(book: Book) {
    selectedBook.value = book
}

function confirmDelete(book: Book) {
    bookToDelete.value = book
    selectedBook.value = null
}
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-indigo-100::-webkit-scrollbar-thumb {
    background: #C7D2FE;
    border-radius: 99px;
}

.drawer-enter-active,
.drawer-leave-active {
    transition: opacity 0.25s ease
}

.drawer-enter-active .relative,
.drawer-leave-active .relative {
    transition: transform 0.3s cubic-bezier(0.32, 0.72, 0, 1)
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

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0
}
</style>
