import Echo from 'laravel-echo'
import { io } from 'socket.io-client'
import { useAuthStore } from '@/stores/useAuthStore'

const resolveHost = () => {
  const envHost = import.meta.env.VITE_ECHO_HOST
  if (envHost) return envHost
  if (typeof window !== 'undefined') return window.location.hostname
  return 'localhost'
}

const resolvePort = () => {
  const envPort = import.meta.env.VITE_ECHO_PORT
  if (envPort) return envPort
  return '5173'
}

const buildHostUrl = () => {
  const protocol = import.meta.env.VITE_ECHO_TLS === 'true' ? 'https' : 'http'
  const host = resolveHost()
  const port = resolvePort()
  return `${protocol === 'https' ? 'https' : 'http'}://${host}:${port}`
}

let instance: Echo<'socket.io'> | null = null

export const getEcho = (): Echo<'socket.io'> => {
  if (instance) return instance

  const authStore = useAuthStore()

  instance = new Echo({
    broadcaster: 'socket.io',
    client: io,
    key: import.meta.env.VITE_ECHO_KEY,
    host: buildHostUrl(),
    transports: ['websocket'],
    forceTLS: import.meta.env.VITE_ECHO_TLS === 'true',
    auth: {
      headers: authStore.accessToken
        ? {
            Authorization: `Bearer ${authStore.accessToken}`
          }
        : {}
    }
  })

  return instance
}

