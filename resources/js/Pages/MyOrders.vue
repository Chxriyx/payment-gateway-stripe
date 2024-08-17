<script setup>
const props = defineProps({
  orders: Array,
});
</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6">My Orders</h1>
    <div v-if="orders.length" class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="py-3 px-5 text-left text-sm font-semibold uppercase tracking-wide">Order ID</th>
            <th class="py-3 px-5 text-left text-sm font-semibold uppercase tracking-wide">Products</th>
            <th class="py-3 px-5 text-left text-sm font-semibold uppercase tracking-wide">Total Amount</th>
            <th class="py-3 px-5 text-left text-sm font-semibold uppercase tracking-wide">Order Date</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-100 transition duration-150">
            <td class="py-4 px-5 border-b border-gray-200">{{ order.id }}</td>
            <td class="py-4 px-5 border-b border-gray-200">
              <ul class="pl-5">
                <li v-for="product in order.products" :key="product.name">
                  <span class="font-semibold">{{ product.name }}</span>
                  <span class="ml-2 text-gray-600">x{{ product.quantity }}</span>
                  <span class="ml-4 text-gray-800">${{ parseFloat(product.price).toFixed(2) }}</span>
                </li>
              </ul>
            </td>
            <td class="py-4 px-5 border-b border-gray-200">${{ parseFloat(order.total_amount).toFixed(2) }}</td>
            <td class="py-4 px-5 border-b border-gray-200">{{ new Date(order.created_at).toLocaleDateString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else class="text-center text-gray-500 mt-6">You have no orders.</p>
  </div>
</template>
