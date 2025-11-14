/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_API_BASE_URL: string
  readonly VITE_ECHO_KEY: string
  readonly VITE_ECHO_HOST: string
  readonly VITE_ECHO_PORT: string
  readonly VITE_ECHO_TLS: string
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}

