<template>
  <div>
    Welcome to the home page

    {{ message }}
  </div>
</template>

<script setup>
defineProps({
  message: String,
})
</script>
