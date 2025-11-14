<template>
  <MainShell>
    <div class="space-y-6">
      <header class="flex flex-col gap-2">
        <p class="text-sm uppercase tracking-wide text-slate-400">Showroom</p>
        <h2 class="text-3xl font-semibold text-white">Catálogo de veículos</h2>
        <p class="text-sm text-slate-400">Encontre o carro ideal filtrando por categoria, status e orçamento.</p>
      </header>

      <VehicleFilters v-model="filters" @reset="resetFilters" />

      <div v-if="vehicleStore.isLoading" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <VehicleCardSkeleton v-for="n in 6" :key="n" />
      </div>

      <div v-else class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <VehicleCard
          v-for="vehicle in vehicleStore.items"
          :key="vehicle.id"
          :vehicle="vehicle"
          @simulate="openSimulator"
        />
      </div>

      <p v-if="!vehicleStore.items.length && !vehicleStore.isLoading" class="rounded-2xl border border-white/5 bg-white/5 p-6 text-center text-slate-400">
        Nenhum veículo encontrado com os filtros atuais.
      </p>
    </div>

    <VehicleFinanceSimulator :open="Boolean(selectedVehicle)" :vehicle="selectedVehicle" @close="selectedVehicle = null" />
  </MainShell>
</template>

<script setup lang="ts">
import { reactive, watch, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import type { LocationQuery } from 'vue-router'
import MainShell from '@/components/layout/MainShell.vue'
import VehicleCard from '@/components/domain/vehicles/VehicleCard.vue'
import VehicleFilters from '@/components/domain/vehicles/VehicleFilters.vue'
import VehicleCardSkeleton from '@/components/domain/vehicles/VehicleCardSkeleton.vue'
import VehicleFinanceSimulator from '@/components/domain/vehicles/VehicleFinanceSimulator.vue'
import { useVehicleStore, type Vehicle } from '@/stores/useVehicleStore'
import { parseFiltersFromQuery } from '@/utils/vehicleFilters'

const vehicleStore = useVehicleStore()
const route = useRoute()
const router = useRouter()

const parseQueryFilters = () => parseFiltersFromQuery(route.query as LocationQuery)

const filters = reactive({
  search: '',
  type: '',
  status: 'published',
  priceMin: undefined as number | undefined,
  priceMax: undefined as number | undefined,
  ...parseQueryFilters()
})
const selectedVehicle = ref<Vehicle | null>(null)

const syncQuery = () => {
  const query: Record<string, string> = {}
  Object.entries(filters).forEach(([key, value]) => {
    if (value !== undefined && value !== '' && value !== null) query[key] = String(value)
  })
  router.replace({ query })
}

watch(
  filters,
  () => {
    syncQuery()
    vehicleStore.fetch(filters)
  },
  { deep: true, immediate: true }
)

const resetFilters = () => {
  Object.assign(filters, {
    search: '',
    type: '',
    status: 'published',
    priceMin: undefined,
    priceMax: undefined
  })
}

const openSimulator = (vehicle: Vehicle) => {
  selectedVehicle.value = vehicle
}
</script>

