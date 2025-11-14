<template>
  <article class="space-y-2 rounded-2xl border border-white/5 bg-white/5 p-4">
    <header class="flex items-center justify-between text-sm text-slate-300">
      <span>{{ vehicle.brand }} • {{ vehicle.model }}</span>
      <span class="rounded-full bg-slate-800 px-2 py-0.5 text-xs uppercase">{{ vehicle.status }}</span>
    </header>
    <h3 class="text-xl font-semibold text-white">{{ vehicle.title }}</h3>
    <p class="text-teal-300">R$ {{ vehicle.price }}</p>
  </article>
</template>

<script setup lang="ts">
type Vehicle = {
  id: string
  title: string
  brand: string
  model: string
  status: string
  price: number
}

defineProps<{
  vehicle: Vehicle
}>()
</script>

