<template>
  <div>
    index

    {{ message }}

    <div><Link href="/hello">show</Link></div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
  message: String,
})
</script>
