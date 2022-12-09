<template>
<GuestLayout>
    <Pcard
        :order_id="order_id"
        :price="price"
        :product_name="product_name"
        :product_description="product_description"></Pcard>

    <form @submit.prevent="submit">
                <div class="mt-4">
                <InputLabel for="card_number" value="شماره کارت"  dir="rtl" />
                <TextInput
                    id="card_number"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.card_number"
                    required
                />

                    <InputError class="mt-2" :message="form.errors.card_number" />
                </div>
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    پرداخت
                </PrimaryButton>
            <button type="submit" class="btn btn-primary mt-3"></button>
        <!-- </div> -->
    </form>
</GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Pcard from '@/Components/Pcard.vue';
import { useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        order_id: String,
        product_name: String,
        product_description: String,
        price: Number,
        gateway: String
    });

    const form = useForm({
        card_number: '',
        order_id: props.order_id,
        price: props.price,
        gateway: props.gateway,
    });

    const submit = () => {
    form.post(route('payment.create'), {
        onFinish: () => form.reset('card_number'),
    });
};
</script>
