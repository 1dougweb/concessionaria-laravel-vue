<template>
  <article class="flex items-center justify-between rounded-2xl border border-white/5 bg-white/5 p-4">
    <div>
      <p class="text-slate-300 text-sm">Veículo {{ proposal.vehicle_id }}</p>
      <p class="text-xl font-semibold">R$ {{ proposal.amount }}</p>
      <p class="text-xs uppercase text-slate-400">{{ proposal.status }}</p>
    </div>
    <button class="rounded-md bg-teal-500 px-3 py-2 text-sm font-semibold text-slate-900" @click="$emit('submit', proposal.id)">
      Enviar
    </button>
  </article>
</template>

<script setup lang="ts">
defineProps<{
  proposal: {
    id: string
    vehicle_id: string
    amount: number
    status: string
  }
}>()

defineEmits<{
  submit: [string]
}>()
</script>

