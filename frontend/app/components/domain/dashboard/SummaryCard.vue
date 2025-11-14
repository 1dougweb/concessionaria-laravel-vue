<template>
  <article class="rounded-2xl border border-white/5 bg-white/5 p-4">
    <p class="text-sm text-slate-300">{{ label }}</p>
    <p class="mt-2 text-3xl font-semibold">{{ value }}</p>
  </article>
</template>

<script setup lang="ts">
defineProps<{
  label: string
  value: number
}>()
</script>

