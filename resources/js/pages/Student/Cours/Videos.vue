<template>
    <!-- ── ROOT LAYOUT ── -->
    <div class="flex h-screen overflow-hidden font-sans bg-dark-50">

        <!-- Sidebar -->
        <Sidebar />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            <!-- Navbar -->
            <Navbar />

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">

                <!-- ── SECTION HEADING ── -->
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-[22px] font-bold text-dark">Mes certificats</h1>

                        <p class="text-[13px] text-dark-500 mt-0.5">
                            {{ certificates.length }} certificats obtenus
                        </p>
                    </div>
                </div>

                <!-- ── CERTIFICATES GRID ── -->
                <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4">

                    <div v-for="cert in certificates" :key="cert.id" class="bg-white border border-dark-200 rounded-2xl overflow-hidden
                               transition-all duration-300 hover:shadow-course hover:-translate-y-0.5">

                        <!-- Top Banner -->
                        <div
                            class="h-24 bg-linear-to-r from-amber-100 via-yellow-50 to-orange-100 flex items-center justify-center relative overflow-hidden">

                            <!-- Decorative Blurs -->
                            <div class="absolute w-24 h-24 bg-white/30 rounded-full -top-8 -left-8"></div>
                            <div class="absolute w-20 h-20 bg-amber-200/30 rounded-full -bottom-6 -right-4">
                            </div>

                            <!-- Icon -->
                            <div
                                class="relative z-10 w-15 h-15 rounded-2xl bg-white/80 backdrop-blur-sm flex items-center justify-center shadow-sm">
                                <i class="fas fa-award text-[28px] text-amber-500"></i>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="px-5 py-4">

                            <!-- Header -->
                            <div class="flex items-center justify-between mb-3">

                                <span
                                    class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full">
                                    <i class="fas fa-check-circle text-[9px]"></i>
                                    Certifié
                                </span>

                                <span class="text-[11px] font-medium text-dark-400">
                                    #{{ cert.id }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 class="text-[15px] font-bold text-dark leading-[1.35] mb-1.5">
                                {{ cert.title }}
                            </h4>

                            <!-- Issuer -->
                            <p class="text-[13px] text-dark-400 mb-3">
                                {{ cert.issuer }}
                            </p>

                            <!-- Date -->
                            <div
                                class="flex items-center gap-2 text-[12px] text-dark-500 bg-dark-50 rounded-xl px-3 py-2 mb-4">

                                <i class="fas fa-calendar-alt text-amber-500"></i>

                                <span>{{ cert.date }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">

                                <button class="flex-1 inline-flex items-center justify-center gap-2
                                               bg-brand hover:bg-brand-dark text-dark
                                               font-bold text-[12px]
                                               px-4 py-2.5 rounded-xl
                                               transition-colors duration-200">

                                    <i class="fas fa-download text-[11px]"></i>

                                    Télécharger
                                </button>

                                <button class="w-11 h-11 rounded-xl border border-dark-200
                                               text-dark-400 hover:text-dark hover:border-dark-300
                                               flex items-center justify-center
                                               transition-colors duration-200">

                                    <i class="fas fa-eye text-[13px]"></i>
                                </button>

                            </div>

                        </div>
                    </div>

                </div>
                <!-- /CERTIFICATES GRID -->

            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

interface Certificate {
    id: number
    title: string
    issuer: string
    date: string
}

const certificates: Certificate[] = [
    { id: 1, title: 'Web Design Mastery', issuer: 'Educ-Learn · Jean Dupont', date: '12 novembre 2024' },
    { id: 2, title: 'Financial Analyst', issuer: 'Educ-Learn · Aïcha Diop', date: '3 octobre 2024' },
    { id: 3, title: 'SEO Fundamentals', issuer: 'Educ-Learn · Fatou Sow', date: '18 août 2024' },
    { id: 4, title: 'HTML & CSS Pro', issuer: 'Educ-Learn · Marc Leblanc', date: '5 juin 2024' },
]
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
}
</style>
