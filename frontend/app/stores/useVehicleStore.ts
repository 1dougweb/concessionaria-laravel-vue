import { defineStore } from 'pinia'
import { apiClient } from '@/services/apiClient'

type Vehicle = {
  id: string
  title: string
  status: string
}

type VehicleState = {
  items: Vehicle[]
  isLoading: boolean
}

export const useVehicleStore = defineStore('vehicles', {
  state: (): VehicleState => ({
    items: [],
    isLoading: false
  }),
  actions: {
    async fetch(params: Record<string, unknown> = {}) {
      this.isLoading = true
      const { data } = await apiClient.get('/vehicles', { params })
      this.items = data.data ?? data
      this.isLoading = false
    }
  }
})

