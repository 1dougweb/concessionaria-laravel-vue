<template>
  <article class="flex flex-col gap-4 rounded-2xl border border-white/5 bg-gradient-to-b from-slate-900/60 to-slate-900/20 p-4 shadow-lg shadow-slate-950/40">
    <header class="flex items-center justify-between text-xs font-semibold uppercase tracking-wide">
      <span class="text-slate-400">{{ vehicle.brand }} • {{ vehicle.model }} • {{ vehicle.year }}</span>
      <span :class="badgeClass" class="rounded-full px-2 py-0.5 text-[10px]">
        {{ vehicle.status }}
      </span>
    </header>

    <div class="space-y-1">
      <h3 class="text-xl font-semibold text-white">{{ vehicle.title }}</h3>
      <p class="text-sm text-slate-400">{{ vehicle.mileage.toLocaleString('pt-BR') }} km • {{ vehicle.fuel_type ?? '—' }}</p>
    </div>

    <p class="text-3xl font-semibold text-teal-300">{{ formatCurrency(vehicle.price) }}</p>

    <dl class="grid grid-cols-3 gap-2 text-xs text-slate-400">
      <div class="rounded-lg border border-white/5 bg-white/5 p-2">
        <dt class="uppercase tracking-wide text-[10px]">Transmissão</dt>
        <dd class="text-white">{{ vehicle.transmission ?? '—' }}</dd>
      </div>
      <div class="rounded-lg border border-white/5 bg-white/5 p-2">
        <dt class="uppercase tracking-wide text-[10px]">Combustível</dt>
        <dd class="text-white">{{ vehicle.fuel_type ?? '—' }}</dd>
      </div>
      <div class="rounded-lg border border-white/5 bg-white/5 p-2">
        <dt class="uppercase tracking-wide text-[10px]">Estoque</dt>
        <dd class="text-white">{{ vehicle.stock_count ?? 1 }} un.</dd>
      </div>
    </dl>

    <button
      class="rounded-xl border border-teal-500/40 bg-teal-500/10 px-3 py-2 text-sm font-semibold text-teal-200 transition hover:bg-teal-500/20"
      @click="$emit('simulate', vehicle)"
    >
      Simular financiamento
    </button>
  </article>
</template>

<script setup lang="ts">
import type { Vehicle } from '@/stores/useVehicleStore'
import { formatCurrency } from '@/utils/finance'
import { computed } from 'vue'

const props = defineProps<{
  vehicle: Vehicle
}>()

defineEmits<{
  simulate: [Vehicle]
}>()

const badgeClass = computed(() => {
  switch (props.vehicle.status) {
    case 'published':
      return 'bg-emerald-500/20 text-emerald-300'
    case 'reserved':
      return 'bg-amber-500/20 text-amber-300'
    case 'sold':
      return 'bg-rose-500/20 text-rose-200'
    default:
      return 'bg-slate-700 text-slate-200'
  }
})
</script>

