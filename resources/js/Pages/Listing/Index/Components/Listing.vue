<template>
  <Box>
    <div>
      <Link :href="route('listing.show', {listing:listing.id })">
        <div class="flex items-center gap-1">
          <Price
            :price="listing.price"
            string-style="currency"
            currency="USD"
            :maximum-fraction-digits="0"
            class="text-2xl font-bold"
          />
          <div class="text-xs text-gray-500">
            <Price :price="monthlyPayment" /> /Month
          </div>
        </div>

        <ListingSpecs :listing="listing" class="text-lg" />
        <ListingAddress :listing="listing" class="text-gray-500" />
      </Link>
    </div>
  </Box>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue'
import Price from '@/Components/Price.vue'
import Box from '@/Components/UI/Box.vue'
import ListingSpecs from '@/Components/UI/ListingSpecs.vue'
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const props = defineProps({
  listing: Object,
})

const page = usePage()
const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 20 )
const user = computed(() => page.props.user)

</script>
