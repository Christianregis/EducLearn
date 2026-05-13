<template>
  <!-- ── ROOT LAYOUT ── -->
  <div class="flex h-screen overflow-hidden font-sans bg-dark-50">
    <!-- Sidebar -->
    <Sidebar :user="user" />

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      <!-- Navbar -->
      <Navbar :user="user" />

      <!-- PAGE CONTENT -->
      <main class="flex-1 overflow-y-auto px-7 pt-7 pb-10 scrollbar-thin scrollbar-thumb-dark-200">
        <!-- ── SECTION HEADING ── -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
          <div>
            <div class="flex items-center gap-3 mb-2">
              <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                <i class="fas fa-headphones text-xl text-purple-600"></i>
              </div>
              <h1 class="text-[22px] font-bold text-dark">Mes cours audio</h1>
            </div>
            <p class="text-[13px] text-dark-500 mt-0.5">
              {{ audios.length }} cours · {{ completedCount }} terminés · {{ inProgressCount }} en cours
            </p>
          </div>
          <button
            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-[13px] px-4.5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors self-start">
            <i class="fas fa-plus"></i> Nouveau cours
          </button>
        </div>

        <!-- ── FILTERS & SORT BAR ── -->
        <div class="bg-white rounded-2xl p-4 mb-6 border border-purple-200">
          <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="relative flex-1">
              <input v-model="searchQuery" type="text" placeholder="Rechercher un cours audio..."
                class="w-full pl-10 pr-4 py-2.5 bg-dark-50 border border-dark-200 rounded-[9px] text-sm text-dark placeholder-dark-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" />
              <i
                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-dark-400 text-sm"></i>
            </div>

            <!-- Filter by Status -->
            <div class="flex items-center gap-2">
              <button v-for="filter in statusFilters" :key="filter.id"
                @click="activeStatusFilter = filter.id"
                class="px-4 py-2.5 text-sm font-medium rounded-[9px] transition-all border" :class="activeStatusFilter === filter.id
                  ? 'bg-purple-600 text-white border-purple-600'
                  : 'bg-white text-dark-500 border-dark-200 hover:border-purple-300 hover:bg-purple-50'">
                {{ filter.label }}
                <span class="ml-1.5 px-1.5 py-0.5 text-[10px] font-semibold rounded-full"
                  :class="activeStatusFilter === filter.id ? 'bg-white text-purple-600' : 'bg-dark-100 text-dark-500'">
                  {{ filter.count }}
                </span>
              </button>
            </div>

            <!-- Sort -->
            <div class="flex items-center gap-2">
              <label class="text-sm text-dark-500 font-medium whitespace-nowrap">Trier par :</label>
              <select v-model="sortBy"
                class="px-4 py-2.5 bg-white border border-dark-200 rounded-[9px] text-sm text-dark focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 cursor-pointer">
                <option value="date-desc">Plus récents</option>
                <option value="date-asc">Plus anciens</option>
                <option value="progress-desc">Progression (décroissant)</option>
                <option value="progress-asc">Progression (croissant)</option>
                <option value="title-asc">Titre (A-Z)</option>
              </select>
            </div>
          </div>
        </div>

        <!-- ── AUDIOS GRID ── -->
        <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-5">
          <div v-for="audio in filteredAudios" :key="audio.id"
            class="bg-white rounded-2xl overflow-hidden border border-purple-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-purple-300 group">

            <!-- Audio Thumbnail -->
            <div
              class="relative h-40 bg-linear-to-br from-purple-100 via-purple-50 to-indigo-100 overflow-hidden">
              <!-- Background Pattern -->
              <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0"
                  :style="`background-image: radial-gradient(circle, #9333EA 1px, transparent 1px); background-size: 20px 20px;`">
                </div>
              </div>

              <!-- Audio Waves Icon Center -->
              <div class="absolute inset-0 flex items-center justify-center">
                <div
                  class="w-16 h-16 rounded-2xl bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <i class="fas fa-headphones text-[40px] text-purple-600"></i>
                </div>
              </div>

              <!-- Duration Badge -->
              <div class="absolute bottom-2 right-2 px-2 py-1 bg-dark/80 backdrop-blur-sm rounded-lg">
                <span class="text-[10px] font-semibold text-white">{{ audio.duration }}</span>
              </div>

              <!-- Progress Overlay -->
              <div class="absolute bottom-0 left-0 right-0 h-1 bg-dark-200">
                <div class="h-full bg-emerald-500 transition-all duration-500"
                  :style="`width:${audio.progress}%`"></div>
              </div>

              <!-- Level Badge -->
              <div class="absolute top-2 right-2">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wide"
                  :class="{
                    'bg-emerald-500 text-white': audio.level.toLowerCase() === 'débutant',
                    'bg-blue-500 text-white': audio.level.toLowerCase() === 'intermédiaire',
                    'bg-orange-500 text-white': audio.level.toLowerCase() === 'avancé',
                  }">
                  {{ audio.level }}
                </span>
              </div>

              <!-- Audio Badge -->
              <div class="absolute top-2 left-2">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wide bg-purple-600 text-white">
                  <i class="fas fa-volume-up text-[8px] mr-1"></i>
                  Audio
                </span>
              </div>
            </div>

            <!-- Body -->
            <div class="px-5 py-4">
              <!-- Header -->
              <div class="flex items-center justify-between mb-3">
                <span
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-purple-50 text-purple-600">
                  <i class="fas fa-headphones text-[9px]"></i>
                  Audio
                </span>
                <span class="text-[10px] font-medium text-dark-400">
                  #{{ audio.id.toString().padStart(4, '0') }}
                </span>
              </div>

              <!-- Title -->
              <h4
                class="text-[15px] font-bold text-dark leading-[1.4] mb-2 group-hover:text-purple-600 transition-colors line-clamp-2">
                {{ audio.title }}
              </h4>

              <!-- Instructor -->
              <p class="text-[12px] text-dark-400 mb-4 flex items-center gap-1.5">
                <i class="fas fa-user-circle text-[10px] text-purple-600"></i>
                {{ audio.instructor }}
              </p>

              <!-- Progress Info -->
              <div class="mb-4">
                <div class="flex items-center justify-between mb-1.5">
                  <span
                    class="text-[10px] font-medium text-dark-500 uppercase tracking-wide">Progression</span>
                  <span class="text-sm font-bold text-dark">{{ audio.progress }}%</span>
                </div>
                <div class="h-2 bg-dark-100 rounded-full overflow-hidden">
                  <div class="h-full rounded-full transition-[width] duration-500 ease-out"
                    :style="`width:${audio.progress}%; background:${audio.progress === 100 ? '#10B981' : '#9333EA'}`">
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="flex items-center gap-2">
                <button v-if="audio.progress === 100"
                  class="flex-1 inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[11px] px-4 py-2.5 rounded-xl transition-all duration-200">
                  <i class="fas fa-check-circle text-[10px]"></i>
                  Terminé
                </button>
                <button v-else
                  class="flex-1 inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-[11px] px-4 py-2.5 rounded-xl transition-all duration-200">
                  <i class="fas fa-play text-[10px]"></i>
                  {{ audio.progress > 0 ? 'Écouter' : 'Commencer' }}
                </button>
                <button
                  class="w-10 h-10 rounded-xl border border-purple-200 text-dark-400 hover:text-purple-600 hover:border-purple-300 hover:bg-purple-50 flex items-center justify-center transition-all duration-200">
                  <i class="fas fa-bookmark text-[12px]"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /AUDIOS GRID -->

        <!-- Empty state -->
        <div v-if="filteredAudios.length === 0"
          class="flex flex-col items-center justify-center py-20 text-center">
          <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-headphones text-3xl text-purple-600"></i>
          </div>
          <h3 class="text-base font-semibold text-dark mb-2">Aucun cours audio trouvé</h3>
          <p class="text-sm text-dark-500 mb-6">Essaie de modifier tes filtres ou ajoute un nouveau cours</p>
          <button
            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm px-5 py-2.5 rounded-[9px] border-none cursor-pointer transition-colors">
            <i class="fas fa-plus"></i> Ajouter un cours
          </button>
        </div>

      </main>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Navbar from '@/Components/Admin/Layout/Navbar.vue'
