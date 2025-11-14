<template>
  <MainShell>
    <article v-if="proposal" class="space-y-4">
      <h2 class="text-3xl font-semibold">Proposta #{{ proposal.id }}</h2>
      <p class="text-slate-300">Status: {{ proposal.status }}</p>
      <p class="text-2xl text-teal-300">R$ {{ proposal.amount }}</p>
    </article>
  </MainShell>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import MainShell from '@/components/layout/MainShell.vue'
import { apiClient } from '@/services/apiClient'

const route = useRoute()
const proposal = ref<any>(null)

onMounted(async () => {
  const { data } = await apiClient.get(`/proposals/${route.params.id}`)
  proposal.value = data
})
</script>

