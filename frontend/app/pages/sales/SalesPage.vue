<template>
  <MainShell>
    <h2 class="text-2xl font-semibold">Vendas</h2>
    <ul class="space-y-3 pt-4">
      <li v-for="sale in salesStore.items" :key="sale.id" class="rounded-2xl border border-white/5 bg-white/5 p-4">
        <p class="text-slate-400 text-sm">{{ sale.status }}</p>
        <p class="text-2xl font-semibold text-teal-300">R$ {{ sale.total_amount }}</p>
      </li>
    </ul>
  </MainShell>
</template>

<script setup lang="ts">
import MainShell from '@/components/layout/MainShell.vue'
import { useSalesStore } from '@/stores/useSalesStore'

const salesStore = useSalesStore()
salesStore.fetch()
</script>

