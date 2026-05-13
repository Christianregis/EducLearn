<script setup lang="ts">
import { ref } from 'vue'

const sidebarCollapsed = ref(false)
const activeSection = ref('dashboard')

const navItems = [
    { key: 'dashboard', label: 'Tableau de bord', icon: 'fas fa-th-large', badge: null },
    { key: 'courses', label: 'Mes cours', icon: 'fas fa-book-open', badge: '12' },
    { key: 'videos', label: 'Vidéos', icon: 'fas fa-video', badge: '8' },
]
</script>

<template>
    <!-- ── SIDEBAR ── -->
    <aside :class="[
        'bg-yellow-500  text-white border-r border flex flex-col shrink-0 overflow-hidden transition-all duration-300',
        sidebarCollapsed ? 'w-18.5' : 'w-65'
    ]">

        <!-- HEADER -->
        <div class="h-18 px-4 flex items-center justify-between">

            <!-- LOGO -->
            <div class="flex items-center gap-3 min-w-0">

                <div
                    class="w-10 h-10 rounded-2xl bg-brand flex items-center justify-center text-white text-[15px] shadow-sm shrink-0">

                    <i class="fas fa-graduation-cap"></i>
                </div>

                <div v-if="!sidebarCollapsed" class="min-w-0">

                    <h1 class="text-[16px] font-extrabold text-white tracking-[-0.03em] truncate">
                        Educ<span class="text-brand-white">-Learn</span>
                    </h1>

                    <p class="text-[11px] text-white truncate">
                        Learning Platform
                    </p>
                </div>
            </div>

            <!-- COLLAPSE BUTTON -->
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="w-8 h-8 rounded-xl flex items-center justify-center
                       text-white hover:bg-dark-50 hover:text-dark transition-all duration-200 shrink-0">

                <i :class="sidebarCollapsed
                    ? 'fas fa-chevron-right text-[11px]'
                    : 'fas fa-chevron-left text-[11px]'"></i>
            </button>
        </div>

        <!-- USER -->
        <div :class="[
            'border-b border-dark-100',
            sidebarCollapsed
                ? 'flex justify-center py-4'
                : 'px-4 py-4 flex items-center gap-3'
        ]">

            <!-- AVATAR -->
            <div :class="[
                'rounded-2xl bg-brand flex items-center justify-center font-bold text-white shrink-0',
                sidebarCollapsed
                    ? 'w-10 h-10 text-[11px]'
                    : 'w-11 h-11 text-[12px]'
            ]">

                AD
            </div>

            <!-- INFOS -->
            <div v-if="!sidebarCollapsed" class="min-w-0 flex-1">

                <p class="text-[13px] font-bold text-white truncate">
                    Aminata Diallo
                </p>

                <div class="flex items-center gap-2 mt-1">

                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-600">

                        Étudiant
                    </span>

                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto py-4 scrollbar-thin scrollbar-thumb-dark-200">

            <!-- SECTION -->
            <div class="mb-5">

                <p v-if="!sidebarCollapsed"
                    class="px-5 mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-dark-400">

                    Principal
                </p>

                <ul class="space-y-1.5 px-3">

                    <li v-for="item in navItems" :key="item.key" @click="activeSection = item.key"
                        :title="sidebarCollapsed ? item.label : ''" :class="[
                            'group relative flex items-center rounded-2xl cursor-pointer transition-all duration-200',
                            sidebarCollapsed
                                ? 'justify-center h-12'
                                : 'gap-3 px-4 h-12',
                            activeSection === item.key
                                ? 'bg-brand text-dark shadow-sm'
                                : 'text-dark-400 hover:bg-dark-50 hover:text-dark'
                        ]">

                        <!-- ICON -->
                        <i :class="[item.icon, 'text-[14px] w-4 text-center shrink-0']"></i>

                        <!-- LABEL -->
                        <span v-if="!sidebarCollapsed" class="text-[13px] font-semibold truncate">
                            {{ item.label }}
                        </span>

                        <!-- BADGE -->
                        <span v-if="!sidebarCollapsed && item.badge" :class="[
                            'ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full',
                            activeSection === item.key
                                ? 'bg-dark text-white'
                                : 'bg-dark-100 text-dark-500'
                        ]">

                            {{ item.badge }}
                        </span>
                    </li>

                </ul>
            </div>

            <!-- ACCOUNT -->
            <div>

                <p v-if="!sidebarCollapsed"
                    class="px-5 mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-dark-400">

                    Compte
                </p>

                <ul class="space-y-1.5 px-3">

                    <!-- SETTINGS -->
                    <li :class="[
                        'flex items-center rounded-2xl cursor-pointer transition-all duration-200',
                        sidebarCollapsed
                            ? 'justify-center h-12'
                            : 'gap-3 px-4 h-12',
                        'text-dark-400 hover:bg-dark-50 hover:text-dark'
                    ]">

                        <i class="fas fa-user text-[14px] w-4 text-center shrink-0"></i>

                        <span v-if="!sidebarCollapsed" class="text-[13px] font-semibold">
                            Profil
                        </span>
                    </li>

                    <!-- HELP -->
                    <li :class="[
                        'flex items-center rounded-2xl cursor-pointer transition-all duration-200',
                        sidebarCollapsed
                            ? 'justify-center h-12'
                            : 'gap-3 px-4 h-12',
                        'text-dark-400 hover:bg-dark-50 hover:text-dark'
                    ]">

                        <i class="fas fa-question-circle text-[14px] w-4 text-center shrink-0"></i>

                        <span v-if="!sidebarCollapsed" class="text-[13px] font-semibold">
                            Aide
                        </span>
                    </li>
                    <li :class="[
                        'flex items-center rounded-2xl cursor-pointer transition-all duration-200',
                        sidebarCollapsed
                            ? 'justify-center h-12'
                            : 'gap-3 px-4 h-12',
                        'text-dark-400 hover:bg-dark-50 hover:text-dark'
                    ]">

                        <i class="fas fa-sign-out-alt text-[14px] w-4 text-center shrink-0"></i>

                        <span v-if="!sidebarCollapsed" class="text-[13px] font-semibold">
                            Se déconnecter
                        </span>
                    </li>
                </ul>
            </div>

        </nav>

        <!-- FOOTER -->
        <div v-if="!sidebarCollapsed" class="p-4 border-t border-dark-100">

            <div class="bg-linear-to-br from-amber-700 to-amber-500 border border-amber-100 rounded-2xl p-4">

                <div class="flex items-center justify-between mb-2">

                    <p class="text-[12px] font-semibold text-white">
                        Progression globale
                    </p>

                    <i class="fas fa-chart-line text-white text-[13px]"></i>
                </div>

                <!-- BAR -->
                <div class="h-2 rounded-full bg-white overflow-hidden">

                    <div class="h-full rounded-full text-amber-500 transition-all duration-500" style="width: 68%">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">

                    <p class="text-[11px] text-white">
                        Objectif annuel
                    </p>

                    <p class="text-[11px] font-bold text-white">
                        68%
                    </p>
                </div>
            </div>
        </div>

    </aside>
</template>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
    border-radius: 999px;
}
</style>
