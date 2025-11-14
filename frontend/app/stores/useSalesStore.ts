import { defineStore } from 'pinia'
import { apiClient } from '@/services/apiClient'

type Sale = {
  id: string
  status: string
  total_amount: number
}

type SalesState = {
  items: Sale[]
  isLoading: boolean
}

export const useSalesStore = defineStore('sales', {
  state: (): SalesState => ({
    items: [],
    isLoading: false
  }),
  actions: {
    async fetch(params: Record<string, unknown> = {}) {
      this.isLoading = true
      const { data } = await apiClient.get('/sales', { params })
      this.items = data.data ?? data
      this.isLoading = false
    }
  }
})

