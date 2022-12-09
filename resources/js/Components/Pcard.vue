<script setup>

defineProps({
    order_id: String,
    product_name: String,
    product_description: String,
    price: Number,
});
</script>

<template>
<div class="rounded border md:shadow w-full overflow-hidden" dir="rtl">
  <div>
    <a href="#">
      <img class="object-cover" src="https://images.unsplash.com/photo-1461141346587-763ab02bced9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=80" alt="card 1" />
    </a>
  </div>

  <div class="px-4 py-4">
    <h2 class="font-semibold text-gray-900 mb-2 truncate">
        شناسه سفارش: <span dir="ltr"> #{{order_id}} </span>
    </h2>
    <h3 class="font-semibold text-gray-900 mb-2 truncate">
        {{product_name}}
    </h3>

    <div class="text-sm text-gray-800">
      {{product_description}}
    </div>

    <div class="text-right mt-2">
      <h5 class="py-2 text-indigo-600 text-xs uppercase hover:underline">قیمت
        <span>{{price}} تومان </span>
    </h5>
    </div>
  </div>
</div>
</template>
