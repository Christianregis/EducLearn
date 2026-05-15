<template>
    <FlashMessage />
    <div class="flex h-screen overflow-hidden bg-[#F8F7F4] font-sans">
        <Sidebar :user="user" />

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <Navbar :user="user" />

            <main class="flex-1 overflow-y-auto px-7 pt-7 pb-12 scrollbar-thin scrollbar-thumb-gray-200">

                <!-- ── PAGE HEADER ── -->
                <div class="flex items-start justify-between mb-7">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-amber-500">
                                Espace Enseignant
                            </span>
                        </div>
                        <h1 class="text-[24px] font-extrabold text-gray-900 leading-tight tracking-tight">
                            Ajouter un livre PDF
                        </h1>
                        <p class="text-[13px] text-gray-400 mt-1">
                            Renseignez les informations de votre cours en deux étapes.
                        </p>
                    </div>
                </div>

                <!-- ── STEPPER ── -->
                <div class="flex items-center gap-0 mb-8 max-w-md">
                    <div v-for="(step, i) in steps" :key="i" class="flex items-center gap-0 flex-1">
                        <!-- Step circle -->
                        <button @click="goToStep(i + 1)"
                            class="relative flex flex-col items-center gap-1.5 cursor-pointer bg-transparent border-none p-0 group">
                            <span
                                class="w-9 h-9 rounded-full flex items-center justify-center text-[12px] font-extrabold transition-all duration-300 border-2"
                                :class="currentStep === i + 1
                                    ? 'border-amber-400 bg-amber-400 text-gray-900 shadow-[0_0_0_4px_rgba(251,191,36,0.2)]'
                                    : currentStep > i + 1
                                        ? 'border-emerald-500 bg-emerald-500 text-white'
                                        : 'border-gray-200 bg-white text-gray-400'
                                    ">
                                <i v-if="currentStep > i + 1" class="fas fa-check text-[10px]"></i>
                                <span v-else>{{ i + 1 }}</span>
                            </span>
                            <span class="text-[10.5px] font-bold whitespace-nowrap transition-colors"
                                :class="currentStep === i + 1 ? 'text-amber-600' : 'text-gray-400'">{{ step }}</span>
                        </button>

                        <!-- Connector line -->
                        <div v-if="i < steps.length - 1"
                            class="flex-1 h-0.5 mx-2 mt-4.5 rounded-full transition-all duration-500"
                            :class="currentStep > i + 1 ? 'bg-emerald-400' : 'bg-gray-150'"
                            :style="'background-color: ' + (currentStep > i + 1 ? '#34d399' : '#e5e7eb')"></div>
                    </div>
                </div>

                <!-- ── FORM CARD ── -->
                <div class="max-w-2xl">
                    <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden shadow-sm">

                        <!-- Card header -->
                        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center text-[13px]"
                                style="background:#FEF3C7; color:#D97706">
                                <i :class="currentStep === 1 ? 'fas fa-align-left' : 'fas fa-photo-film'"></i>
                            </span>
                            <div>
                                <p class="text-[14px] font-bold text-gray-900">{{ steps[currentStep - 1] }}</p>
                                <p class="text-[11px] text-gray-400">Étape {{ currentStep }} sur {{ steps.length }}</p>
                            </div>
                        </div>

                        <!-- ── STEP 1: Informations générales ── -->
                        <div v-if="currentStep === 1" class="p-6 flex flex-col gap-5">

                            <!-- Title -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                    Titre du cours <span class="text-red-400">*</span>
                                </label>
                                <input v-model="form.title" type="text"
                                    placeholder="Ex: Maîtriser React 18 — Guide complet"
                                    class="w-full px-4 py-2.5 rounded-xl border text-[13px] font-medium text-gray-800 placeholder-gray-300 transition-all outline-none"
                                    :class="errors.title ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'" />
                                <p v-if="errors.title" class="text-[11px] text-red-500 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.title }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="flex flex-col gap-1.5">
                                <label
                                    class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Description</label>
                                <textarea v-model="form.description" rows="3"
                                    placeholder="Décrivez brièvement le contenu et les objectifs du cours…"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-[13px] font-medium text-gray-800 placeholder-gray-300 transition-all outline-none resize-none focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]"></textarea>
                            </div>

                            <!-- Category + Level (row) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                        Catégorie <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <select v-model="form.category"
                                            class="w-full px-4 py-2.5 rounded-xl border text-[13px] font-medium text-gray-800 transition-all outline-none appearance-none pr-8"
                                            :class="errors.category ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'">
                                            <option value="" disabled>Choisir…</option>
                                            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                        </select>
                                        <i
                                            class="fas fa-chevron-down text-[9px] text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                    <p v-if="errors.category" class="text-[11px] text-red-500 flex items-center gap-1">
                                        <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.category }}
                                    </p>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                        Niveau <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <select v-model="form.level"
                                            class="w-full px-4 py-2.5 rounded-xl border text-[13px] font-medium text-gray-800 transition-all outline-none appearance-none pr-8"
                                            :class="errors.level ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'">
                                            <option value="" disabled>Choisir…</option>
                                            <option v-for="lvl in levels" :key="lvl" :value="lvl">{{ lvl }}</option>
                                        </select>
                                        <i
                                            class="fas fa-chevron-down text-[9px] text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                    <p v-if="errors.level" class="text-[11px] text-red-500 flex items-center gap-1">
                                        <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.level }}
                                    </p>
                                </div>
                            </div>

                            <!-- Format -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                    Format <span class="text-red-400">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <button v-for="fmt in formats" :key="fmt.value" type="button"
                                        @click="form.format = fmt.value"
                                        class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border text-[12px] font-bold transition-all cursor-pointer"
                                        :class="form.format === fmt.value
                                            ? 'border-amber-400 bg-amber-50 text-amber-700 shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'
                                            : 'border-gray-200 bg-gray-50 text-gray-500 hover:border-gray-300'
                                            ">
                                        <i :class="fmt.icon + ' text-[10px]'"></i>
                                        {{ fmt.label }}
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!-- /STEP 1 -->

                        <!-- ── STEP 2: Médias & Tarification ── -->
                        <div v-if="currentStep === 2" class="p-6 flex flex-col gap-5">

                            <!-- Duration + Price (row) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                        Durée <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-clock text-[11px] text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                        <input v-model="form.duration" type="text" placeholder="Ex: 3h 45min"
                                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border text-[13px] font-medium text-gray-800 placeholder-gray-300 transition-all outline-none"
                                            :class="errors.duration ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'" />
                                    </div>
                                    <p v-if="errors.duration" class="text-[11px] text-red-500 flex items-center gap-1">
                                        <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.duration }}
                                    </p>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Prix
                                        (€)</label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-euro-sign text-[11px] text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                        <input v-model="form.price" type="number" min="0" step="0.01"
                                            placeholder="0.00 — gratuit"
                                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-[13px] font-medium text-gray-800 placeholder-gray-300 transition-all outline-none focus:border-amber-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(251,191,36,0.15)]" />
                                    </div>
                                </div>
                            </div>

                            <!-- Cover image upload -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Image de
                                    couverture</label>
                                <div @click="triggerImageInput" @dragover.prevent="imageDragOver = true"
                                    @dragleave.prevent="imageDragOver = false" @drop.prevent="handleImageDrop"
                                    class="relative border-2 border-dashed rounded-xl p-5 flex flex-col items-center gap-3 cursor-pointer transition-all"
                                    :class="imageDragOver ? 'border-amber-400 bg-amber-50/40' : 'border-gray-200 bg-gray-50 hover:border-amber-300 hover:bg-amber-50/20'">
                                    <input ref="imageInput" type="file" accept="image/*" class="hidden"
                                        @change="handleImageSelect" />
                                    <template v-if="!imagePreview">
                                        <span class="w-10 h-10 rounded-xl flex items-center justify-center"
                                            style="background:#FEF3C7; color:#D97706">
                                            <i class="fas fa-image text-[14px]"></i>
                                        </span>
                                        <div class="text-center">
                                            <p class="text-[12.5px] font-semibold text-gray-600">Glissez une image ou
                                                cliquez pour parcourir</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5">PNG, JPG, WEBP — max 2 Mo</p>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <img :src="imagePreview" class="w-full h-32 object-cover rounded-lg" />
                                        <button type="button" @click.stop="clearImage"
                                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white shadow-md border border-gray-100 flex items-center justify-center text-gray-500 hover:text-red-500 transition-colors text-[10px]">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- PDF file upload -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                                    Fichier PDF <span class="text-red-400">*</span>
                                </label>
                                <div @click="triggerPdfInput" @dragover.prevent="pdfDragOver = true"
                                    @dragleave.prevent="pdfDragOver = false" @drop.prevent="handlePdfDrop"
                                    class="relative border-2 border-dashed rounded-xl p-5 flex items-center gap-4 cursor-pointer transition-all"
                                    :class="errors.file
                                        ? 'border-red-300 bg-red-50'
                                        : pdfDragOver
                                            ? 'border-amber-400 bg-amber-50/40'
                                            : 'border-gray-200 bg-gray-50 hover:border-amber-300 hover:bg-amber-50/20'">
                                    <input ref="pdfInput" type="file" accept=".pdf" class="hidden"
                                        @change="handlePdfSelect" />
                                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                        :style="form.file ? 'background:#FEE2E2; color:#DC2626' : 'background:#FEE2E2; color:#DC2626'">
                                        <i class="fas fa-file-pdf text-[14px]"></i>
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p v-if="!form.file" class="text-[12.5px] font-semibold text-gray-600">
                                            Glissez votre PDF ou cliquez pour parcourir
                                        </p>
                                        <p v-else class="text-[12.5px] font-semibold text-gray-800 truncate">{{
                                            pdfFileName }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">
                                            {{ form.file ? pdfFileSize : 'PDF uniquement — max 50 Mo' }}
                                        </p>
                                    </div>
                                    <button v-if="form.file" type="button" @click.stop="clearPdf"
                                        class="w-7 h-7 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors text-[10px] shrink-0">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <p v-if="errors.file" class="text-[11px] text-red-500 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.file }}
                                </p>
                            </div>

                            <!-- Icon picker -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Icône du
                                    cours</label>
                                <div class="flex flex-wrap gap-2">
                                    <button v-for="ic in iconOptions" :key="ic" type="button" @click="form.icon = ic"
                                        class="w-9 h-9 rounded-xl border flex items-center justify-center text-[13px] transition-all cursor-pointer"
                                        :class="form.icon === ic
                                            ? 'border-amber-400 bg-amber-50 text-amber-600 shadow-[0_0_0_3px_rgba(251,191,36,0.15)]'
                                            : 'border-gray-200 bg-gray-50 text-gray-500 hover:border-gray-300 hover:bg-gray-100'
                                            " :title="ic">
                                        <i :class="ic + ' fa-fw'"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Color picker -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Couleur
                                    <span class="text-red-400">*</span></label>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <button v-for="clr in colorOptions" :key="clr.value" type="button"
                                        @click="form.color = clr.value"
                                        class="w-7 h-7 rounded-full border-2 transition-all cursor-pointer"
                                        :style="`background:${clr.value}`"
                                        :class="form.color === clr.value ? 'border-gray-800 scale-110 shadow-md' : 'border-transparent hover:scale-105'"
                                        :title="clr.label"></button>
                                    <!-- Custom color input -->
                                    <div class="relative ml-1">
                                        <input v-model="form.color" type="color"
                                            class="w-7 h-7 rounded-full border-2 border-gray-200 cursor-pointer p-0.5 bg-transparent"
                                            title="Couleur personnalisée" />
                                    </div>
                                    <span v-if="form.color" class="text-[11px] font-mono text-gray-500 ml-1">{{
                                        form.color }}</span>
                                </div>
                                <p v-if="errors.color" class="text-[11px] text-red-500 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation text-[9px]"></i>{{ errors.color }}
                                </p>
                            </div>

                        </div>
                        <!-- /STEP 2 -->

                        <!-- ── FOOTER ACTIONS ── -->
                        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
                            <button v-if="currentStep > 1" type="button" @click="prevStep"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-[13px] font-bold text-gray-600 hover:border-gray-300 hover:bg-gray-50 transition-all cursor-pointer">
                                <i class="fas fa-arrow-left text-[10px]"></i>
                                Retour
                            </button>
                            <div v-else></div>

                            <button v-if="currentStep < steps.length" type="button" @click="nextStep"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-[13px] font-bold transition-all cursor-pointer border-none"
                                style="background: linear-gradient(135deg, #F4B400 0%, #E09000 100%); color: #0F1117; box-shadow: 0 4px 14px rgba(244,180,0,0.35);">
                                Continuer
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </button>

                            <button v-else type="button" @click="submitForm" :disabled="isSubmitting"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-[13px] font-bold transition-all cursor-pointer border-none disabled:opacity-60 disabled:cursor-not-allowed"
                                style="background: linear-gradient(135deg, #F4B400 0%, #E09000 100%); color: #0F1117; box-shadow: 0 4px 14px rgba(244,180,0,0.35);">
                                <i v-if="isSubmitting" class="fas fa-spinner fa-spin text-[10px]"></i>
                                <i v-else class="fas fa-cloud-arrow-up text-[10px]"></i>
                                {{ isSubmitting ? 'Publication…' : 'Publier le cours' }}
                            </button>
                        </div>

                    </div>

                    <!-- ── LIVE PREVIEW BADGE ── -->
                    <div v-if="form.title || form.color"
                        class="mt-5 bg-white rounded-2xl border border-gray-100/80 p-5">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-3">Aperçu de la carte
                        </p>
                        <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50/60">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center text-[15px] shrink-0"
                                :style="`background:${previewIconBg}; color:${form.color || '#D97706'}`">
                                <i :class="(form.icon || 'fas fa-book') + ' fa-fw'"></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-bold text-gray-800 truncate">
                                    {{ form.title || 'Titre du cours' }}
                                </p>
                                <p class="text-[11px] text-gray-400 mt-0.5">
                                    {{ form.category || 'Catégorie' }} —
                                    <span class="font-semibold">{{ form.level || 'Niveau' }}</span>
                                </p>
                            </div>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full shrink-0"
                                style="background:#FEE2E2; color:#DC2626">PDF</span>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import Navbar from '@/Components/Teacher/Layout/Navbar.vue'
import Sidebar from '@/Components/Teacher/Layout/Sidebar.vue'
import { teacherCoursesStore } from '@/routes'

interface Form {
    title: string
    description: string
    category: string
    duration: string
    price: number | null
    image: File | null
    format: string
    progression: number
    icon: string
    color: string
    level: string
    file: File | null
}

/* ── Auth ── */
interface User { name: string; email: string }
const page = usePage()
const user = page.props.auth.user as User

/* ── Step config ── */
const steps = ['Informations générales', 'Médias & Tarification']
const currentStep = ref(1)

/* ── Form state ── */
const form = useForm<Form>({
    title: '',
    description: '',
    category: '',
    duration: '',
    price: null as number | null,
    image: null as File | null,
    format: 'PDF',
    progression: 0,
    icon: 'fas fa-book',
    color: '#D97706',
    level: '',
    file: null as File | null,
})

/* ── File state ── */
const imageInput = ref<HTMLInputElement | null>(null)
const pdfInput = ref<HTMLInputElement | null>(null)
const imagePreview = ref<string | null>(null)
const imageDragOver = ref(false)
const pdfDragOver = ref(false)
const errors = ref<Record<string, string>>({})
const isSubmitting = ref(false)

const pdfFileName = computed(() => form.file?.name ?? '')
const pdfFileSize = computed(() => {
    const f = form.file

    if (!f) {
        return ''
    }

    const kb = f.size / 1024

    return kb < 1024 ? `${kb.toFixed(0)} Ko` : `${(kb / 1024).toFixed(1)} Mo`
})

/* ── Options ── */
const categories = [
    'Développement Web', 'Data & IA', 'Design', 'Marketing', 'Finance',
    'Langues', 'Photographie', 'Management', 'Autre',
]
const levels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert']
const formats = [
    { label: 'PDF', value: 'PDF', icon: 'fas fa-file-pdf' },
    { label: 'Vidéo', value: 'Vidéo', icon: 'fas fa-circle-play' },
    { label: 'Audio', value: 'Audio', icon: 'fas fa-headphones' },
]
const iconOptions = [
    'fas fa-book', 'fas fa-file-pdf', 'fas fa-graduation-cap', 'fas fa-laptop-code',
    'fas fa-brain', 'fas fa-paint-brush', 'fas fa-bullhorn', 'fas fa-chart-bar',
    'fas fa-code', 'fas fa-atom', 'fas fa-flask', 'fas fa-pen-nib',
    'fas fa-camera', 'fas fa-music', 'fas fa-dumbbell', 'fas fa-coins',
]
const colorOptions = [
    { label: 'Ambre', value: '#D97706' },
    { label: 'Or', value: '#F4B400' },
    { label: 'Bleu', value: '#3B82F6' },
    { label: 'Indigo', value: '#4F46E5' },
    { label: 'Violet', value: '#7C3AED' },
    { label: 'Vert', value: '#059669' },
    { label: 'Rouge', value: '#DC2626' },
    { label: 'Orange', value: '#EA580C' },
    { label: 'Rose', value: '#DB2777' },
    { label: 'Cyan', value: '#0891B2' },
    { label: 'Ardoise', value: '#475569' },
    { label: 'Gris-fer', value: '#374151' },
]

/* ── Preview ── */
const previewIconBg = computed(() => {
    const c = form.color || '#D97706'

    return c + '22'
})

/* ── File handlers ── */
function triggerImageInput() {
    imageInput.value?.click()
}

function triggerPdfInput() {
    pdfInput.value?.click()
}

function handleImageSelect(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0]

    if (file) {
        applyImage(file)
    }
}
function handleImageDrop(e: DragEvent) {
    imageDragOver.value = false
    const file = e.dataTransfer?.files[0]

    if (file && file.type.startsWith('image/')) {
        applyImage(file)
    }
}
function applyImage(file: File) {
    form.image = file
    const reader = new FileReader()
    reader.onload = (e) => {
        imagePreview.value = e.target?.result as string
    }
    reader.readAsDataURL(file)
}
function clearImage() {
    form.image = null
    imagePreview.value = null

    if (imageInput.value) {
        imageInput.value.value = ''
    }
}

