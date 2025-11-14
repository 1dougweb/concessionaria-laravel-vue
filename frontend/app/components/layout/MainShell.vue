<template>
  <div class="min-h-screen bg-slate-950 text-white">
    <header class="flex items-center justify-between border-b border-white/5 px-6 py-4">
      <h1 class="text-lg font-semibold">Concessionária</h1>
      <button class="text-sm text-slate-300" @click="authStore.logout">Sair</button>
    </header>
    <main class="mx-auto max-w-6xl space-y-6 px-6 py-10">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
import { onMounted, watch } from 'vue'
import { useAuthStore } from '@/stores/useAuthStore'
import { useNotificationStore } from '@/stores/useNotificationStore'

const authStore = useAuthStore()
const notificationStore = useNotificationStore()

const bootNotifications = () => {
  const userId = authStore.user?.id as number | undefined
  if (userId) notificationStore.boot(userId)
}

onMounted(bootNotifications)

watch(
  () => authStore.user,
  () => bootNotifications()
)
</script>

