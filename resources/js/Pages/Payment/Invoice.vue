<template>
    <GuestLayout>
        <h2 dir="rtl" class="font-semibold text-gray-900 mb-2 mt-5 truncate">
            کد رهگیری تراکنش : <span dir="ltr"> #{{tracking_code}} </span>
        </h2>

        <Pcard
            :order_id="order_id"
            :price="price"
            :product_name="product_name"
            :product_description="product_description"></Pcard>

        <p dir="rtl" class="text-blue-600 md:text-green-600 mt-3" >
            {{message}}
        </p>

    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Pcard from '@/Components/Pcard.vue';

const props = defineProps({
    order_id: String,
    product_name: String,
    product_description: Number,
    price: String,
    tracking_code: String,
    message: String,
});
</script>
