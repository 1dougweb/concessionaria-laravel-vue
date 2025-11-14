<template>
  <MainShell>
    <section class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Veículos</h2>
      <input v-model="filters.search" placeholder="Buscar" class="rounded-md border border-white/10 bg-white/5 px-3 py-2 text-sm">
    </section>

    <div class="grid gap-4 md:grid-cols-3">
      <VehicleCard v-for="vehicle in vehicleStore.items" :key="vehicle.id" :vehicle="vehicle" />
    </div>
  </MainShell>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'
import MainShell from '@/components/layout/MainShell.vue'
import VehicleCard from '@/components/domain/vehicles/VehicleCard.vue'
import { useVehicleStore } from '@/stores/useVehicleStore'

const vehicleStore = useVehicleStore()

const filters = reactive({
  search: ''
})

watch(
  () => filters.search,
  (search) => vehicleStore.fetch({ search }),
  { immediate: true }
)
</script>

