<template>
    <div v-if="products.length > 0" v-for="product in products"
        class="sm:p-2 rounded-2xl sm:shadow-card transition-all duration-300 sm:hover:shadow-hover group">
        <div class="relative overflow-hidden rounded-xl isolate">
            <label
                class="capitalize text-xs font-semibold rounded-xl py-1 px-2 shadow-badge absolute top-3 left-3 z-10 bg-secondary text-white"
                v-if="product.is_offer && product.flash_sale">{{ $t('label.flash_sale') }}</label>


            <img :src="product.cover" alt="product"
                class="w-full rounded-xl transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
        </div>

        <div class="px-1 sm:px-0 pt-4 pb-2">
            <h3
                class="capitalize text-base font-semibold whitespace-nowrap mb-1.5 transition-all duration-300 hover:text-primary overflow-hidden">
                {{ product.name }}
            </h3>

            <div class="flex flex-wrap-reverse items-center gap-x-3 gap-y-1" v-if="product.is_offer">
                <h3 class="text-xl sm:text-[22px] font-bold">
                    <span>{{ product.discounted_price }}</span>
                </h3>
                <h4 class="text-sm sm:text-base font-semibold text-shopperz-red">
                    <del>{{ product.currency_price }}</del>
                </h4>
            </div>
            <h4 class="text-xl sm:text-[22px] font-bold" v-else>
                <span>{{ product.currency_price }}</span>
            </h4>
        </div>
    </div>
</template>

<script>

import starRating from "vue-star-rating";
export default {
    name: "ProductListComponent",
    components: {
        starRating
    },
    props: {
        "products": "object",
    },
    data() {
        return {
            rating: []
        }
    },
    methods: {
    }
}
</script>
