<template>
            <aside class="sidebar" :class="{ collapsed: sidebarCollapsed }">
            <div class="sidebar-header">
                <div class="logo-block">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span class="logo-text" v-if="!sidebarCollapsed">Educ<span>-Learn</span></span>
                </div>
                <button class="collapse-btn" @click="sidebarCollapsed = !sidebarCollapsed">
                    <i :class="sidebarCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left'"></i>
                </button>
            </div>

            <div class="sidebar-user" v-if="!sidebarCollapsed">
                <div class="user-avatar">AD</div>
                <div class="user-meta">
                    <p class="user-name">Aminata Diallo</p>
                    <span class="user-badge student">Étudiant</span>
                </div>
            </div>
            <div class="sidebar-user centered" v-else>
                <div class="user-avatar small">AD</div>
            </div>

            <nav class="sidebar-nav">
                <p class="nav-label" v-if="!sidebarCollapsed">Principal</p>
                <ul>
                    <li v-for="item in navItems" :key="item.key" class="nav-item"
                        :class="{ active: activeSection === item.key }" @click="activeSection = item.key"
                        :title="sidebarCollapsed ? item.label : ''">
                        <i :class="item.icon"></i>
                        <span v-if="!sidebarCollapsed">{{ item.label }}</span>
                        <span v-if="!sidebarCollapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
                    </li>
                </ul>

                <p class="nav-label" v-if="!sidebarCollapsed">Compte</p>
                <ul>
                    <li class="nav-item" title="Paramètres">
                        <i class="fas fa-cog"></i>
                        <span v-if="!sidebarCollapsed">Paramètres</span>
                    </li>
                    <li class="nav-item" title="Aide">
                        <i class="fas fa-question-circle"></i>
                        <span v-if="!sidebarCollapsed">Aide</span>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer" v-if="!sidebarCollapsed">
                <div class="storage-block">
                    <p class="storage-label">Progression globale</p>
                    <div class="storage-bar">
                        <div class="storage-fill" style="width: 68%"></div>
                    </div>
                    <p class="storage-percent">68% complété</p>
                </div>
            </div>
        </aside>
</template>
<script setup lang="ts">
import { ref } from 'vue';

const sidebarCollapsed = ref(false)
const activeSection = ref('dashboard')


const navItems = [
    { key: 'dashboard', label: 'Tableau de bord', icon: 'fas fa-th-large', badge: null },
    { key: 'courses', label: 'Mes cours', icon: 'fas fa-book-open', badge: '12' },
    { key: 'certificates', label: 'Certificats', icon: 'fas fa-award', badge: '4' },
    { key: 'calendar', label: 'Calendrier', icon: 'fas fa-calendar-alt', badge: null },
    { key: 'messages', label: 'Messages', icon: 'fas fa-comment-dots', badge: '3' },
]

</script>
<style scoped>
/* ── ROOT LAYOUT ── */
.dashboard-root {
    display: flex;
    height: 100vh;
    overflow: hidden;
    font-family: 'Inter', sans-serif;
    background: #F9FAFB
}

/* ── SIDEBAR ── */
.sidebar {
    width: 240px;
    background: #111827;
    display: flex;
    flex-direction: column;
    transition: width .25s cubic-bezier(.4, 0, .2, 1);
    flex-shrink: 0;
    overflow: hidden
}

.sidebar.collapsed {
    width: 64px
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 14px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, .07)
}

.logo-block {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0
}

.logo-icon {
    width: 34px;
    height: 34px;
    background: #F4B400;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #111827;
    font-size: 14px;
    flex-shrink: 0
}

.logo-text {
    color: #fff;
    font-weight: 700;
    font-size: 15px;
    letter-spacing: -.3px;
    white-space: nowrap
}

.logo-text span {
    color: #F4B400
}

.collapse-btn {
    background: transparent;
    border: none;
    color: #4B5563;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 6px;
    transition: color .15s
}

.collapse-btn:hover {
    color: #F4B400
}

.sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, .07)
}

.sidebar-user.centered {
    justify-content: center
}

.user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #F4B400;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    color: #111827;
    flex-shrink: 0
}

.user-avatar.small {
    width: 30px;
    height: 30px;
    font-size: 11px
}

.user-meta {
    min-width: 0
}

.user-name {
    color: #F9FAFB;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.user-badge {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 2px
}

.user-badge.student {
    background: rgba(244, 180, 0, .18);
    color: #F4B400
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 10px 0
}

.sidebar-nav::-webkit-scrollbar {
    width: 3px
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #374151
}

.nav-label {
    font-size: 10px;
    color: #4B5563;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 10px 14px 4px
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 14px;
    color: #9CA3AF;
    font-size: 13px;
    cursor: pointer;
    transition: all .15s;
    border-left: 3px solid transparent;
    white-space: nowrap;
    overflow: hidden
}

