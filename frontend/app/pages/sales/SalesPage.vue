<template>
  <MainShell>
    <section class="space-y-6">
      <header class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Vendas</h2>
        <button
          class="rounded-lg border border-white/10 px-3 py-1.5 text-sm text-slate-300 hover:border-teal-400 hover:text-teal-200"
          @click="salesStore.fetch()"
        >
          Atualizar
        </button>
      </header>

      <ul class="space-y-3 pt-2">
        <li
          v-for="sale in salesStore.items"
          :key="sale.id"
          class="rounded-2xl border border-white/5 bg-white/5 p-4"
        >
          <div class="flex flex-col justify-between gap-2 md:flex-row md:items-center">
            <div>
              <p class="text-xs uppercase text-slate-400">Status</p>
              <p class="text-sm font-semibold text-white">{{ sale.status }}</p>
              <p class="text-xs text-slate-500">ID: {{ sale.id }}</p>
            </div>
            <div class="text-right">
              <p class="text-xs uppercase text-slate-400">Total</p>
              <p class="text-2xl font-semibold text-teal-300">{{ currencyFormatter.format(sale.total_amount) }}</p>
            </div>
          </div>
          <div class="mt-4 flex flex-wrap gap-2">
            <button
              class="rounded-lg border border-white/10 px-3 py-1 text-xs uppercase tracking-wide text-slate-300 hover:border-teal-400 hover:text-teal-200 disabled:opacity-60"
              :disabled="salesStore.isMutating || sale.status === 'completed'"
              @click="finalizeSale(sale.id)"
            >
              Finalizar venda
            </button>
          </div>
        </li>
        <li v-if="!salesStore.items.length && !salesStore.isLoading" class="rounded-2xl border border-white/5 bg-white/5 p-6 text-center text-slate-400">
          Nenhuma venda registrada.
        </li>
        <li v-if="salesStore.isLoading" class="rounded-2xl border border-white/5 bg-white/5 p-6 text-center text-slate-400">
          Carregando vendas...
        </li>
      </ul>
    </section>
  </MainShell>
</template>

<script setup lang="ts">
import MainShell from '@/components/layout/MainShell.vue'
import { useSalesStore } from '@/stores/useSalesStore'

const salesStore = useSalesStore()
const currencyFormatter = new Intl.NumberFormat('pt-BR', {
  style: 'currency',
  currency: 'BRL'
})

const finalizeSale = async (saleId: string) => {
  await salesStore.finalize(saleId, { status: 'completed' })
}

salesStore.fetch()
</script>

