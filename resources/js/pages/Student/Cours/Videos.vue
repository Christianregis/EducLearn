<template>
        <div class="section-heading">
            <div>
                <h1 class="page-title">Mes certificats</h1>
                <p class="page-subtitle">4 certificats obtenus</p>
            </div>
        </div>
        <div class="cert-grid">
            <div class="cert-card" v-for="cert in certificates" :key="cert.id">
                <div class="cert-icon"><i class="fas fa-award"></i></div>
                <div class="cert-body">
                    <h4 class="cert-title">{{ cert.title }}</h4>
                    <p class="cert-issuer">{{ cert.issuer }}</p>
                    <p class="cert-date"><i class="fas fa-calendar"></i> {{ cert.date }}</p>
                </div>
                <button class="btn-outline"><i class="fas fa-download"></i> Télécharger</button>
            </div>
        </div>
</template>

<script lang="ts" setup>
interface Certificate { id: number; title: string; issuer: string; date: string }
const certificates: Certificate[] = [
    { id: 1, title: 'Web Design Mastery', issuer: 'Educ-Learn · Jean Dupont', date: '12 novembre 2024' },
    { id: 2, title: 'Financial Analyst', issuer: 'Educ-Learn · Aïcha Diop', date: '3 octobre 2024' },
    { id: 3, title: 'SEO Fundamentals', issuer: 'Educ-Learn · Fatou Sow', date: '18 août 2024' },
    { id: 4, title: 'HTML & CSS Pro', issuer: 'Educ-Learn · Marc Leblanc', date: '5 juin 2024' },
]

</script>
