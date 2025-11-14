<template>
  <MainShell>
    <section class="space-y-6">
      <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
          <h2 class="text-2xl font-semibold">Clientes</h2>
          <p class="text-sm text-slate-400">Gerencie compradores e leads do CRM.</p>
        </div>
        <input
          v-model="filters.search"
          type="search"
          placeholder="Buscar por nome ou e-mail"
          class="rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm outline-none focus:border-teal-400"
        >
      </header>

      <form class="grid gap-4 rounded-2xl border border-white/5 bg-white/5 p-4" @submit.prevent="handleCreate">
        <h3 class="text-lg font-semibold">Adicionar cliente rápido</h3>
        <div class="grid gap-3 md:grid-cols-3">
          <label class="flex flex-col gap-1 text-sm text-slate-300">
            Nome
            <input v-model="form.name" required class="rounded-lg border border-white/10 bg-slate-950/40 px-3 py-2 text-white outline-none focus:border-teal-400">
          </label>
          <label class="flex flex-col gap-1 text-sm text-slate-300">
            E-mail
            <input v-model="form.email" required type="email" class="rounded-lg border border-white/10 bg-slate-950/40 px-3 py-2 text-white outline-none focus:border-teal-400">
          </label>
          <label class="flex flex-col gap-1 text-sm text-slate-300">
            Telefone
            <input v-model="form.phone" class="rounded-lg border border-white/10 bg-slate-950/40 px-3 py-2 text-white outline-none focus:border-teal-400">
          </label>
        </div>
        <button
          type="submit"
          class="w-full rounded-lg bg-teal-500 py-2 font-semibold text-slate-900 transition hover:bg-teal-400 disabled:opacity-60 md:w-auto"
          :disabled="customerStore.isSubmitting"
        >
          {{ customerStore.isSubmitting ? 'Salvando...' : 'Adicionar cliente' }}
        </button>
      </form>

      <div class="rounded-2xl border border-white/5 bg-white/5">
        <table class="w-full text-left text-sm">
          <thead class="text-xs uppercase text-slate-400">
            <tr>
              <th class="px-4 py-3">Nome</th>
              <th class="px-4 py-3">E-mail</th>
              <th class="px-4 py-3">Telefone</th>
              <th class="px-4 py-3">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="customer in customerStore.items"
              :key="customer.id"
              class="border-t border-white/5 text-slate-200"
            >
              <td class="px-4 py-3 font-medium">{{ customer.name }}</td>
              <td class="px-4 py-3 text-slate-400">{{ customer.email }}</td>
              <td class="px-4 py-3 text-slate-400">
                {{ customer.phone ?? '—' }}
              </td>
              <td class="px-4 py-3">
                <span
                  class="rounded-full px-2 py-0.5 text-xs font-semibold uppercase"
                  :class="customer.status === 'active' ? 'bg-teal-500/20 text-teal-300' : 'bg-rose-500/20 text-rose-300'"
                >
                  {{ customer.status }}
                </span>
              </td>
            </tr>
            <tr v-if="!customerStore.items.length && !customerStore.isLoading">
              <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                Nenhum cliente encontrado.
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="customerStore.isLoading" class="p-4 text-sm text-slate-400">
          Carregando clientes...
        </div>
      </div>
    </section>
  </MainShell>
</template>

<script setup lang="ts">
// @ts-ignore - resolved via Vite during compile time
import { reactive, watch } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import MainShell from '@/components/layout/MainShell.vue'
import { useCustomerStore } from '@/stores/useCustomerStore'

const customerStore = useCustomerStore()

const filters = reactive({
  search: ''
})

const form = reactive({
  name: '',
  email: '',
  phone: ''
})

const debouncedFetch = useDebounceFn(() => {
  customerStore.fetch({ search: filters.search })
}, 300)

watch(
  () => filters.search,
  () => debouncedFetch(),
  { immediate: true }
)

const handleCreate = async () => {
  await customerStore.create({
    name: form.name,
    email: form.email,
    phone: form.phone,
    status: 'active'
  })
  form.name = ''
  form.email = ''
  form.phone = ''
}
</script>

