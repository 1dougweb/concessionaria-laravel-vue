<template>
  <MainShell>
    <article v-if="vehicle" class="space-y-4">
      <h2 class="text-3xl font-semibold">{{ vehicle.title }}</h2>
      <p class="text-slate-300">{{ vehicle.status }}</p>
      <p class="text-2xl text-teal-300">R$ {{ vehicle.price }}</p>
    </article>
  </MainShell>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import MainShell from '@/components/layout/MainShell.vue'
import { apiClient } from '@/services/apiClient'

const route = useRoute()
const vehicle = ref<any>(null)

onMounted(async () => {
  const { data } = await apiClient.get(`/vehicles/${route.params.id}`)
  vehicle.value = data
})
</script>

