<template>
  <div class="flex min-h-screen items-center justify-center bg-slate-950 p-6">
    <form class="w-full max-w-sm space-y-4 rounded-2xl bg-slate-900 p-6 shadow-xl" @submit.prevent="handleSubmit">
      <h1 class="text-2xl font-semibold text-white">Entrar</h1>

      <label class="block">
        <span class="text-sm text-slate-300">E-mail</span>
        <input v-model="form.email" type="email" required class="mt-1 w-full rounded-md border border-slate-700 bg-slate-800 px-3 py-2 text-white focus:border-teal-400 focus:outline-none">
      </label>

      <label class="block">
        <span class="text-sm text-slate-300">Senha</span>
        <input v-model="form.password" type="password" required class="mt-1 w-full rounded-md border border-slate-700 bg-slate-800 px-3 py-2 text-white focus:border-teal-400 focus:outline-none">
      </label>

      <button type="submit" :disabled="authStore.isLoading" class="w-full rounded-md bg-teal-500 px-3 py-2 font-semibold text-slate-900 transition hover:bg-teal-400 disabled:cursor-not-allowed disabled:opacity-60">
        {{ authStore.isLoading ? 'Autenticando...' : 'Entrar' }}
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { useAuthStore } from '@/stores/useAuthStore'
import { useRouter } from 'vue-router'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  email: '',
  password: ''
})

const handleSubmit = async () => {
  await authStore.login(form)
  router.push('/')
}
</script>

