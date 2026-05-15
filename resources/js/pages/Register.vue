<template>
    <FlashMessage />
    <div
        class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                <!-- Left Side - Image Section -->
                <div class="flex justify-center lg:justify-end order-2 lg:order-1">
                    <div class="relative w-full max-w-sm">
                        <div
                            class="rounded-3xl overflow-hidden shadow-2xl bg-gray-200 h-96 sm:h-175 flex items-center justify-center">
                            <img src="../../../public/Image.png" alt="Student with red notebook"
                                class="w-full h-full object-cover" />
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-red-500 rounded-2xl shadow-lg"></div>
                    </div>
                </div>

                <!-- Right Side - Form Section -->
                <div class="order-1 lg:order-2">
                    <!-- Logo and Header -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-black rounded-xl flex items-center justify-center">
                                <div class="w-6 h-6 bg-white rounded-full"></div>
                            </div>
                            <h1 class="text-2xl font-bold text-black">
                                <Link :href="home()">Educ-Learn</Link>
                            </h1>
                        </div>

                        <h2 class="text-3xl sm:text-4xl font-bold text-black mb-4">
                            Bienvenue chez Educ-Learn
                        </h2>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Accédez à une large gamme de cours en Audio, Vidéos, Textes pour apprendre sérieusement.
                        </p>
                    </div>

                    <!-- Step Indicator -->
                    <div class="flex items-center gap-3 mb-8">
                        <div class="flex items-center gap-2">
                            <div
                                :class="['w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300',
                                    currentStep === 1 ? 'bg-yellow-400 text-black' : 'bg-black text-white']">
                                <svg v-if="currentStep === 2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span v-else>1</span>
                            </div>
                            <span :class="['text-sm font-medium transition-colors duration-300', currentStep === 1 ? 'text-black' : 'text-gray-400']">
                                Votre rôle
                            </span>
                        </div>

                        <div class="flex-1 h-px bg-gray-300 relative overflow-hidden">
                            <div :class="['absolute inset-y-0 left-0 bg-yellow-400 transition-all duration-500', currentStep === 2 ? 'w-full' : 'w-0']"></div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div
                                :class="['w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300',
                                    currentStep === 2 ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-400']">
                                2
                            </div>
                            <span :class="['text-sm font-medium transition-colors duration-300', currentStep === 2 ? 'text-black' : 'text-gray-400']">
                                Vos informations
                            </span>
                        </div>
                    </div>

                    <!-- ── STEP 1 : Choix du rôle ── -->
                    <div v-if="currentStep === 1" class="step-panel">
                        <p class="text-gray-700 font-semibold mb-5">Je suis...</p>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <!-- Étudiant -->
                            <button type="button" @click="formData.role = 'student'"
                                :class="['role-card group relative rounded-2xl border-2 p-6 text-left transition-all duration-300 focus:outline-none',
                                    formData.role === 'student'
                                        ? 'border-yellow-400 bg-yellow-50 shadow-lg scale-[1.02]'
                                        : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-md']">
                                <!-- Checkmark -->
                                <span v-if="formData.role === 'student'"
                                    class="absolute top-3 right-3 w-5 h-5 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <!-- Icon -->
                                <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors duration-300',
                                    formData.role === 'student' ? 'bg-yellow-400' : 'bg-gray-100 group-hover:bg-gray-200']">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6l-3.5 2M12 20l-3.5-2M12 20l3.5-2" />
                                    </svg>
                                </div>
                                <p class="font-bold text-gray-900 text-base">Étudiant</p>
                                <p class="text-xs text-gray-500 mt-1 leading-snug">J'apprends et je progresse</p>
                            </button>

                            <!-- Professeur -->
                            <button type="button" @click="formData.role = 'teacher'"
                                :class="['role-card group relative rounded-2xl border-2 p-6 text-left transition-all duration-300 focus:outline-none',
                                    formData.role === 'teacher'
                                        ? 'border-yellow-400 bg-yellow-50 shadow-lg scale-[1.02]'
                                        : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-md']">
                                <!-- Checkmark -->
                                <span v-if="formData.role === 'teacher'"
                                    class="absolute top-3 right-3 w-5 h-5 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <!-- Icon -->
                                <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors duration-300',
                                    formData.role === 'teacher' ? 'bg-yellow-400' : 'bg-gray-100 group-hover:bg-gray-200']">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <p class="font-bold text-gray-900 text-base">Professeur</p>
                                <p class="text-xs text-gray-500 mt-1 leading-snug">J'enseigne et je partage</p>
                            </button>
                        </div>

                        <button type="button" @click="currentStep = 2" :disabled="!formData.role"
                            :class="['w-full py-3 px-4 font-bold rounded-lg transition-all duration-200 shadow-md',
                                formData.role
                                    ? 'bg-yellow-400 hover:bg-yellow-500 text-black hover:shadow-lg cursor-pointer'
                                    : 'bg-gray-200 text-gray-400 cursor-not-allowed']">
                            Continuer →
                        </button>
                    </div>

                    <!-- ── STEP 2 : Informations ── -->
                    <div v-else class="step-panel">
                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <!-- Username Field -->
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Nom Utilisateur
                                </label>
                                <div class="relative">
                                    <input id="username" v-model="formData.name" type="text" placeholder="@example.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" />
                                    <svg class="absolute right-3 top-3.5 w-5 h-5 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p v-if="formData.errors.name" class="mt-1 text-sm text-red-500">
                                    {{ formData.errors.name }}
                                </p>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Adresse Mail
                                </label>
                                <div class="relative">
                                    <input id="email" v-model="formData.email" type="text" placeholder="@example.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" />
                                    <svg class="absolute right-3 top-3.5 w-5 h-5 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p v-if="formData.errors.email" class="mt-1 text-sm text-red-500">
                                    {{ formData.errors.email }}
                                </p>
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Mot de passe
                                </label>
                                <div class="relative">
                                    <input id="password" v-model="formData.password"
                                        :type="showPassword ? 'text' : 'password'" placeholder="••••••••••"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" />
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600">
                                        <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 9.172L21 21m-12-12l8.485-8.485m0 0a1 1 0 111.414-1.414m-1.414 1.414L9.172 9.172" />
                                        </svg>
                                    </button>
                                </div>
                                <p v-if="formData.errors.password" class="mt-1 text-sm text-red-500">
                                    {{ formData.errors.password }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <button type="button" @click="currentStep = 1"
                                    class="py-3 px-5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:border-gray-400 hover:bg-gray-50 transition-all duration-200">
                                    ← Retour
                                </button>
                                <button type="submit"
                                    class="flex-1 py-3 px-4 bg-yellow-400 hover:bg-yellow-500 text-black font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                    S'inscrire
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-700">
                            Vous avez déjà un compte ?
                            <Link :href="showLogin()"
                                class="font-bold text-black hover:text-gray-800 relative inline-block group">
                                Connectez-Vous !
                                <span
                                    class="absolute bottom-0 left-0 w-full h-0.5 bg-black transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { home, register, showLogin } from '@/routes'

// ── Ajouts multi-step (nouvelles variables uniquement) ──
const currentStep = ref<1 | 2>(1)

// ── Variables existantes — inchangées ──
const showPassword = ref(false)
const formData = useForm({
    name: '',
    email: '',
    password: '',
    role: '' // ajouté dans le formData pour être envoyé au backend
})

// ── Logique existante — inchangée ──
const handleSubmit = () => {
    formData.post(register.url(), {
        onSuccess: () => {
            formData.reset()
        },
    })
}
</script>

<style scoped>
input {
    transition: all 0.3s ease;
}
input:focus {
    box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
}
button {
    transition: all 0.3s ease;
}
.role-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.step-panel {
    animation: fadeSlideIn 0.3s ease forwards;
}
@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateX(16px); }
    to   { opacity: 1; transform: translateX(0); }
}
@media (max-width: 768px) {
    :deep(.grid) { gap: 2rem; }
}
</style>
