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
  isMutating: boolean
}

export const useSalesStore = defineStore('sales', {
  state: (): SalesState => ({
    items: [],
    isLoading: false,
    isMutating: false
  }),
  actions: {
    async fetch(params: Record<string, unknown> = {}) {
      this.isLoading = true
      const { data } = await apiClient.get('/sales', { params })
      this.items = data.data ?? data
      this.isLoading = false
    },
    async finalize(saleId: string, payload: Record<string, unknown>) {
      this.isMutating = true
      try {
        const { data } = await apiClient.post(`/sales/${saleId}/finalize`, payload)
        this.items = this.items.map((sale) => (sale.id === saleId ? data : sale))
        return data
      } finally {
        this.isMutating = false
      }
    }
  }
})

