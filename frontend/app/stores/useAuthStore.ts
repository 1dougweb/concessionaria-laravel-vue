import { defineStore } from 'pinia'
import { apiClient } from '@/services/apiClient'

type Credentials = {
  email: string
  password: string
}

type AuthUser = {
  id: number
  name: string
  email: string
  role?: string
}

type PersistedAuth = {
  accessToken: string
  user: AuthUser
  expiresAt: number
}

type AuthState = {
  accessToken: string | null
  user: AuthUser | null
  isLoading: boolean
}

const AUTH_STORAGE_KEY = 'concessionaria-auth'
let refreshTimer: number | null = null

const persistAuth = (payload: PersistedAuth | null) => {
  if (typeof window === 'undefined') return
  if (!payload) {
    window.localStorage.removeItem(AUTH_STORAGE_KEY)
    return
  }
  window.localStorage.setItem(AUTH_STORAGE_KEY, JSON.stringify(payload))
}

const readPersistedAuth = (): PersistedAuth | null => {
  if (typeof window === 'undefined') return null
  const raw = window.localStorage.getItem(AUTH_STORAGE_KEY)
  if (!raw) return null
  try {
    return JSON.parse(raw) as PersistedAuth
  } catch {
    return null
  }
}

const setAuthHeader = (token: string | null) => {
  if (token) {
    apiClient.defaults.headers.Authorization = `Bearer ${token}`
  } else {
    delete apiClient.defaults.headers.Authorization
  }
}

const secondsToMillis = (seconds?: number) =>
  Math.max((seconds ?? 60) - 30, 5) * 1000

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    accessToken: null,
    user: null,
    isLoading: false
  }),
  getters: {
    isAuthenticated: (state) => Boolean(state.accessToken)
  },
  actions: {
    scheduleRefresh(ttlSeconds?: number) {
      if (typeof window === 'undefined') return
      if (refreshTimer) window.clearTimeout(refreshTimer)
      refreshTimer = window.setTimeout(async () => {
        try {
          await this.refresh()
        } catch {
          this.logout()
        }
      }, secondsToMillis(ttlSeconds))
    },
    async login(credentials: Credentials) {
      this.isLoading = true
      try {
        const { data } = await apiClient.post('/auth/login', credentials)
        const expiresAt = Date.now() + (data.expires_in ?? 3600) * 1000
        this.accessToken = data.access_token
        this.user = data.user
        setAuthHeader(this.accessToken)
        persistAuth({
          accessToken: data.access_token,
          user: data.user,
          expiresAt
        })
        this.scheduleRefresh(data.expires_in)
      } finally {
        this.isLoading = false
      }
    },
    async refresh() {
      if (!this.accessToken) return
      const { data } = await apiClient.post('/auth/refresh')
      const expiresAt = Date.now() + (data.expires_in ?? 3600) * 1000
      this.accessToken = data.access_token
      setAuthHeader(this.accessToken)
      persistAuth(
        this.user
          ? {
              accessToken: data.access_token,
              user: this.user,
              expiresAt
            }
          : null
      )
      this.scheduleRefresh(data.expires_in)
    },
    bootstrap() {
      const payload = readPersistedAuth()
      if (!payload) return
      if (payload.expiresAt <= Date.now()) {
        persistAuth(null)
        return
      }
      this.accessToken = payload.accessToken
      this.user = payload.user
      setAuthHeader(payload.accessToken)
      const remainingSeconds = Math.floor((payload.expiresAt - Date.now()) / 1000)
      this.scheduleRefresh(remainingSeconds)
    },
    async logout() {
      try {
        await apiClient.post('/auth/logout')
      } catch {
        // ignore
      }
      this.accessToken = null
      this.user = null
      setAuthHeader(null)
      persistAuth(null)
      if (refreshTimer) {
        window.clearTimeout(refreshTimer)
        refreshTimer = null
      }
    }
  }
})

