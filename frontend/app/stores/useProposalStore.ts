import { defineStore } from 'pinia'
import { apiClient } from '@/services/apiClient'

type Proposal = {
  id: string
  vehicle_id: string
  status: string
  amount: number
}

type ProposalState = {
  items: Proposal[]
  isLoading: boolean
}

export const useProposalStore = defineStore('proposals', {
  state: (): ProposalState => ({
    items: [],
    isLoading: false
  }),
  actions: {
    async fetch(params: Record<string, unknown> = {}) {
      this.isLoading = true
      const { data } = await apiClient.get('/proposals', { params })
      this.items = data.data ?? data
      this.isLoading = false
    },
    async submit(proposalId: string) {
      await apiClient.post(`/proposals/${proposalId}/submit`)
      await this.fetch()
    }
  }
})

