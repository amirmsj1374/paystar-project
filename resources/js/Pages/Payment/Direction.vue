<template>
    <GuestLayout>
        <p dir="rtl" class="block font-medium text-md text-gray-700">
            <span class="font-large text-large text-red-500">
                {{timer}}
            </span>
            ثانیه دیگر به درگاه پرداخت منتقل می شوید
        </p>
        <form id="payment" action="https://core.paystar.ir/api/pardakht/payment" method="get">
            <input type="hidden" name="token" :value="token">
        </form>
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
    props: [
        'token'
    ],
    components: {
        GuestLayout
    },
    data() {
        return {
            timer: 10,
        }
    },
    methods: {
        startTimer() {
            setInterval(() => {
                if (this.timer !== 0) {
                    this.timer--
                } else {
                    document.getElementById("payment").submit();
                }
            }, 1000)
        }
    },
    mounted () {
        this.startTimer()
    }
}
</script>
