<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()
const order = ref(props.order || null)
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center animate-fadeIn">
            <div class="text-green-500 mb-4">
                <!-- Success Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-5.293a1 1 0 011.414 0l3-3a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414l1.293 1.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
            <p class="text-gray-600 mb-6">
                Thank you for your purchase. Your order has been successfully placed.
            </p>
            <div v-if="order">
                <h2 class="text-xl font-semibold text-gray-800">Order Details</h2>
                <p class="text-gray-600">Order ID: {{ order.id }}</p>
                <p class="text-gray-600">Total Amount: ${{ order.total_amount.toFixed(2) }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-in-out;
}
</style>
