<script lang="ts" setup>
import { computed, ref } from 'vue'

const searchQuery = ref('')
const activeSection = ref('dashboard')

const navItems = [
    { key: 'dashboard', label: 'Tableau de bord', icon: 'fas fa-th-large', badge: null },
    { key: 'courses', label: 'Mes cours', icon: 'fas fa-book-open', badge: '12' },
    { key: 'certificates', label: 'Certificats', icon: 'fas fa-award', badge: '4' },
    { key: 'calendar', label: 'Calendrier', icon: 'fas fa-calendar-alt', badge: null },
    { key: 'messages', label: 'Messages', icon: 'fas fa-comment-dots', badge: '3' },
]

const currentPageLabel = computed(() =>
    navItems.find(n => n.key === activeSection.value)?.label ?? 'Tableau de bord'
)

interface User {
    user: {
        name: string,
        email: string,
    }
}

defineProps<User>()
</script>

<template>
    <!-- ── TOP NAVBAR ── -->
    <header class="h-18 bg-dark-50  px-7 flex items-center justify-between shrink-0">

        <!-- LEFT -->
        <div class="flex items-center gap-3 min-w-0">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-[13px]">

                <div class="w-8 h-8 rounded-xl bg-brand/15 text-brand-dark flex items-center justify-center">
                    <i class="fas fa-home text-[12px]"></i>
                </div>

                <span class="text-dark-300 font-medium">/</span>

                <span class="font-semibold text-dark truncate">
                    {{ currentPageLabel }}
                </span>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-3">

            <!-- Search -->
            <div
                class="hidden md:flex items-center h-11 w-70 bg-dark-50 rounded-2xl px-4 transition-all duration-200 focus-within:border-brand focus-within:bg-white">

                <i class="fas fa-search text-[13px] text-dark-300"></i>

                <input type="text" v-model="searchQuery" placeholder="Rechercher un cours..."
                    class="flex-1 bg-transparent border-none outline-none text-[13px] text-dark placeholder:text-dark-300 px-3" />
            </div>

            <!-- Notifications -->
            <button class="relative w-11 h-11 rounded-2xl bg-white
                       hover:bg-dark-50 text-dark-400 hover:text-dark
                       flex items-center justify-center transition-colors duration-200">

                <i class="fas fa-bell text-[14px]"></i>

                <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-red-500 border-2 border-white">
                </span>
            </button>

            <!-- Messages -->
            <button class="w-11 h-11 rounded-2xl bg-white
                       hover:bg-dark-50 text-dark-400 hover:text-dark
                       flex items-center justify-center transition-colors duration-200">

                <i class="fas fa-envelope text-[14px]"></i>
            </button>

            <!-- Profile -->
            <button class="flex items-center gap-3 pl-2 pr-3 h-11 rounded-2xl
                       hover:bg-dark-50 transition-colors duration-200">

                <!-- Avatar -->
                <div class="w-10 h-10 rounded-xl bg-linear-to-br from-brand to-amber-400
                           flex items-center justify-center text-dark font-bold text-[13px] shadow-sm">

                    {{ user.name[0].toUpperCase() }}
                </div>

                <!-- User -->
                <div class="hidden lg:block text-left leading-tight">

                    <p class="text-[13px] font-bold text-dark">
                        {{ user.name }}
                    </p>

                    <p class="text-[11px] text-dark-400">
                        Étudiant
                    </p>
                </div>

                <!-- Chevron -->
                <i class="fas fa-chevron-down text-[11px] text-dark-300 hidden lg:block"></i>
            </button>

        </div>
    </header>
</template>
