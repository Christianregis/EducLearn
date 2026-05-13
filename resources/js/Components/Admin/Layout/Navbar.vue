<script lang="ts" setup>
import { computed, ref } from 'vue';

const searchQuery = ref('')
const activeSection = ref('dashboard')
const navItems = [
    { key: 'dashboard', label: 'Tableau de bord', icon: 'fas fa-th-large', badge: null },
    { key: 'courses', label: 'Mes cours', icon: 'fas fa-book-open', badge: '12' },
    { key: 'certificates', label: 'Certificats', icon: 'fas fa-award', badge: '4' },
    { key: 'calendar', label: 'Calendrier', icon: 'fas fa-calendar-alt', badge: null },
    { key: 'messages', label: 'Messages', icon: 'fas fa-comment-dots', badge: '3' },
]
const currentPageLabel = computed(() =>
    navItems.find(n => n.key === activeSection.value)?.label ?? 'Tableau de bord'
)
</script>
<template>
    <!-- TOP NAV -->
    <header class="topnav">
        <div class="topnav-left">
            <div class="page-breadcrumb">
                <i class="fas fa-home breadcrumb-icon"></i>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current">{{ currentPageLabel }}</span>
            </div>
        </div>
        <div class="topnav-right">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher un cours..." v-model="searchQuery" />
            </div>
            <button class="topnav-icon-btn" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notif-dot"></span>
            </button>
            <button class="topnav-icon-btn" title="Messages">
                <i class="fas fa-envelope"></i>
            </button>
            <div class="topnav-avatar">
                <div class="avatar-circle">AD</div>
                <div class="avatar-info">
                    <p class="avatar-name">Aminata Diallo</p>
                    <p class="avatar-role">Étudiant</p>
                </div>
                <i class="fas fa-chevron-down chev"></i>
            </div>
        </div>
    </header>
</template>
