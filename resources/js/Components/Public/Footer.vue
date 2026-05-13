<template>
  <footer class="bg-gray-900 text-gray-300">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        <!-- Brand Section -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center">
              <div class="w-5 h-5 bg-gray-900 rounded-full"></div>
            </div>
            <span class="text-xl font-bold text-white">Educ-Learn</span>
          </div>
          <p class="text-sm leading-relaxed text-gray-400">
            Plateforme d'apprentissage innovante pour développer vos compétences et progresser dans votre carrière.
          </p>
        </div>

        <!-- Produits -->
        <div>
          <h3 class="text-white font-bold text-lg mb-4">Produits</h3>
          <ul class="space-y-3">
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Cours en ligne
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Certificats
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Mentoring
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Ressources
              </button>
            </li>
          </ul>
        </div>

        <!-- Entreprise -->
        <div>
          <h3 class="text-white font-bold text-lg mb-4">Entreprise</h3>
          <ul class="space-y-3">
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                À propos
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Blog
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Carrières
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Presse
              </button>
            </li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <h3 class="text-white font-bold text-lg mb-4">Support</h3>
          <ul class="space-y-3">
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Centre d'aide
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Contact
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Conditions d'utilisation
              </button>
            </li>
            <li>
              <button class="text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium">
                Confidentialité
              </button>
            </li>
          </ul>
        </div>
      </div>

      <!-- Divider -->
      <div class="border-t border-gray-800 my-12"></div>

      <!-- Bottom Section -->
      <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="text-sm text-gray-500 mb-4 md:mb-0">
          © 2026 Educ-Learn. Tous droits réservés.
        </p>

        <!-- Social Links -->
        <div class="flex items-center gap-6">
          <button class="text-gray-400 hover:text-yellow-400 transition-colors">
            <i class="fab fa-facebook text-xl"></i>
          </button>
          <button class="text-gray-400 hover:text-yellow-400 transition-colors">
            <i class="fab fa-twitter text-xl"></i>
          </button>
          <button class="text-gray-400 hover:text-yellow-400 transition-colors">
            <i class="fab fa-linkedin text-xl"></i>
          </button>
          <button class="text-gray-400 hover:text-yellow-400 transition-colors">
            <i class="fab fa-instagram text-xl"></i>
          </button>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
</script>

<style scoped>
footer {
  background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}
</style>
