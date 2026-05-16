<template>
    <header
        class="h-[64px] shrink-0 flex items-center justify-between px-7 bg-white border-b border-gray-100/80 relative z-10">

        <!-- ── LEFT: Page title + breadcrumb ── -->
        <div class="flex items-center gap-3">
            <!-- Mobile menu toggle (si besoin) -->
            <button
                class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors mr-1"
                @click="$emit('toggle-sidebar')">
                <i class="fas fa-bars text-[13px]"></i>
            </button>

            <div class="hidden sm:flex items-center gap-2 text-[12px] text-gray-400 font-medium">
                <span class="text-gray-300">Educ-Learn</span>
                <i class="fas fa-chevron-right text-[9px] text-gray-200"></i>
                <span class="text-amber-500 font-semibold">Tableau de bord</span>
            </div>
        </div>

        <!-- ── CENTER: Search ── -->
        <div class="flex-1 max-w-xs mx-6 hidden md:block">
            <div class="relative">
                <i
                    class="fas fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-[11px]"></i>
                <input v-model="searchQuery" type="text" placeholder="Rechercher un cours, étudiant…"
                    class="w-full bg-gray-50 border border-gray-100 text-[12.5px] text-gray-700 placeholder-gray-300 pl-9 pr-4 py-2 rounded-xl outline-none focus:border-amber-300 focus:bg-white focus:ring-2 focus:ring-amber-100 transition-all" />
                <kbd
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-300 bg-gray-100 rounded px-1 py-0.5 font-mono hidden lg:block">⌘K</kbd>
            </div>
        </div>

        <!-- ── RIGHT: Actions ── -->
        <div class="flex items-center gap-2">

            <!-- Quick add button -->
            <Link :href="teacherCoursesCreate()"
                class="hidden sm:inline-flex items-center gap-2 text-[12px] font-bold px-4 py-2 rounded-[10px] transition-all duration-200 border-none cursor-pointer"
                style="background: linear-gradient(135deg, #F4B400 0%, #E09000 100%); color: #0F1117; box-shadow: 0 2px 8px rgba(244,180,0,0.30)"
                @click="$emit('new-course')">
                <i class="fas fa-plus text-[10px]"></i>
                Nouveau cours
            </Link>

            <!-- Notifications -->
            <button
                class="relative w-9 h-9 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-all border border-gray-100"
                @click="toggleNotifications">
                <i class="fas fa-bell text-[13px]"></i>
                <span v-if="unreadCount > 0"
                    class="absolute top-1.5 right-1.5 w-[7px] h-[7px] rounded-full bg-amber-400 border-2 border-white"></span>
            </button>

            <!-- Notification dropdown -->
            <Transition name="dropdown">
                <div v-if="showNotifications"
                    class="absolute top-[68px] right-16 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-50">
                        <p class="text-[13px] font-bold text-gray-800">Notifications</p>
                        <span class="text-[10px] bg-amber-100 text-amber-600 font-bold rounded-full px-2 py-0.5">{{
                            unreadCount }} nouvelles</span>
                    </div>
                    <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                        <div v-for="notif in notifications" :key="notif.id"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50/70 cursor-pointer transition-colors">
                            <span
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] shrink-0 mt-0.5"
                                :class="notif.iconClass">
                                <i :class="notif.icon"></i>
                            </span>
                            <div>
                                <p class="text-[12px] font-semibold text-gray-700">{{ notif.title }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ notif.time }}</p>
                            </div>
                            <span v-if="!notif.read"
                                class="ml-auto w-2 h-2 rounded-full bg-amber-400 shrink-0 mt-2"></span>
                        </div>
                    </div>
                    <div class="px-4 py-2.5 border-t border-gray-50">
                        <button
                            class="w-full text-center text-[11px] font-semibold text-amber-500 hover:text-amber-600 transition-colors">
                            Voir tout
                        </button>
                    </div>
                </div>
            </Transition>

            <!-- Overlay notifications -->
            <div v-if="showNotifications" class="fixed inset-0 z-40" @click="showNotifications = false"></div>

            <!-- Avatar -->
            <div class="relative">
                <button
                    class="flex items-center gap-2.5 pl-2.5 pr-3 py-1.5 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-all group"
                    @click="toggleUserMenu">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-[#0F1117] shrink-0"
                        style="background: linear-gradient(135deg, #F4B400, #E09000)">
                        {{ userInitials }}
                    </div>
                    <span
                        class="hidden lg:block text-[12.5px] font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">
                        {{ user?.name ?? 'Enseignant' }}
                    </span>
                    <i class="fas fa-chevron-down text-[9px] text-gray-300 group-hover:text-gray-400 transition-all"
                        :class="{ 'rotate-180': showUserMenu }"></i>
                </button>

                <!-- User menu -->
                <Transition name="dropdown">
                    <div v-if="showUserMenu"
                        class="absolute top-12 right-0 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden py-1.5">
                        <div class="px-4 py-2.5 border-b border-gray-50 mb-1">
                            <p class="text-[12px] font-bold text-gray-800">{{ user?.name }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ user?.email }}</p>
                        </div>
                        <button
                            class="w-full flex items-center gap-2.5 px-4 py-2 text-[12px] text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <i class="fas fa-user-circle text-gray-300 w-4 text-center"></i> Mon profil
                        </button>
                        <button
                            class="w-full flex items-center gap-2.5 px-4 py-2 text-[12px] text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <i class="fas fa-gear text-gray-300 w-4 text-center"></i> Paramètres
                        </button>
                        <div class="border-t border-gray-50 mt-1 pt-1">
                            <Link
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-[12px] text-red-400 hover:bg-red-50 transition-colors"
                                :href="logout()">
                                <i class="fas fa-right-from-bracket w-4 text-center"></i> Déconnexion
                            </Link>
                        </div>
                    </div>
                </Transition>

                <div v-if="showUserMenu" class="fixed inset-0 z-40" @click="showUserMenu = false"></div>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue'
