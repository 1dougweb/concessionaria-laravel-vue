<template>
  <MainShell>
    <section class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Propostas</h2>
      <span class="text-sm text-slate-300">{{ proposalStore.items.length }} registradas</span>
    </section>

    <div class="space-y-3">
      <ProposalRow v-for="proposal in proposalStore.items" :key="proposal.id" :proposal="proposal" @submit="proposalStore.submit" />
    </div>
  </MainShell>
</template>

<script setup lang="ts">
import MainShell from '@/components/layout/MainShell.vue'
import ProposalRow from '@/components/domain/proposals/ProposalRow.vue'
import { useProposalStore } from '@/stores/useProposalStore'

const proposalStore = useProposalStore()
proposalStore.fetch()
</script>

