<template>
    <dl v-if="variations.length > 0" class="flex flex-wrap items-center gap-x-6 gap-y-3 mb-6">
        <dt v-for="variationLabel in variations.slice(0, 1)" :key="variationLabel" class="capitalize text-lg font-semibold">
            <div v-if="language == 1">
                {{ variationLabel.product_attribute_name }}:
            </div>
            <div v-else-if="language == 2">
                <span v-if="variationLabel.product_attribute_name_et !== null && variationLabel.product_attribute_name_et !== ''">
                    {{ variationLabel.product_attribute_name_et }}:
                </span>
                <span v-else>
                    {{ variationLabel.product_attribute_name }}:
                </span>
            </div>
            <div v-else-if="language == 3">
                <span v-if="variationLabel.product_attribute_name_ru !== null && variationLabel.product_attribute_name_ru !== ''">
                    {{ variationLabel.product_attribute_name_ru }}:
                </span>
                <span v-else>
                    {{ variationLabel.product_attribute_name }}:
                </span>
            </div>
            <div v-else>
                {{ variationLabel.product_attribute_name }}:
            </div>
        </dt>
        <dd class="flex flex-wrap items-center gap-3">
            <div v-for="(variation, index) in variations" :key="index">
                <button 
                    v-if="language == 1"
                    @click="selectVariation(variation)" 
                    :class="selectedVariationId === variation.id ? 'text-white bg-primary' : ''" 
                    type="button" 
                    class="px-3 h-8 leading-8 text-center rounded-full text-sm font-medium capitalize flex-shrink-0 cursor-pointer text-secondary bg-[#F7F7FC]"
                >
                    {{ variation.product_attribute_option_name }}
                </button>
                <button 
                    v-else-if="language == 2"
                    @click="selectVariation(variation)" 
                    :class="selectedVariationId === variation.id ? 'text-white bg-primary' : ''" 
                    type="button" 
                    class="px-3 h-8 leading-8 text-center rounded-full text-sm font-medium capitalize flex-shrink-0 cursor-pointer text-secondary bg-[#F7F7FC]"
                >
                    <span v-if="variation.product_attribute_option_name_et !== null && variation.product_attribute_option_name_et !== ''">
                        {{ variation.product_attribute_option_name_et }}
                    </span>
                    <span v-else>
                        {{ variation.product_attribute_option_name }}
                    </span>
                </button>
                <button 
                    v-else-if="language == 3"
                    @click="selectVariation(variation)" 
                    :class="selectedVariationId === variation.id ? 'text-white bg-primary' : ''" 
                    type="button" 
                    class="px-3 h-8 leading-8 text-center rounded-full text-sm font-medium capitalize flex-shrink-0 cursor-pointer text-secondary bg-[#F7F7FC]"
                >
                    <span v-if="variation.product_attribute_option_name_ru !== null && variation.product_attribute_option_name_ru !== ''">
                        {{ variation.product_attribute_option_name_ru }}
                    </span>
                    <span v-else>
                        {{ variation.product_attribute_option_name }}
                    </span>
                </button>
                <button 
                    v-else
                    @click="selectVariation(variation)" 
                    :class="selectedVariationId === variation.id ? 'text-white bg-primary' : ''" 
                    type="button" 
                    class="px-3 h-8 leading-8 text-center rounded-full text-sm font-medium capitalize flex-shrink-0 cursor-pointer text-secondary bg-[#F7F7FC]"
                >
                    {{ variation.product_attribute_option_name }}
                </button>
            </div>
        </dd>
    </dl>

    <VariationComponent :method="getFinalVariationId" :key="selectedVariations" v-if="selectedVariations.length > 0" :variations="selectedVariations" :language="language" />

</template>

<script>

export default {
    name : "VariationComponent",
    props: {
        variations:{
            type: Object,
            required: true
        },
        method:{
            type: Function,
            required: true
        },
        language:{
            type: Number,
            required: false
        },
    },
    data() {
        return {
            selectedVariationId : null,
            selectedVariations : [],
            finalSelectedVariation: null
        }
    },
    methods: {
        selectVariation: function(variation) {
            this.selectedVariationId = variation.id;

            if(!variation.sku) {
                this.finalSelectedVariation = null;
                this.getFinalVariationId(this.finalSelectedVariation);
            } else {
                this.finalSelectedVariation = variation;
                this.getFinalVariationId(this.finalSelectedVariation);
            }

            this.$store.dispatch("frontendProductVariation/childrenVariation", this.selectedVariationId).then((res) => {
                this.selectedVariations = res.data.data;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        getFinalVariationId: function(id) {
            this.method(id);
        }
    }
}
</script>