<template>
  <MainShell>
    <section class="grid gap-4 md:grid-cols-3">
      <SummaryCard label="Veículos ativos" :value="kpis.vehicles" />
      <SummaryCard label="Propostas abertas" :value="kpis.proposals" />
      <SummaryCard label="Vendas mês" :value="kpis.sales" />
    </section>
  </MainShell>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import MainShell from '@/components/layout/MainShell.vue'
import SummaryCard from '@/components/domain/dashboard/SummaryCard.vue'
import { useVehicleStore } from '@/stores/useVehicleStore'
import { useProposalStore } from '@/stores/useProposalStore'
import { useSalesStore } from '@/stores/useSalesStore'

const vehicleStore = useVehicleStore()
const proposalStore = useProposalStore()
const salesStore = useSalesStore()

vehicleStore.fetch()
proposalStore.fetch()
salesStore.fetch()

const kpis = computed(() => ({
  vehicles: vehicleStore.items.length,
  proposals: proposalStore.items.length,
  sales: salesStore.items.length
}))
</script>

