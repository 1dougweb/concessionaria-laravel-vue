declare module '@vitejs/plugin-vue' {
  import { Plugin } from 'vite'
  export default function vuePlugin(...args: unknown[]): Plugin
}

declare module 'aria-query' {
  const value: unknown
  export default value
}