.nav-item:hover {
    background: rgba(255, 255, 255, .05);
    color: #F9FAFB
}

.nav-item.active {
    background: rgba(244, 180, 0, .12);
    color: #F4B400;
    border-left-color: #F4B400;
    font-weight: 600
}

.nav-item i {
    width: 16px;
    font-size: 13px;
    text-align: center;
    flex-shrink: 0
}

.nav-badge {
    margin-left: auto;
    background: #F4B400;
    color: #111827;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px
}

.sidebar-footer {
    padding: 14px;
    border-top: 1px solid rgba(255, 255, 255, .07)
}

.storage-block {
    background: rgba(255, 255, 255, .04);
    border-radius: 10px;
    padding: 12px
}

.storage-label {
    color: #9CA3AF;
    font-size: 11px;
    margin-bottom: 8px
}

.storage-bar {
    height: 4px;
    background: rgba(255, 255, 255, .1);
    border-radius: 4px;
    overflow: hidden
}

.storage-fill {
    height: 100%;
    background: #F4B400;
    border-radius: 4px
}

.storage-percent {
    color: #F4B400;
    font-size: 11px;
    font-weight: 600;
    margin-top: 6px
}

/* ── TOPNAV ── */
.main-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-width: 0
}

.topnav {
    background: #fff;
    border-bottom: 1px solid #E5E7EB;
    padding: 0 24px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0
}

.topnav-left {
    display: flex;
    align-items: center;
    gap: 16px
}

.page-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6B7280
}

.breadcrumb-icon {
    color: #F4B400
}

.breadcrumb-sep {
    color: #D1D5DB
}

.breadcrumb-current {
    color: #111827;
    font-weight: 600
}

.topnav-right {
    display: flex;
    align-items: center;
    gap: 10px
}

.search-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #F9FAFB;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    padding: 7px 12px;
    min-width: 220px
}

.search-bar i {
    color: #9CA3AF;
    font-size: 13px
}

.search-bar input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 13px;
    color: #111827;
    width: 100%;
    font-family: 'Inter', sans-serif
}

.search-bar input::placeholder {
    color: #9CA3AF
}

.topnav-icon-btn {
    position: relative;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid #E5E7EB;
    background: #fff;
    color: #6B7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .15s
}

.topnav-icon-btn:hover {
    border-color: #F4B400;
    color: #F4B400
}

.notif-dot {
    position: absolute;
    top: 7px;
    right: 7px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #EF4444;
    border: 2px solid #fff
}

.topnav-avatar {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 8px;
    border: 1px solid #E5E7EB;
    transition: border-color .15s
}

.topnav-avatar:hover {
    border-color: #F4B400
}

.avatar-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #F4B400;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #111827
}

.avatar-name {
    font-size: 12px;
    font-weight: 600;
    color: #111827
}

.avatar-role {
    font-size: 10px;
    color: #9CA3AF
}

.chev {
    font-size: 10px;
    color: #9CA3AF
}

/* ── PAGE CONTENT ── */
.page-content {
    flex: 1;
    overflow-y: auto;
    padding: 28px 28px 40px
}

.page-content::-webkit-scrollbar {
    width: 4px
}

.page-content::-webkit-scrollbar-thumb {
    background: #E5E7EB
}

.section-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px
}

.page-title {
    font-size: 22px;
    font-weight: 700;
    color: #111827
}

.page-subtitle {
    font-size: 13px;
    color: #6B7280;
    margin-top: 3px
}

/* ── KPI GRID ── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px
}

.kpi-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    padding: 18px 16px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    transition: box-shadow .2s
}

.kpi-card:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, .06)
}

.kpi-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0
}

.kpi-icon.yellow {
    background: #FEF3C7;
    color: #D97706
}

.kpi-icon.green {
    background: #ECFDF5;
    color: #059669
}

.kpi-icon.blue {
    background: #EFF6FF;
    color: #2563EB
}

.kpi-icon.orange {
    background: #FFF7ED;
    color: #EA580C
}

.kpi-label {
    font-size: 12px;
    color: #6B7280;
    font-weight: 500;
    margin-bottom: 4px
}

.kpi-value {
    font-size: 26px;
    font-weight: 700;
    color: #111827;
    line-height: 1
}

.kpi-delta {
    font-size: 11px;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px
}

.kpi-delta.positive {
    color: #059669
}

.kpi-delta.neutral {
    color: #9CA3AF
}

.kpi-delta i {
    font-size: 9px
}

/* ── CHARTS ── */
.charts-row {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px;
    margin-bottom: 24px
}

.chart-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    padding: 20px
}

