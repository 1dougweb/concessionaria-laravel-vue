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
  const isTls = import.meta.env.VITE_ECHO_TLS === 'true'
  const scheme = isTls ? 'https' : 'http'
  return `${scheme}://${resolveHost()}:${resolvePort()}`
}

const resolvePath = () => import.meta.env.VITE_ECHO_PATH ?? '/socket.io'

let instance: Echo<any> | null = null

export const getEcho = (): Echo<any> => {
  if (instance) return instance

  const authStore = useAuthStore()

  instance = new Echo({
    broadcaster: 'socket.io',
    client: io,
    key: import.meta.env.VITE_ECHO_KEY,
    host: buildHostUrl(),
    path: resolvePath(),
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

