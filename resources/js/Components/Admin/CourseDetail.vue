<template>
    <Transition name="slide-panel">
        <aside v-if="selectedEnrollment"
            class="fixed right-0 top-0 h-full w-95 bg-white border-l border-gray-100 shadow-2xl flex flex-col z-30 overflow-hidden">
            <!-- Header panneau -->
            <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-50">
                <span class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">
                    Détail du {{ THEME.itemName }}
                </span>
                <button @click="handleCloseCourseDetail()"
                    class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors text-gray-500 text-xs">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body scrollable -->
            <div class="flex-1 overflow-y-auto scrollbar-thin">

                <!-- Couverture décorative -->
                <div class="h-52 relative flex items-center justify-center overflow-hidden"
                    :style="`background:${selectedEnrollment.course.color || THEME.defaultCardBg}`">
                    <div class="absolute inset-0 opacity-10"
                        :style="`background: repeating-linear-gradient(45deg, ${THEME.accent} 0px, ${THEME.accent} 1px, transparent 0, transparent 50%) / 16px 16px`">
                    </div>

                    <!-- Image de fond si disponible -->
                    <img v-if="selectedEnrollment.course.image" :src="selectedEnrollment.course.image"
                        :alt="selectedEnrollment.course.title"
                        class="absolute inset-0 w-full h-full object-cover opacity-15" />

                    <!-- Cercles déco -->
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 rounded-full opacity-20"
                        :style="`background:${THEME.accent}`"></div>
                    <div class="absolute -top-4 -left-4 w-20 h-20 rounded-full opacity-10"
                        :style="`background:${THEME.accent}`"></div>

                    <!-- Icône centrale -->
                    <div class="relative z-10 flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-lg"
                            :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                            <i :class="selectedEnrollment.course.icon || THEME.defaultIcon"></i>
                        </div>
                    </div>

                    <!-- Badge progression -->
                    <div class="absolute bottom-3 right-3">
                        <div
                            class="bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-bold text-gray-800 shadow-sm">
                            {{ selectedEnrollment.progress }}% complété
                        </div>
                    </div>
                </div>

                <!-- Infos principales -->
                <div class="px-5 py-5">

                    <!-- Badges statut -->
                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide"
                            :class="levelClass(selectedEnrollment.course.level)">
                            {{ selectedEnrollment.course.level }}
                        </span>
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide"
                            :style="`background:${THEME.accent}20; color:${THEME.accent}`">
                            {{ selectedEnrollment.course.format }}
                        </span>
                        <span v-if="selectedEnrollment.course.status"
                            class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 uppercase tracking-wide">
                            {{ selectedEnrollment.course.status }}
                        </span>
                    </div>

                    <!-- Titre -->
                    <h2 class="text-[17px] font-bold text-gray-900 leading-snug mb-2">
                        {{ selectedEnrollment.course.title }}
                    </h2>

                    <!-- Description -->
                    <p v-if="selectedEnrollment.course.description"
                        class="text-[12.5px] text-gray-500 leading-relaxed mb-5">
                        {{ selectedEnrollment.course.description }}
                    </p>

                    <!-- Méta-données : grille 2 colonnes -->
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Durée</p>
                            <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                <i class="fas fa-clock text-[11px]" :style="`color:${THEME.accent}`"></i>
                                {{ selectedEnrollment.course.duration || '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Catégorie</p>
                            <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                <i class="fas fa-tag text-[11px]" :style="`color:${THEME.accent}`"></i>
                                {{ selectedEnrollment.course.category || '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Étudiants</p>
                            <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                <i class="fas fa-users text-[11px]" :style="`color:${THEME.accent}`"></i>
                                {{ selectedEnrollment.course.students ?? 0 }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Prix</p>
                            <p class="text-[13px] font-bold text-gray-800 flex items-center gap-1.5">
                                <i class="fas fa-coins text-[11px]" :style="`color:${THEME.accent}`"></i>
                                {{ selectedEnrollment.course.price > 0
                                    ? selectedEnrollment.course.price + ' FCFA'
                                    : 'Gratuit' }}
                            </p>
                        </div>
                    </div>

                    <!-- Progression détaillée -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-semibold text-gray-600">Votre progression</span>
                            <span class="text-sm font-bold"
                                :style="`color:${progressColor(selectedEnrollment.progress)}`">
                                {{ selectedEnrollment.progress }}%
                            </span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700"
                                :style="`width:${selectedEnrollment.progress}%; background:${progressColor(selectedEnrollment.progress)}`">
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1.5">
                            Inscrit le {{ formatDate(selectedEnrollment.created_at) }}
                        </p>
                    </div>

                    <div class="border-t border-gray-100 mb-5"></div>

                    <!-- Aperçu image -->
                    <div v-if="selectedEnrollment.course.image" class="mb-5">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-2">
                            Aperçu</p>
                        <img :src="selectedEnrollment.course.image" :alt="selectedEnrollment.course.title"
                            class="w-full h-32 object-cover rounded-xl border border-gray-100" />
                    </div>
                </div>
            </div>

            <!-- ── CTA FOOTER ── -->
            <div class="px-5 py-4 border-t border-gray-100 bg-white">

                <!-- Cours terminé -->
                <div v-if="selectedEnrollment.progress === 100" class="flex items-center gap-3">
                    <div class="flex-1 flex items-center gap-2 bg-emerald-50 rounded-xl px-4 py-3">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <span class="text-sm font-semibold text-emerald-700">Cours terminé</span>
                    </div>
                    <a v-if="selectedEnrollment.course.file" :href="selectedEnrollment.course.file" target="_blank"
                        rel="noopener noreferrer"
                        class="w-11 h-11 rounded-xl flex items-center justify-center border border-gray-200 hover:bg-gray-50 transition-colors text-gray-500 text-sm"
                        title="Télécharger">
                        <i class="fas fa-download"></i>
                    </a>
                </div>

                <!-- Cours en cours -->
                <div v-else class="flex items-center gap-3">
                    <a v-if="selectedEnrollment.course.file" :href="selectedEnrollment.course.file" target="_blank"
                        rel="noopener noreferrer"
                        class="flex-1 inline-flex items-center justify-center gap-2.5 font-bold text-[13px] py-3 rounded-xl border-none cursor-pointer transition-all hover:opacity-90 hover:shadow-md no-underline"
                        :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                        <i :class="THEME.ctaIcon"></i>
                        {{ selectedEnrollment.progress > 0 ? THEME.ctaContinue : THEME.ctaStart }}
                    </a>
                    <button v-else disabled
                        class="flex-1 inline-flex items-center justify-center gap-2.5 font-bold text-[13px] py-3 rounded-xl border-none cursor-not-allowed opacity-50"
                        :style="`background:${THEME.accent}; color:${THEME.accentText}`">
                        <i class="fas fa-ban"></i> Fichier indisponible
                    </button>
                </div>
            </div>
        </aside>
    </Transition>

    <!-- Overlay mobile -->
    <Transition name="fade">
        <div v-if="selectedEnrollment" class="lg:hidden fixed inset-0 bg-black/30 z-20 backdrop-blur-sm"
            @click="selectedEnrollment = null"></div>
    </Transition>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import type { EnrollmentItem } from '@/types/enrollement';
import { formatDate } from '@/utils/formatDate';
import { levelClass } from '@/utils/levelClass';
import { progressColor } from '@/utils/progressColor';


interface Props {
    enrollement: EnrollmentItem | null,
    theme: any,
}
const props = defineProps<Props>()
const selectedEnrollment = ref<EnrollmentItem | null>(props.enrollement)
const THEME = props.theme

const emit = defineEmits(['closeCourseDetail']);

const handleCloseCourseDetail = () => {
    emit('closeCourseDetail', true)
}
</script>
