import { defineStore } from 'pinia'
import { getEcho } from '@/services/socketClient'

type Notification = {
  id: string
  message: string
  payload?: Record<string, unknown>
}

export const useNotificationStore = defineStore('notifications', {
  state: () => ({
    items: [] as Notification[],
    hasBooted: false
  }),
  actions: {
    boot(userId: number | undefined) {
      if (!userId || this.hasBooted) return
      this.hasBooted = true

      const echo = getEcho()

      echo.private(`proposals.user.${userId}`).listen('ProposalCreated', (payload: any) => {
        this.items.unshift({
          id: payload.proposal_id,
          message: `Nova proposta para veículo ${payload.vehicle_id}`,
          payload
        })
      })

      echo.channel('vehicles.feed').listen('VehicleStatusUpdated', (payload: any) => {
        this.items.unshift({
          id: `${payload.vehicle_id}-${payload.status}`,
          message: `Status de veículo atualizado para ${payload.status}`,
          payload
        })
      })
    }
  }
})

