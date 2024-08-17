<script setup>
import {  useForm, Link, router } from "@inertiajs/vue3";
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';


const props = defineProps({
  products: Array,
  canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const form = useForm({
    _method: 'POST',
});

const addToCart = (productId) => {
  form.post(route('cart.add', { product_id: productId }));
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
  <div class="container mx-auto p-6">
    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                          <form v-if="$page.props.auth.user" method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('orders.index')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                        >
                            My Orders
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
    <h1 class="text-3xl font-bold mb-8 text-center">Explore Our Products</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <div
        v-for="product in products"
        :key="product.id"
        class="p-6 border rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
      >
        <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ product.name }}</h2>
        <p class="text-gray-600 mb-4">{{ product.description }}</p>
        <p class="text-lg font-bold text-blue-600 mb-4">${{ product.price }}</p>
        <button
          @click="addToCart(product.id)"
          class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors duration-300"
        >
          Add to Cart
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 1200px;
}
</style>
