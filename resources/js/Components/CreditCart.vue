<script setup>
// import CreditCardInputMask from "credit-card-input-mask";

// const formattedCreditCardInput = new CreditCardInputMask({
//   element: document.querySelector("#credit-card"),
//   pattern: "{{9999}} {{9999}} {{9999}} {{9999}}",
// });
import {ref} from 'vue';

const value = ref('11111111');
const mask = ref('{{9999}} {{9999}}');
</script>

<template>
    <input id="credit-card" type="text" v-mask="mask" :value="value">
</template>

