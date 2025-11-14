import { defineStore } from 'pinia'
import { apiClient } from '@/services/apiClient'
import type { VehicleFilters } from '@/utils/vehicleFilters'
import { sanitizeVehicleFilters } from '@/utils/vehicleFilters'

export type Vehicle = {
  id: string
  title: string
  brand: string
  model: string
  year: number
  mileage: number
  price: number
  currency: string
  status: string
  fuel_type?: string | null
  transmission?: string | null
  specifications?: Record<string, unknown> | null
  stock_count?: number
}

type VehicleState = {
  items: Vehicle[]
  isLoading: boolean
  filters: VehicleFilters
  meta: Record<string, unknown> | null
}

const defaultFilters: VehicleFilters = {
  search: '',
  type: '',
  status: 'published',
  priceMin: undefined,
  priceMax: undefined
}

export const useVehicleStore = defineStore('vehicles', {
  state: (): VehicleState => ({
    items: [],
    isLoading: false,
    filters: { ...defaultFilters },
    meta: null
  }),
  actions: {
    async fetch(params: VehicleFilters = {}) {
      this.isLoading = true
      try {
        const { data } = await apiClient.get('/vehicles', {
          params: sanitizeVehicleFilters({ ...this.filters, ...params })
        })
        const collection = data.data ?? data
        this.items = Array.isArray(collection) ? collection : []
        this.meta = data.meta ?? null
        this.filters = { ...this.filters, ...params }
        this.applyClientSideFilters()
      } finally {
        this.isLoading = false
      }
    },
    applyClientSideFilters() {
      const { priceMin, priceMax } = this.filters
      if (typeof priceMin !== 'number' && typeof priceMax !== 'number') return
      this.items = this.items.filter((vehicle) => {
        if (typeof priceMin === 'number' && vehicle.price < priceMin) return false
        if (typeof priceMax === 'number' && vehicle.price > priceMax) return false
        return true
      })
    },
    setFilters(filters: VehicleFilters) {
      this.filters = { ...this.filters, ...filters }
      return this.fetch(this.filters)
    },
    resetFilters() {
      this.filters = { ...defaultFilters }
      return this.fetch(defaultFilters)
    }
  }
})

