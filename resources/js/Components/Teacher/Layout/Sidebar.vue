<template>
    <aside class="w-64 shrink-0 h-screen flex flex-col bg-[#0F1117] border-r border-white/10 overflow-hidden relative">

        <!-- Ambient glow -->
        <div
            class="pointer-events-none absolute -top-16 -left-8 w-48 h-48 rounded-full opacity-20 bg-linear-to-br from-yellow-400 to-transparent">
        </div>

        <!-- ───────── LOGO ───────── -->
        <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
            <div
                class="w-12 h-12 rounded-2xl bg-linear-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg shadow-yellow-500/10">
                <div class="w-5 h-5 bg-white rounded-full"></div>
            </div>

            <div>
                <p class="text-white font-bold text-[15px] tracking-wide">
                    Educ-Learn
                </p>
                <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-0.5">
                    Enseignant
                </p>
            </div>
        </div>

        <!-- ───────── NAVIGATION ───────── -->
        <nav class="flex-1 overflow-y-auto px-3 py-5 scrollbar-none">

            <!-- Dashboard -->
            <Link :href="teacherDashboard()"
                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl text-white hover:bg-white/5 transition-all duration-200 mb-1">

                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/5 text-white group-hover:bg-yellow-400/10 group-hover:text-yellow-300 transition-all duration-200">
                    <i class="fas fa-chart-line text-[13px]"></i>
                </span>

                <span class="text-[13px] font-medium">
                    Tableau de bord
                </span>
            </Link>

            <!-- SECTION -->
            <p class="sidebar-section">
                Cours PDF
            </p>

            <!-- Ajouter PDF -->
            <Link :href="teacherCoursesCreate()" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-file-circle-plus"></i>
                </span>

                <span>Ajouter un PDF</span>
            </Link>

            <!-- Voir PDF -->
            <Link :href="teacherCourses()" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-file-pdf"></i>
                </span>

                <span>Voir les PDFs</span>

                <span class="sidebar-badge">
                    6
                </span>
            </Link>

            <!-- SECTION -->
            <p class="sidebar-section">
                Cours Audio
            </p>

            <!-- Ajouter Audio -->
            <Link  :href="teacherCoursesCreate()" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-microphone-lines"></i>
                </span>

                <span>Ajouter un Audio</span>
            </Link>

            <!-- Voir Audio -->
            <Link href="#" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-headphones"></i>
                </span>

                <span>Voir les Audios</span>

                <span class="sidebar-badge">
                    4
                </span>
            </Link>

            <!-- SECTION -->
            <p class="sidebar-section">
                Cours Vidéos
            </p>

            <!-- Ajouter Video -->
            <Link :href="teacherCoursesCreate()" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-circle-plus"></i>
                </span>

                <span>Ajouter une Vidéo</span>
            </Link>

            <!-- Voir Videos -->
            <Link href="#" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-video"></i>
                </span>

                <span>Voir les Vidéos</span>

                <span class="sidebar-badge">
                    11
                </span>
            </Link>

            <!-- SECTION -->
            <p class="sidebar-section">
                Compte
            </p>

            <!-- Profil -->
            <Link href="#" class="sidebar-link">

                <span class="sidebar-icon">
                    <i class="fas fa-user-circle"></i>
                </span>

                <span>Mon Profil</span>
            </Link>
        </nav>

        <!-- ───────── FOOTER ───────── -->
        <div class="border-t border-white/10 p-4 space-y-3 bg-white/2">

            <!-- User Card -->
            <div class="flex items-center gap-3 px-2">

                <div
                    class="w-10 h-10 rounded-full flex items-center justify-center text-[11px] font-bold text-black bg-linear-to-br from-yellow-400 to-orange-500 shadow-lg shadow-yellow-500/20 shrink-0">
                    {{ userInitials }}
                </div>

                <div class="min-w-0">
                    <p class="text-white text-[13px] font-semibold truncate">
                        {{ user?.name ?? 'Enseignant' }}
                    </p>

                    <p class="text-white/50 text-[11px] truncate">
                        {{ user?.email ?? '' }}
                    </p>
                </div>
            </div>

            <!-- Logout -->
            <Link href="#"
                class="w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium text-red-300 hover:text-red-200 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition-all duration-200 group">

                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/5 text-red-300 group-hover:bg-red-500/15 transition-all duration-200 shrink-0">
                    <i class="fas fa-right-from-bracket"></i>
                </span>

                <span>
                    Déconnexion
                </span>
            </Link>
        </div>
    </aside>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue'
import { teacherCourses, teacherCoursesCreate, teacherDashboard } from '@/routes';


/* ── Types ── */
interface User {
    name: string
    email: string
}

/* ── Props ── */
const props = defineProps<{ user?: User }>()

/* ── Computed ── */
const userInitials = computed(() => {
    const name = props.user?.name ?? ''

    return name
        .split(' ')
        .slice(0, 2)
        .map((n) => n[0])
        .join('')
        .toUpperCase()
})

</script>

<style scoped>
.scrollbar-none::-webkit-scrollbar {
    display: none;
}

.scrollbar-none {
    scrollbar-width: none;
}

/* ───────── Reusable Classes ───────── */

.sidebar-section {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: rgba(255, 255, 255, 0.3);
    padding: 1.25rem 0.875rem 0.5rem;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0.875rem;
    border-radius: 0.75rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 0.25rem;
    transition: all 0.2s ease;
}

.sidebar-link:hover {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.05);
}

.sidebar-icon {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
    background-color: rgba(255, 255, 255, 0.05);
    color: rgba(255, 255, 255, 0.8);
}

.sidebar-link:hover .sidebar-icon {
    background-color: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.sidebar-badge {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    background-color: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    border-radius: 0.375rem;
    padding: 0.125rem 0.5rem;
}
</style>
