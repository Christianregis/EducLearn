<template>
    <div class="min-h-screen bg-white">
        <!-- Navigation -->
        <Navigation />

        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Gradient Background -->
            <div class="absolute inset-0 bg-linear-to-r from-yellow-400 via-yellow-300 to-blue-400"></div>

            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="z-10">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                            Découvrez Educ-Learn
                        </h1>
                        <p class="text-lg md:text-xl text-white mb-8 leading-relaxed max-w-md">
                            La connaissance est le meilleur moyen d'apprendre et de progresser
                        </p>
                        <Link :href="showLogin()"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors shadow-lg hover:shadow-xl">
                            Commencer Maintenant
                        </Link>
                    </div>

                    <!-- Right Image -->
                    <div class="relative h-96 md:h-180 flex items-center justify-center">
                        <div class="relative w-full h-full">
                            <img src="../../../public/young-smiling-confident-woman-using-laptop-computer-looking-camera-isolated-white-background-removebg-preview 1.png"
                                alt="Student with laptop" class="w-full h-full object-cover rounded-2xl shadow-2xl" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 md:py-32 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        Pourquoi choisir Educ-Learn ?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Une plateforme complète pour votre développement personnel et professionnel
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-yellow-400 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-play text-gray-900 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cours en Vidéo</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Accédez à des milliers de cours vidéo de haute qualité enseignés par des experts du secteur.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-yellow-400 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-certificate text-gray-900 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Certificats Reconnus</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Obtenez des certificats professionnels reconnus par l'industrie pour valoriser votre profil.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-yellow-400 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-users text-gray-900 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Communauté Active</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Connectez-vous avec des milliers d'apprenants et d'experts pour partager et progresser
                            ensemble.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 md:py-32 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-5xl font-bold text-yellow-400 mb-2">50K+</div>
                        <p class="text-gray-300 text-lg">Apprenants actifs</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-yellow-400 mb-2">500+</div>
                        <p class="text-gray-300 text-lg">Cours disponibles</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-yellow-400 mb-2">100+</div>
                        <p class="text-gray-300 text-lg">Instructeurs experts</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold text-yellow-400 mb-2">95%</div>
                        <p class="text-gray-300 text-lg">Taux de satisfaction</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-20 md:py-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        Nos Catégories de Cours
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Explorez une large gamme de domaines d'apprentissage
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Category Card 1 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-code text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Développement Web</h3>
                        <p class="text-gray-600">Maîtrisez HTML, CSS, JavaScript et les frameworks modernes</p>
                    </div>

                    <!-- Category Card 2 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                            <i
                                class="fas fa-paint-brush text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Design Graphique</h3>
                        <p class="text-gray-600">Apprenez les principes du design et les outils professionnels</p>
                    </div>

                    <!-- Category Card 3 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-green-500 to-green-600 flex items-center justify-center">
                            <i
                                class="fas fa-chart-line text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Analyse de Données</h3>
                        <p class="text-gray-600">Explorez les données et créez des visualisations impactantes</p>
                    </div>

                    <!-- Category Card 4 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-red-500 to-red-600 flex items-center justify-center">
                            <i class="fas fa-brain text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Intelligence Artificielle</h3>
                        <p class="text-gray-600">Découvrez le machine learning et les réseaux de neurones</p>
                    </div>

                    <!-- Category Card 5 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                            <i
                                class="fas fa-briefcase text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Entrepreneuriat</h3>
                        <p class="text-gray-600">Lancez votre startup et développez votre business</p>
                    </div>

                    <!-- Category Card 6 -->
                    <div class="group cursor-pointer">
                        <div
                            class="relative overflow-hidden rounded-xl mb-4 h-48 bg-linear-to-br from-pink-500 to-pink-600 flex items-center justify-center">
                            <i
                                class="fas fa-language text-white text-6xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Langues</h3>
                        <p class="text-gray-600">Apprenez l'anglais, l'espagnol, le français et bien d'autres</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 md:py-32 bg-linear-to-r from-blue-600 to-blue-800 text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Prêt à commencer votre parcours d'apprentissage ?
                </h2>
                <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
                    Rejoignez des milliers d'apprenants qui transforment leur carrière avec Educ-Learn
                </p>
                <Link :href="showRegister()"
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold px-10 py-4 rounded-lg transition-colors shadow-lg hover:shadow-xl text-lg">
                    S'inscrire Gratuitement
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { showLogin, showRegister } from '@/routes';
import Footer from '@/Components/Public/Footer.vue';
import Navigation from '@/Components/Public/Navigation.vue';



</script>