import Sidebar from '@/Components/Admin/Layout/Sidebar.vue'

interface Audio {
  id: number
  title: string
  instructor: string
  progress: number
  duration: string
  level: string
}

const audios: Audio[] = [
  { id: 1, title: 'Python pour la Data Science', instructor: 'Carlos Torres', progress: 88, duration: '5h 24min', level: 'Intermédiaire' },
  { id: 2, title: 'Financial Analyst Training', instructor: 'Aïcha Diop', progress: 100, duration: '6h 15min', level: 'Avancé' },
  { id: 3, title: 'Méditation et Pleine Conscience', instructor: 'Fatou Sow', progress: 45, duration: '3h 30min', level: 'Débutant' },
  { id: 4, title: 'Histoire de l\'Art Moderne', instructor: 'Jean Dupont', progress: 62, duration: '4h 48min', level: 'Intermédiaire' },
  { id: 5, title: 'Apprendre l\'Anglais Quickly', instructor: 'Sarah Mbaye', progress: 28, duration: '7h 12min', level: 'Débutant' },
  { id: 6, title: 'Podcast: entrepreneurship', instructor: 'Marc Leblanc', progress: 100, duration: '2h 45min', level: 'Débutant' },
]

const user = usePage().props.auth.user

// Search & filters
const searchQuery = ref('')
const activeStatusFilter = ref('all')
const sortBy = ref('date-desc')

const statusFilters = [
  { id: 'all', label: 'Tous', count: audios.length },
  { id: 'in-progress', label: 'En cours', count: audios.filter(a => a.progress > 0 && a.progress < 100).length },
  { id: 'completed', label: 'Terminés', count: audios.filter(a => a.progress === 100).length },
  { id: 'not-started', label: 'Non commencés', count: audios.filter(a => a.progress === 0).length },
]

// Computed counts
const completedCount = computed(() => audios.filter(a => a.progress === 100).length)
const inProgressCount = computed(() => audios.filter(a => a.progress > 0 && a.progress < 100).length)

// Filtered & sorted audios
const filteredAudios = computed(() => {
  let result = [...audios]

  // Apply search
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(a =>
      a.title.toLowerCase().includes(query) ||
      a.instructor.toLowerCase().includes(query)
    )
  }

  // Apply status filter
  switch (activeStatusFilter.value) {
    case 'in-progress':
      result = result.filter(a => a.progress > 0 && a.progress < 100)
      break
    case 'completed':
      result = result.filter(a => a.progress === 100)
      break
    case 'not-started':
      result = result.filter(a => a.progress === 0)
      break
  }

  // Apply sort
  switch (sortBy.value) {
    case 'progress-desc':
      result.sort((a, b) => b.progress - a.progress)
      break
    case 'progress-asc':
      result.sort((a, b) => a.progress - b.progress)
      break
    case 'title-asc':
      result.sort((a, b) => a.title.localeCompare(b.title))
      break
    case 'date-desc':
    case 'date-asc':
    default:
      if (sortBy.value === 'date-asc') {
        result.reverse()
      }

      break
  }

  return result
})
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
  width: 4px;
}

.scrollbar-thumb-dark-200::-webkit-scrollbar-thumb {
  background: #E5E7EB;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
