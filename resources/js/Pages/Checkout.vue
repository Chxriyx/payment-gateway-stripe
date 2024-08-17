<script setup>
import { ref, onMounted } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import axios from 'axios';

const loading = ref(false);
let stripe;
let elements;
let card;

const handleCheckout = async () => {
  loading.value = true;
  const { token, error } = await stripe.createToken(card);
  if (error) {
    document.getElementById('card-errors').textContent = error.message;
    loading.value = false;
  } else {
    try {
      await axios.post('/checkout', {
      token: token.id
    }, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });
    } catch (error) {
      console.error('Checkout error:', error);
      document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';
    } finally {
      loading.value = false;
    }
  }
};

onMounted(async () => {
  stripe = await loadStripe('pk_test_51PohAdGQbg3bmGTru8RARDxlIq7gmmIzyX78BO8UMCo3gJU07zKYBjmpJxNoxN533xqTMOH8xULg9yBE8r9vG8ik0096RKMNDn');
  elements = stripe.elements();
  card = elements.create('card');
  card.mount('#card-element');
});
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>
    <form @submit.prevent="handleCheckout">
      <div class="mb-4">
        <label for="card-element" class="block text-sm font-medium text-gray-700">
          Credit or debit card
        </label>
        <div id="card-element">
          <!-- Stripe card element will be inserted here -->
        </div>
        <div id="card-errors" role="alert"></div>
      </div>
      <button
        class="px-4 py-2 bg-blue-500 text-white rounded"
        :disabled="loading"
      >
        {{ loading ? 'Processing...' : 'Pay' }}
      </button>
    </form>
  </div>
</template>