import { logout, teacherCoursesCreate } from '@/routes';


/* ── Types ── */
interface User { name: string; email: string }
interface Notification {
    id: number
    title: string
    time: string
    icon: string
    iconClass: string
    read: boolean
}

/* ── Props / Emits ── */
const props = defineProps<{ user?: User }>()
defineEmits<{
    (e: 'toggle-sidebar'): void
    (e: 'new-course'): void
}>()

/* ── State ── */
const searchQuery = ref('')
const showNotifications = ref(false)
const showUserMenu = ref(false)


/* ── Computed ── */
const userInitials = computed(() => {
    const name = props.user?.name ?? ''

    return name.split(' ').slice(0, 2).map((n) => n[0]).join('').toUpperCase()
})


const notifications = ref<Notification[]>([
    { id: 1, title: '3 nouveaux étudiants inscrits', time: 'il y a 12 min', icon: 'fas fa-user-plus', iconClass: 'bg-emerald-50 text-emerald-500', read: false },
    { id: 2, title: 'Commentaire sur votre PDF "React"', time: 'il y a 1h', icon: 'fas fa-comment-dots', iconClass: 'bg-blue-50 text-blue-500', read: false },
    { id: 3, title: 'Rapport hebdomadaire disponible', time: 'hier', icon: 'fas fa-chart-bar', iconClass: 'bg-amber-50 text-amber-500', read: true },
])

const unreadCount = computed(() => notifications.value.filter((n) => !n.read).length)

/* ── Actions ── */
function toggleNotifications() {
    showNotifications.value = !showNotifications.value
    showUserMenu.value = false
}
function toggleUserMenu() {
    showUserMenu.value = !showUserMenu.value
    showNotifications.value = false
}

</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
    transition: opacity 0.15s ease, transform 0.15s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
</style>
