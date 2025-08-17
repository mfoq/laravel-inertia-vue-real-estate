<template>
  <span>{{ formattedPrice }}</span>
</template>

<script setup>
import { computed } from 'vue'


const props = defineProps({
  price: [Number, String],
  stringStyle:{
    type: String,
    default: 'currency',
  },
  currency:{
    type: String,
    default: 'USD',
  },
  maximumFractionDigits:{
    type: Number,
    default: 0,
  },
})

const formattedPrice = computed(
  () => Number(props.price).toLocaleString('en-US', {
    style : props.stringStyle,
    currency : props.currency,
    maximumFractionDigits: props.maximumFractionDigits,
  }),
)

</script>