.chart-card.wide {
    padding: 20px
}

.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px
}

.chart-card-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: #111827
}

.chart-sub {
    color: #9CA3AF;
    font-weight: 400;
    font-size: 12px;
    margin-left: 6px
}

.chart-legend {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 11px;
    color: #6B7280
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block
}

.legend-dot.yellow {
    background: #F4B400
}

.legend-dot.gray {
    background: #E5E7EB
}

.donut-legend {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 12px
}

.dl-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #6B7280
}

.dl-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0
}

/* ── BOTTOM ROW ── */
.bottom-row {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px
}

.table-card,
.side-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    padding: 20px
}

.table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px
}

.table-card-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: #111827
}

.see-all {
    font-size: 12px;
    color: #F4B400;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px
}

.course-list {
    display: flex;
    flex-direction: column;
    gap: 14px
}

.course-row {
    display: flex;
    align-items: center;
    gap: 12px
}

.course-thumb {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #78350F;
    font-size: 16px;
    flex-shrink: 0
}

.course-info {
    flex: 1;
    min-width: 0
}

.course-name {
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.course-meta {
    font-size: 11px;
    color: #9CA3AF;
    margin: 2px 0 6px
}

.progress-bar {
    height: 4px;
    background: #F3F4F6;
    border-radius: 4px;
    overflow: hidden
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width .4s
}

.mt-8 {
    margin-top: 8px
}

.course-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex-shrink: 0
}

.progress-pct {
    font-size: 12px;
    font-weight: 700;
    color: #111827
}

.btn-resume {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #F4B400;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #111827;
    font-size: 10px;
    transition: background .15s
}

.btn-resume:hover {
    background: #E0A106
}

/* ── GOALS ── */
.goals-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px
}

.goal-item {
    display: flex;
    align-items: flex-start;
    gap: 10px
}

.goal-check {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #E5E7EB;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1px;
    transition: all .2s;
    font-size: 9px;
    color: #fff
}

.goal-check.done {
    background: #10B981;
    border-color: #10B981
}

.goal-text {
    font-size: 13px;
    color: #374151;
    font-weight: 500
}

.goal-text.goal-done {
    text-decoration: line-through;
    color: #9CA3AF
}

.goal-deadline {
    font-size: 11px;
    color: #9CA3AF;
    margin-top: 2px
}

.streak-block {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #FEF3C7;
    border-radius: 10px;
    padding: 12px;
    margin-top: 4px
}

.streak-icon {
    font-size: 22px;
    color: #D97706
}

.streak-num {
    font-size: 16px;
    font-weight: 700;
    color: #111827
}

.streak-label {
    font-size: 11px;
    color: #6B7280;
    margin-top: 1px
}

/* ── BUTTONS ── */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #F4B400;
    color: #111827;
    border: none;
    border-radius: 9px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s;
    font-family: 'Inter', sans-serif
}

.btn-primary:hover {
    background: #E0A106
}

.btn-primary.small {
    padding: 6px 12px;
    font-size: 12px
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: transparent;
    color: #6B7280;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Inter', sans-serif
}

.btn-outline:hover {
    border-color: #F4B400;
    color: #F4B400
}

/* ── COURSES GRID (mes cours) ── */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px
}

.course-card-full {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    overflow: hidden;
    transition: box-shadow .2s
}

.course-card-full:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, .07)
}

.ccf-thumb {
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #78350F
}

.ccf-body {
    padding: 14px 16px
}

.ccf-top {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px
}

.ccf-format {
    font-size: 10px;
    background: #F3F4F6;
    color: #6B7280;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600
}

.ccf-level {
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600
}

.ccf-level.débutant {
    background: #ECFDF5;
    color: #059669
}

.ccf-level.intermédiaire {
    background: #EFF6FF;
    color: #2563EB
}

.ccf-level.avancé {
    background: #FFF7ED;
    color: #EA580C
}

.ccf-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
    line-height: 1.3
}

.ccf-instructor {
    font-size: 12px;
    color: #9CA3AF
}

.ccf-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px
}

.badge-done {
    font-size: 11px;
    font-weight: 600;
    color: #059669;
    background: #ECFDF5;
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 4px
}

/* ── CERTIFICATES ── */
.cert-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px
}

.cert-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: box-shadow .2s
}

.cert-card:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, .06)
}

.cert-icon {
    width: 48px;
    height: 48px;
    background: #FEF3C7;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #D97706;
    font-size: 22px;
    flex-shrink: 0
}

.cert-body {
    flex: 1;
    min-width: 0
}

.cert-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827
}

.cert-issuer {
    font-size: 12px;
    color: #6B7280;
    margin: 2px 0
}

.cert-date {
    font-size: 11px;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 5px
}
</style>
