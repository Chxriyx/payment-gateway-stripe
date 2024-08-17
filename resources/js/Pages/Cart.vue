<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  products: Array,
  cart: Object,
});

const updatedProducts = ref([...props.products]);
const updatedCart = ref({ ...props.cart });

const removeFromCart = (productId) => {
  axios.post(route('cart.remove', { product_id: productId }))
    .then(() => {
      delete updatedCart.value[productId];
      updatedProducts.value = updatedProducts.value.filter(product => product.id !== productId);
    })
    .catch(error => {
      console.error('Error removing product:', error);
    });
};

const proceedToCheckout = () => {
  axios.post(route('checkout'));
};

const totalPrice = computed(() => {
  return updatedProducts.value.reduce((total, product) => {
    return total + (product.price * updatedCart.value[product.id]);
  }, 0);
});
</script>

<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-center">Shopping Cart</h1>
    <div v-if="updatedProducts.length" class="space-y-6">
      <div
        v-for="product in updatedProducts"
        :key="product.id"
        class="p-6 border rounded-lg shadow-lg flex justify-between items-center"
      >
        <div>
          <h2 class="text-xl font-semibold text-gray-800">{{ product.name }}</h2>
          <p class="text-gray-600">{{ product.description }}</p>
          <p class="text-lg font-bold text-blue-600">${{ product.price }}</p>
          <p class="mt-2">Quantity: {{ updatedCart[product.id] }}</p>
        </div>
        <button
          @click="removeFromCart(product.id)"
          class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors duration-300"
        >
          Remove
        </button>
      </div>
      <div class="text-right mt-6">
        <p class="text-xl font-bold">Total: ${{ totalPrice }}</p>
        <button
          @click="proceedToCheckout"
          class="mt-4 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors duration-300"
        >
          Proceed to Checkout
        </button>
      </div>
    </div>
    <p v-else class="text-center text-gray-500">Your cart is empty.</p>
  </div>
</template>
