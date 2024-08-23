<template>
    <div class="mb-7">
        <div class="py-24 bg-white">
  <div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8 flex flex-col">
    
    <div class="text-center">
      <p class="mt-4 leading-7 font-regular uppercase" style="font-size: 3vw; color: #5681ff;">
        Kohaletoimetamine
      </p>
      
    </div>

    <div class="mt-20">
      <ul class="sm:grid sm:grid-cols-2 md:grid-cols-3 sm:col-gap-10 sm:row-gap-10">
        <li class="p-5 pb-10 text-center" v-if="orderAreas.length > 0" v-for="orderArea in orderAreas" :key="orderArea">
          <div class="flex flex-col items-center">
            <h3 class="mt-2 mb-4 text-5xl leading-6 font-bold" style="color: #5681ff;">
              € {{ orderArea.shipping_cost }}
            </h3>
            <ul class="my-3">
                <li class="my-3 text-base leading-6 text-gray-500">
                    {{ orderArea.country }}
                </li>
              </ul>
            <ul class="my-10">
                <li class="my-3 text-base leading-6" style="color: #213dcb;">
                    Tasuta tarne alates 100 EUR
                </li>
              </ul>
          </div>
        </li>
        
        <li class="p-5 pb-10 text-center">
          <div class="flex flex-col items-center">
            <h3 class="mt-2 mb-4 text-5xl leading-6 font-bold" style="color: #5681ff;">
                € {{ setting.shipping_setup_area_wise_default_cost }}
            </h3>
            <ul class="my-3">
                <li class="my-3 text-base leading-6 text-gray-500">
                    Muud riigid
                </li>
              </ul>
            <ul class="my-10">
                <li class="my-3 text-base leading-6" style="color: #213dcb;">
                    Tasuta tarne alates 100 EUR
                </li>
              </ul>
          </div>
        </li>
      </ul>
    </div>
    
  </div>
</div>
    </div>
</template>

<script>


import statusEnum from "../../../enums/modules/statusEnum";

export default {
    name: "DeliveryComponent",
    computed: {
        orderAreas: function () {
            return this.$store.getters["frontendOrderArea/lists"];
        },
        outlets: function () {
            return this.$store.getters['frontendOutlet/lists'];
        },
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
    },
    mounted() {
      this.$store.dispatch('frontendOutlet/lists', {order_column: 'id', order_type : 'asc', status : statusEnum.ACTIVE }).then().catch();
      this.$store.dispatch('frontendOrderArea/lists', {paginate: 1, page : 1, per_page : 100, order_column : "id", order_type : "desc" }).then().catch();
    },
}
</script>
