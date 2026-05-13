<template>
    <FlashMessage />
    <div
        class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <!-- Main Container -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                <!-- Left Side - Image Section -->
                <div class="flex justify-center lg:justify-end order-2 lg:order-1">
                    <div class="relative w-full max-w-sm">
                        <!-- Image Container with rounded corners -->
                        <div
                            class="rounded-3xl overflow-hidden shadow-2xl bg-gray-200 h-96 sm:h-175 flex items-center justify-center">
                            <img src="../../../public/Image (1).png" alt="Student with red notebook"
                                class="w-full h-full object-cover" />
                        </div>
                        <!-- Decorative red square element -->
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
                            Bon retour chez Educ-Learn
                        </h2>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Connectez-vous et accédez à une large gamme de cours en Audio, Vidéos, Textes pour apprendre
                            sérieuse et
                            encore.
                        </p>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="handleSubmit" class="space-y-6">

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                Adresse Mail
                            </label>
                            <div class="relative">
                                <input v-model="formData.email" type="email" placeholder="@example.com"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" required/>
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" required/>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600">
                                    <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 bg-yellow-400 hover:bg-yellow-500 text-black font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            Se Connecter
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-700">
                            Vous n'avez pas déja un compte ?
                            <Link :href="showRegister()"
                                class="font-bold text-black hover:text-gray-800 relative inline-block group">
                                Inscrivez-Vous !
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
import { home, login, showRegister } from '@/routes'


// State management
const showPassword = ref(false)
const formData = useForm({
    email: '',
    password: ''
})

// Methods
const handleSubmit = () => {
    formData.post(login.url(), {
        onSuccess: () => {
            formData.reset()
        },
        onError: (errors) => {
            console.error('Login failed:', errors)
        }
    })
}

</script>

<style scoped>
/* Smooth transitions */
input {
    transition: all 0.3s ease;
}

input:focus {
    box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
}

button {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    :deep(.grid) {
        gap: 2rem;
    }
}
</style>
