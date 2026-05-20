<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { logout, studentAudios, studentCourses, studentDashboard, studentVideos } from '@/routes'

const sidebarCollapsed = ref(false)
const activeSection = ref('dashboard')

const navItems = [
    { key: 'dashboard', label: 'Tableau de bord', icon: 'fas fa-th-large', badge: null, link: studentDashboard() },
    { key: 'courses', label: 'Mes cours PDF', icon: 'fas fa-book-open', badge: '12', link: studentCourses() },
    { key: 'videos', label: 'Vidéos', icon: 'fas fa-video', badge: '8', link: studentVideos() },
    { key: 'audios', label: 'Audios', icon: 'fas fa-headphones', badge: '5', link: studentAudios() },
]

interface User {
    user: {
        name: string,
        email: string,
    }
}

defineProps<User>()
</script>

<template>
    <FlashMessage />

    <aside :class="[
        'h-screen flex flex-col bg-[#0F1117] border-r border-white/10 overflow-hidden relative shrink-0 transition-all duration-300',
        sidebarCollapsed ? 'w-20' : 'w-64'
    ]">

        <!-- Ambient Glow -->
        <div
            class="pointer-events-none absolute -top-16 -left-8 w-48 h-48 rounded-full opacity-20 bg-linear-to-br from-yellow-400 to-transparent">
        </div>

        <!-- ───────── HEADER ───────── -->
        <div class="flex items-center justify-between px-5 py-6 border-b border-white/10">

            <!-- LOGO -->
            <div class="flex items-center gap-3 min-w-0">

                <div
                    class="w-12 h-12 rounded-2xl bg-linear-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg shadow-yellow-500/10 shrink-0">

                    <i class="fas fa-graduation-cap text-white text-[15px]"></i>
                </div>

                <div v-if="!sidebarCollapsed">
                    <p class="text-white font-bold text-[15px] tracking-wide">
                        Educ-Learn
                    </p>

                    <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-0.5">
                        Étudiant
                    </p>
                </div>
            </div>

            <!-- Collapse Button -->
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="w-9 h-9 rounded-xl flex items-center justify-center text-white/60 hover:text-white hover:bg-white/5 transition-all duration-200 shrink-0">

                <i :class="sidebarCollapsed
                    ? 'fas fa-chevron-right text-[11px]'
                    : 'fas fa-chevron-left text-[11px]'"></i>
            </button>
        </div>

        <!-- ───────── USER CARD ───────── -->
        <div :class="[
            'border-b border-white/10',
            sidebarCollapsed
                ? 'py-4 flex justify-center'
                : 'px-4 py-4'
        ]">

            <div :class="[
                'flex items-center',
                sidebarCollapsed ? 'justify-center' : 'gap-3'
            ]">

                <!-- Avatar -->
                <div
                    class="w-11 h-11 rounded-full flex items-center justify-center text-[12px] font-bold text-black bg-linear-to-br from-yellow-400 to-orange-500 shadow-lg shadow-yellow-500/20 shrink-0">

                    {{ user.name[0].toUpperCase() }}
                </div>

                <!-- Infos -->
                <div v-if="!sidebarCollapsed" class="min-w-0">

                    <p class="text-white text-[13px] font-semibold truncate">
                        {{ user.name }}
                    </p>

                    <p class="text-white/50 text-[11px] truncate">
                        {{ user.email }}
                    </p>
                </div>
            </div>
        </div>

        <!-- ───────── NAVIGATION ───────── -->
        <nav class="flex-1 overflow-y-auto px-3 py-5 scrollbar-none">

            <!-- SECTION -->
            <p v-if="!sidebarCollapsed" class="sidebar-section">
                Principal
            </p>

            <!-- NAV ITEMS -->
            <Link v-for="item in navItems" :key="item.key" :href="item.link" @click="activeSection = item.key"
                :title="sidebarCollapsed ? item.label : ''" :class="[
                    'group',
                    activeSection === item.key
                        ? 'sidebar-link-active'
                        : 'sidebar-link'
                ]">

                <!-- ICON -->
                <span :class="[
                    activeSection === item.key
                        ? 'sidebar-icon-active'
                        : 'sidebar-icon'
                ]">

                    <i :class="[item.icon, 'text-[13px]']"></i>
                </span>

                <!-- LABEL -->
                <span v-if="!sidebarCollapsed" class="text-[13px] font-medium truncate">
                    {{ item.label }}
                </span>

                <!-- BADGE -->
                <span v-if="!sidebarCollapsed && item.badge" :class="[
                    activeSection === item.key
                        ? 'sidebar-badge-active'
                        : 'sidebar-badge'
                ]">

                    {{ item.badge }}
                </span>
            </Link>
        </nav>

        <!-- ───────── FOOTER ───────── -->
        <div class="border-t border-white/10 p-4 bg-white/2">

            <!-- Progression -->
            <div v-if="!sidebarCollapsed"
                class="mb-3 rounded-2xl bg-linear-to-br from-yellow-500 to-orange-500 p-4 shadow-lg shadow-yellow-500/10">

                <div class="flex items-center justify-between mb-2">

                    <p class="text-[12px] font-semibold text-white">
                        Progression globale
                    </p>

                    <i class="fas fa-chart-line text-white text-[13px]"></i>
                </div>

                <!-- BAR -->
                <div class="h-2 rounded-full bg-white/20 overflow-hidden">

                    <div class="h-full rounded-full bg-white transition-all duration-500" style="width: 68%">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">

                    <p class="text-[11px] text-white/80">
                        Objectif annuel
                    </p>

                    <p class="text-[11px] font-bold text-white">
                        68%
                    </p>
                </div>
            </div>

            <!-- Logout -->
            <Link :href="logout()"
                class="w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium text-red-300 hover:text-red-200 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition-all duration-200 group">

                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/5 text-red-300 group-hover:bg-red-500/15 transition-all duration-200 shrink-0">

                    <i class="fas fa-right-from-bracket"></i>
                </span>

                <span v-if="!sidebarCollapsed">
                    Déconnexion
                </span>
            </Link>
        </div>
    </aside>
</template>

<style scoped>
.scrollbar-none::-webkit-scrollbar {
    display: none;
}

.scrollbar-none {
    scrollbar-width: none;
}

/* ───────── Sections ───────── */

.sidebar-section {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: rgba(255, 255, 255, 0.3);
    padding: 1.25rem 0.875rem 0.5rem;
}

/* ───────── Default Link ───────── */

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0.875rem;
    border-radius: 0.75rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.25rem;
    transition: all 0.2s ease;
}

.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.05);
    color: white;
}

/* ───────── Active Link ───────── */

.sidebar-link-active {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0.875rem;
    border-radius: 0.75rem;
    margin-bottom: 0.25rem;
    background: linear-gradient(135deg, #F59E0B, #EA580C);
    color: white;
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
}

/* ───────── Icons ───────── */

.sidebar-icon {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background-color: rgba(255, 255, 255, 0.05);
    color: rgba(255, 255, 255, 0.8);
    transition: all 0.2s ease;
}

.sidebar-link:hover .sidebar-icon {
    background-color: rgba(245, 158, 11, 0.1);
    color: #fbbf24;
}

.sidebar-icon-active {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
}

/* ───────── Badges ───────── */

.sidebar-badge {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    background-color: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.7);
    border-radius: 0.375rem;
    padding: 0.125rem 0.5rem;
}

.sidebar-badge-active {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    background-color: rgba(255, 255, 255, 0.18);
    color: white;
    border-radius: 0.375rem;
    padding: 0.125rem 0.5rem;
}
</style>
