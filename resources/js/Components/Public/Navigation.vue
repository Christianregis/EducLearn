<template>
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer" @click="goToHome">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center">
                        <div class="w-5 h-5 bg-white rounded-full"></div>
                    </div>
                    <span class="text-xl font-bold text-black">Educ-Learn</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <Link :href="home()"
                        class="text-gray-700 hover:text-black font-medium transition-colors">
                        Accueil
                    </Link>
                    <Link :href="catalog()"
                        class="text-gray-700 hover:text-black font-medium transition-colors">
                        Catalogue
                    </Link>
                    <Link href="/about"
                        class="text-gray-700 hover:text-black font-medium transition-colors">
                        À propos
                    </Link>
                    <Link href="/contact"
                        class="text-gray-700 hover:text-black font-medium transition-colors">
                        Nous Contacter
                    </Link>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    <Link :href="showLogin()"
                        class="hidden sm:block text-gray-700 hover:text-black font-medium transition-colors">
                        Connexion
                    </Link>
                    <Link :href="showRegister()"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-6 py-2 rounded-lg transition-colors">
                        S'inscrire
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 hover:text-black">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-if="mobileMenuOpen" class="md:hidden pb-4 border-t border-gray-200">
                <Link :href="home()"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 font-medium">
                    Accueil
                </Link>
                <Link :href="catalog()"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 font-medium">
                    Catalogue
                </Link>
                <Link href="/about"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 font-medium">
                    À propos
                </Link>
                <Link href="/contact"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 font-medium">
                    Nous Contacter
                </Link>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { catalog, home, showLogin, showRegister } from '@/routes'

const mobileMenuOpen = ref(false)

const goToHome = () => {
    router.visit('/')
}
</script>

<style scoped>
nav {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}
</style>