function handlePdfSelect(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0]

    if (file) {
        form.file = file
    }
}
function handlePdfDrop(e: DragEvent) {
    pdfDragOver.value = false
    const file = e.dataTransfer?.files[0]

    if (file && file.type === 'application/pdf') {
        form.file = file
    }
}
function clearPdf() {
    form.file = null

    if (pdfInput.value) {
        pdfInput.value.value = ''
    }
}

/* ── Validation ── */
function validateStep1(): boolean {
    errors.value = {}

    if (!form.title.trim()) {
        errors.value.title = 'Le titre est obligatoire.'
    }

    if (!form.category) {
        errors.value.category = 'Choisissez une catégorie.'
    }

    if (!form.level) {
        errors.value.level = 'Choisissez un niveau.'
    }

    return Object.keys(errors.value).length === 0
}
function validateStep2(): boolean {
    errors.value = {}

    if (!form.duration.trim()) {
        errors.value.duration = 'La durée est obligatoire.'
    }

    if (!form.file) {
        errors.value.file = 'Veuillez uploader le fichier PDF.'
    }

    if (!form.color) {
        errors.value.color = 'Choisissez une couleur.'
    }

    return Object.keys(errors.value).length === 0
}

/* ── Navigation ── */
function nextStep() {
    if (currentStep.value === 1 && !validateStep1()) {
        return
    }

    currentStep.value++
}
function prevStep() {
    errors.value = {}
    currentStep.value--
}
function goToStep(step: number) {
    if (step < currentStep.value) {
        errors.value = {}
        currentStep.value = step
    }
}

/* ── Submit ── */
async function submitForm() {
    if (!validateStep2()) {
        return
    }

    isSubmitting.value = true


    form.post(teacherCoursesStore.url(), {
        onSuccess: () => {
            isSubmitting.value = false
            form.reset()
        },
        onError: (serverErrors) => {
            errors.value = serverErrors
            isSubmitting.value = false
            console.error('Validation errors:', serverErrors)
        },
        forceFormData: true,
    })
}
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px
}

.scrollbar-thumb-gray-200::-webkit-scrollbar-thumb {
    background: #E5E7EB;
    border-radius: 99px;
}
</style>
