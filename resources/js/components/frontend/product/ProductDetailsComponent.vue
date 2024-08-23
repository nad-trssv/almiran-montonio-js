<template>
    <LoadingComponent :props="loading"/>
    <section class="mb-12">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <CategoryBreadcrumbComponent :categories="categories" :language="language.id" />
                </div>

                <div v-if="images.length" class="col-12 sm:col-6 lg:col-5">
                    <Swiper dir="ltr" :spaceBetween="10" :navigation="true" :thumbs="{ swiper: thumbsSwiper }"
                            :modules="modules" class="gallery-swiper">
                        <SwiperSlide v-for="(image, index) in images" :key="index" class="w-full">
                            <inner-image-zoom :src="image" :zoomSrc="image" :zoomScale='1' zoomType="hover"  :hideHint='true'/>
                        </SwiperSlide>
                    </Swiper>

                    <Swiper dir="ltr" @swiper="setThumbsSwiper" :spaceBetween="12" :slidesPerView="4" :freeMode="true"
                            :watchSlidesProgress="true" :modules="modules" class="thumb-swiper">
                        <SwiperSlide v-for="(image, index) in images" :key="index"
                                     class="w-full cursor-pointer rounded-lg border border-gray-200 transition-all duration-500">
                            <img class="w-full rounded-lg border-2 border-gray-200 transition-all duration-500"
                                 :src="image" alt="gallery"/>
                        </SwiperSlide>
                    </Swiper>
                </div>

                <div v-else class="col-12 sm:col-6 lg:col-5">
                    <img :src="product.image" alt="products" class="w-full rounded-2xl">
                </div>

                <div class="col-12 sm:col-6 lg:col-7 lg:pl-10">
                    <h2 class="text-3xl sm:text-4xl font-bold capitalize mb-5" v-if="language.id == 1">{{ product.name }}</h2>
                    <h2 class="text-3xl sm:text-4xl font-bold capitalize mb-5" v-else-if="language.id == 2">
                        <span v-if="product.name_et !== null && product.name_et !== ''">
                            {{ product.name_et }}
                        </span>
                        <span v-else>
                            {{ product.name }}
                        </span>
                    </h2>
                    <h2 class="text-3xl sm:text-4xl font-bold capitalize mb-5" v-else-if="language.id == 3">
                        <span v-if="product.name_ru !== null && product.name_ru !== ''">
                            {{ product.name_ru }}
                        </span>
                        <span v-else>
                            {{ product.name }}
                        </span>
                    </h2>
                    <h2 class="text-3xl sm:text-4xl font-bold capitalize mb-5" v-else>{{ product.name }}</h2>
                    <h3 class="flex items-start gap-4 mb-5">
                        <span class="text-2xl font-bold"> 
                            {{
                                currencyFormat(temp.price, setting.site_digit_after_decimal_point,
                                    setting.site_default_currency_symbol, setting.site_currency_position)
                            }}
                        </span>
                        <del v-if="product.is_offer" class="text-lg font-bold text-shopperz-red">
                            {{
                                currencyFormat(temp.oldPrice, setting.site_digit_after_decimal_point,
                                    setting.site_default_currency_symbol, setting.site_currency_position)
                            }}
                        </del>
                    </h3>

                    <VariationComponent v-if="initialVariations.length > 0 && variationComponent"
                                        :method="selectedVariationMethod"
                                        :variations="initialVariations"
                                        :language="language.id" />

                    <dl class="flex flex-wrap items-center gap-x-6 gap-y-3 mb-8">
                        <dt class="capitalize text-lg font-semibold">{{ $t('label.quantity') }}:</dt>
                        <dd class="flex items-center gap-6">
                            <div class="flex items-center gap-1 w-20 p-1 rounded-full bg-[#F7F7FC]">
                                <button @click.prevent="quantityDecrement" type="button"
                                        :class="temp.quantity === 1 ? 'cursor-not-allowed': ''"
                                        class="lab-fill-circle-minus text-lg leading-none transition-all duration-300 hover:text-primary"></button>
                                <input type="number" v-model="temp.quantity" v-on:keypress="onlyNumber($event)"
                                       v-on:keyup="quantityUp" class="text-center w-full h-5 text-sm font-medium">
                                <button @click.prevent="quantityIncrement" type="button"
                                        :class="temp.stock === temp.quantity ? 'cursor-not-allowed': ''"
                                        class="lab-fill-circle-plus text-lg leading-none transition-all duration-300 hover:text-primary"></button>
                            </div>
                            <div v-if="!initialVariations.length || selectedVariation != null">
                                <p v-if="temp.stock < 4 && temp.stock > 0" class="capitalize text-danger">
                                    {{ $t('label.available') }}:
                                    <bold>{{ temp.stock }}</bold>
                                </p>
                                <p v-else-if="temp.stock <= 0" class="capitalize text-danger">
                                    {{ $t('label.stock_out') }}
                                </p>
                                <p v-else></p>
                            </div>
                        </dd>
                    </dl>

                    <dl v-if="temp.quantity > 1" class="flex flex-wrap items-center gap-x-6 gap-y-3 mb-8">
                        <dt class="capitalize text-lg font-semibold">{{ $t('label.total_price') }}:</dt>
                        <dd class="flex items-center gap-6 text-green-500 font-semibold text-lg">
                            {{
                                currencyFormat(temp.totalPrice, setting.site_digit_after_decimal_point,
                                    setting.site_default_currency_symbol, setting.site_currency_position)
                            }}
                        </dd>
                    </dl>

                    <div class="flex flex-wrap items-center gap-8 mb-10">
                        <button @click.prevent="addToCart" :disabled="enableAddToCardButton" type="button"
                                :class="enableAddToCardButton === false ? 'shadow-btn-primary !bg-primary' : ''"
                                class="flex items-center gap-3 px-8 h-12 leading-12 rounded-full transition-all duration-500 bg-slate-400 text-white">
                            <i class="lab-line-bag text-xl"></i>
                            <span class="whitespace-nowrap font-bold">{{ $t("button.add_to_cart") }}</span>
                        </button>
                        <button type="button"
                                @click="wishlist(product.wishlist = !product.wishlist)"
                                :class="product.wishlist ? 'text-primary' : 'text-secondary'"
                                class="flex items-center gap-3 px-8 h-12 leading-12 rounded-full transition-all duration-500 shadow-btn-secondary bg-white">
                            <i :class="product.wishlist ? 'lab-fill-heart' : 'lab-line-heart'"
                               class="lab-line-heart text-xl"></i>
                            <span class="whitespace-nowrap font-bold">{{ $t('button.favorite') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="rounded-[32px] border border-[#D9DBE9]">
                        <nav class="flex flex-wrap items-center p-4 sm:py-6 sm:px-8 gap-3 sm:gap-6">

                            <button type="button"
                                    @click.prevent="multiTargets($event, 'tab-btn', 'tab-div', 'tab_shipping_and_return')"
                                    class="tab-btn active text-sm sm:text-base font-bold leading-5 capitalize py-2 sm:py-3.5 px-5 sm:px-8 rounded-full border border-[#D9DBE9]">
                                {{ $t('label.product_shipping_and_return') }}
                            </button>
                            
                            <button type="button"
                                    @click.prevent="multiTargets($event, 'tab-btn', 'tab-div', 'tab_details')"
                                    class="tab-btn text-sm sm:text-base font-bold leading-5 capitalize py-2 sm:py-3.5 px-5 sm:px-8 rounded-full border border-[#D9DBE9]">
                                {{ $t('label.details') }}
                            </button>

                            <button type="button"
                                    @click.prevent="multiTargets($event, 'tab-btn', 'tab-div', 'tab_videos')"
                                    class="tab-btn text-sm sm:text-base font-bold leading-5 capitalize py-2 sm:py-3.5 px-5 sm:px-8 rounded-full border border-[#D9DBE9]">
                                {{ $t('label.videos') }}
                            </button>
                        </nav>

                        <div v-if="language.id == 1 && product.shipping_and_return !== null" id="tab_shipping_and_return" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9] active" >
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_shipping_and_return') }}</h3>
                            <table class="w-full text-sm text-left text-primary">
                                <thead>
                                <tr>
                                    <th v-for="(entry, index) in product.shipping_and_return[0].string.length"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(entrycol, indexcol) in product.shipping_and_return.length">
                                    <td v-for="(entry, index) in product.shipping_and_return[0].string.length" class="text-center bg-white cursor-pointer border-primary border">
                                        {{ product.shipping_and_return[indexcol].string[index] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else-if="language.id == 3 && product.shipping_and_return_ru !== null" id="tab_shipping_and_return" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9] active">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_shipping_and_return') }}</h3>
                            <table class="w-full text-sm text-left text-primary">
                                <thead>
                                <tr>
                                    <th v-for="(entry, index) in product.shipping_and_return_ru[0].string.length"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(entrycol, indexcol) in product.shipping_and_return_ru.length">
                                    <td v-for="(entry, index) in product.shipping_and_return_ru[0].string.length" class="text-center bg-white cursor-pointer border-primary border">
                                        {{ product.shipping_and_return_ru[indexcol].string[index] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else-if="language.id == 2 && product.shipping_and_return_et !== null" id="tab_shipping_and_return" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9] active">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_shipping_and_return') }}</h3>
                            <table class="w-full text-sm text-left text-primary">
                                <thead>
                                <tr>
                                    <th v-for="(entry, index) in product.shipping_and_return_et[0].string.length"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(entrycol, indexcol) in product.shipping_and_return_et.length">
                                    <td v-for="(entry, index) in product.shipping_and_return_et[0].string.length" class="text-center bg-white cursor-pointer border-primary border">
                                        {{ product.shipping_and_return_et[indexcol].string[index] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else-if=" product.shipping_and_return !== null" id="tab_shipping_and_return" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9] active">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_shipping_and_return') }}</h3>
                            <table class="w-full text-sm text-left text-primary">
                                <thead>
                                <tr>
                                    <th v-for="(entry, index) in product.shipping_and_return[0].string.length"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(entrycol, indexcol) in product.shipping_and_return.length">
                                    <td v-for="(entry, index) in product.shipping_and_return[0].string.length" class="text-center bg-white cursor-pointer border-primary border">
                                        {{ product.shipping_and_return[indexcol].string[index] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else id="tab_shipping_and_return" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9] active">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_shipping_and_return') }}</h3>
                                {{ $t('label.nosizes') }}
                        </div>

                        <div id="tab_details" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9]">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_details') }}
                            </h3>
                            <div class="text-description" v-html="product.details" v-if="language.id == 1"></div>
                            <div class="text-description" v-html="product.details_et" v-else-if="language.id == 2"></div>
                            <div class="text-description" v-html="product.details_ru" v-else-if="language.id == 3"></div>
                            <div class="text-description" v-html="product.details" v-else></div>
                        </div>

                        <div id="tab_videos" class="tab-div p-4 sm:p-8 sm:pt-6 border-t border-[#D9DBE9]">
                            <h3 class="capitalize text-2xl sm:text-3xl font-bold mb-4">
                                {{ $t('label.product_videos') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <iframe v-for="video in videos" :src="video.link"
                                        class="w-full h-40 sm:h-64 rounded-2xl"></iframe>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <section v-if="relatedProducts.length > 0" class="mb-10 sm:mb-20">
        <div class="container">
            <div class="flex items-center justify-between gap-4 mb-5 sm:mb-7">
                <h2 class="text-2xl sm:text-4xl font-bold capitalize">
                    {{ $t('label.related_products') }}
                </h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <ProductListComponent v-if="relatedProducts.length > 0" :products="relatedProducts"/>
            </div>
        </div>
    </section>

</template>
<style>
.shipping_and_return__table table td {
    border: 1px solid #dfdfdf;
    padding: 3px 10px;
}
.shipping_and_return__table table {
    width: 100%;
}
</style>
<script>
import {ref} from "vue";
import {Swiper, SwiperSlide} from 'swiper/vue';
import {FreeMode, Navigation, Thumbs} from 'swiper/modules';
import LoadingComponent from "../components/LoadingComponent";
import targetService from "../../../services/targetService";
import router from "../../../router";
import CategoryBreadcrumbComponent from "../components/CategoryBreadcrumbComponent";
import ProductListComponent from "../components/ProductListComponent";
import VariationComponent from "../components/VariationComponent";
import appService from "../../../services/appService";
import alertService from "../../../services/alertService";
import { useHead } from '@vueuse/head';
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';

import InnerImageZoom from 'vue-inner-image-zoom';

export default {
    name: "ProductDetailsComponent",
    components: {
        VariationComponent,
        ProductListComponent,
        CategoryBreadcrumbComponent,
        Swiper,
        SwiperSlide,
        LoadingComponent,
        'inner-image-zoom': InnerImageZoom
    },
    setup() {
        const thumbsSwiper    = ref(null);
        const setThumbsSwiper = (swiper) => {
            thumbsSwiper.value = swiper;
        };
        return {
            thumbsSwiper,
            setThumbsSwiper,
            modules: [FreeMode, Navigation, Thumbs],
        }
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            props: {
                search: {
                    slug: null,
                    review_limit: 3
                }
            },
            enableAddToCardButton: true,
            selectedVariation: null,
            productArray: {},
            variationComponent: false,
            initProduct: {
                isVariation: false,
                variationId: null,
                sku: null,
                stock: 0,
                quantity: 1,
                discount: 0,
                price: 0,
                oldPrice: 0,
                totalPrice: 0
            },
            temp: {
                name: "",
                image: "",
                isVariation: false,
                variationId: null,
                productId: 0,
                sku: null,
                stock: 0,
                taxes: {},
                shipping: {},
                quantity: 1,
                discount: 0,
                price: 0,
                oldPrice: 0,
                totalPrice: 0
            },
        }
    },
    computed: {
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
        categories: function () {
            return this.$store.getters["frontendProductCategory/ancestorsAndSelf"];
        },
        initialVariations: function () {
            return this.$store.getters["frontendProductVariation/initialVariation"];
        },
        product: function () {
            return this.$store.getters["frontendProduct/show"];
        },
        images: function () {
            return this.$store.getters["frontendProduct/showImages"];
        },
        videos: function () {
            return this.$store.getters["frontendProduct/showVideos"];
        },
        relatedProducts: function () {
            return this.$store.getters["frontendProduct/relatedProducts"];
        },
        language: function () {
            return this.$store.getters['frontendLanguage/show'];
        },
    },
    mounted() {
        this.show();
        this.showRelatedProduct();
    },
    methods: {
        onlyNumber: function (e) {
            return appService.onlyNumber(e);
        },
        currencyFormat: function (amount, decimal, currency, position) {
            return appService.currencyFormat(amount, decimal, currency, position);
        },
        multiTargets: function (event, commonBtnClass, commonDivClass, targetID) {
            targetService.multiTargets(event, commonBtnClass, commonDivClass, targetID)
        },
        wishlist: function (toggle) {
            this.$store.dispatch("frontendWishlist/toggle", {
                product_id: this.product.id,
                toggle: toggle
            }).then((res) => {
            }).catch((err) => {
                if (err.response.status === 401) {
                    this.product.wishlist = false;
                    router.push({name: "auth.login"});
                }
            });
        },
        readMore: function () {
            this.props.search.review_limit += 1;
            this.show();
        },
        show: function () {
            if (typeof this.$route.params.slug !== "undefined") {
                this.loading.isActive  = true;
                this.props.search.slug = this.$route.params.slug;
                this.$store.dispatch("frontendProduct/show", this.props.search).then((res) => {
                    this.initProduct = {
                        isVariation: false,
                        variationId: null,
                        sku: res.data.data.sku,
                        stock: res.data.data.stock,
                        quantity: 1,
                        discount: 0,
                        price: res.data.data.price,
                        oldPrice: res.data.data.old_price,
                        totalPrice: res.data.data.price
                    };
                    this.temp = {
                        name: res.data.data.name,
                        name_et: res.data.data.name_et,
                        name_ru: res.data.data.name_ru,
                        image: res.data.data.image,
                        isVariation: false,
                        variationId: null,
                        productId: res.data.data.id,
                        sku: res.data.data.sku,
                        stock: res.data.data.stock,
                        taxes: res.data.data.taxes,
                        shipping: res.data.data.shipping,
                        quantity: 1,
                        discount: 0,
                        price: res.data.data.price,
                        oldPrice: res.data.data.old_price,
                        totalPrice: res.data.data.price
                    };

                    this.$store.dispatch("frontendProductCategory/ancestorsAndSelf", res.data.data.category_slug).then((categoryRes) => {
                        this.loading.isActive = false;
                    }).catch((err) => {
                        this.loading.isActive = false;
                    });

                    this.$store.dispatch("frontendProductVariation/initialVariation", res.data.data.id).then((initVariationRes) => {
                        if (initVariationRes.data.data.length > 0) {
                            this.variationComponent = true;
                        }

                        if (!initVariationRes.data.data.length && res.data.data.stock > 0) {
                            this.enableAddToCardButton = false;
                        }
                        this.loading.isActive = false;
                    }).catch((err) => {
                        this.loading.isActive = false;
                    });

                    if(Object.keys(res.data.data.seo) && res.data.data.seo.title && res.data.data.seo.description) {
                        let metaData = [
                            { name: 'title', content: res.data.data.seo.title },
                            { name : 'description', content: res.data.data.seo.description },
                        ];

                        if(res.data.data.seo.thumb && res.data.data.seo.cover) {
                            metaData.push({ content : res.data.data.seo.thumb });
                            metaData.push({ content : res.data.data.seo.cover });
                        }

                        useHead({
                            title : this.setting.company_name + ' - ' + res.data.data.seo.title,
                            meta: metaData
                        });
                    }
                }).catch((err) => {
                    this.loading.isActive = false;
                });
            }
        },
        showRelatedProduct: function () {
            if (typeof this.$route.params.slug !== "undefined") {
                this.loading.isActive  = true;
                this.props.search.slug = this.$route.params.slug;
                this.$store.dispatch("frontendProduct/relatedProducts", {
                    slug: this.$route.params.slug,
                    rand: 8
                }).then((res) => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                });
            }
        },
        selectedVariationMethod: function (variation) {
            this.enableAddToCardButton = true;
            this.selectedVariation     = null;

            this.temp.isVariation = this.initProduct.isVariation;
            this.temp.variationId = this.initProduct.variationId;
            this.temp.sku         = this.initProduct.sku;
            this.temp.stock       = this.initProduct.stock;
            this.temp.quantity    = this.initProduct.quantity;
            this.temp.discount    = this.initProduct.discount;
            this.temp.price       = this.initProduct.price;
            this.temp.oldPrice    = this.initProduct.oldPrice;
            this.temp.totalPrice  = this.initProduct.price;

            if (variation) {
                this.selectedVariation = variation;

                this.temp.isVariation = true;
                this.temp.variationId = variation.id;
                this.temp.sku         = variation.sku;
                this.temp.stock       = variation.stock;
                this.temp.quantity    = 1;
                this.temp.discount    = 0;
                this.temp.price       = variation.price;
                this.temp.oldPrice    = variation.old_price;
                this.temp.totalPrice  = variation.price;

                if (variation.stock > 0) {
                    this.enableAddToCardButton = false;
                }
            }
        },
        quantityUp: function () {
            if (this.temp.quantity === 0) {
                this.temp.quantity = 1;
            }
            if (this.temp.quantity > this.temp.stock) {
                this.temp.quantity = this.temp.stock
            }
            this.totalPriceSetup();
        },
        quantityIncrement: function () {
            this.temp.quantity++;
            if (this.temp.quantity <= 0) {
                this.temp.quantity = 1;
            }

            if (this.temp.quantity > this.temp.stock) {
                this.temp.quantity--;
            }
            this.totalPriceSetup();
        },
        quantityDecrement: function () {
            this.temp.quantity--;
            if (this.temp.quantity <= 0) {
                this.temp.quantity = 1;
            }
            this.totalPriceSetup();
        },
        totalPriceSetup: function () {
            this.temp.totalPrice = (this.temp.price * this.temp.quantity);
        },
        addToCart: function () {
            this.enableAddToCardButton = true;
            this.productArray          = {
                name: this.temp.name,
                product_id: this.temp.productId,
                image: this.temp.image,
                variation_names: '',
                variation_id: this.temp.variationId,
                sku: this.temp.sku,
                stock: this.temp.stock,
                taxes: this.temp.taxes,
                shipping: this.temp.shipping,
                quantity: this.temp.quantity,
                discount: this.temp.discount,
                price: this.temp.price,
                old_price: this.temp.oldPrice,
                total_price: this.temp.totalPrice
            }

            if (this.selectedVariation) {
                this.$store.dispatch("frontendProductVariation/ancestorsToString", this.selectedVariation.id).then((res) => {
                    this.productArray.variation_names = res.data.data;
                    this.variationComponent           = false;
                    this.$store.dispatch("frontendCart/lists", this.productArray).then((res) => {
                        alertService.success(this.$t('message.add_to_cart'));
                        this.variationComponent = true;
                        this.productArray       = {};
                        this.selectedVariation  = null;
                        this.temp.isVariation   = this.initProduct.isVariation;
                        this.temp.variationId   = this.initProduct.variationId;
                        this.temp.sku           = this.initProduct.sku;
                        this.temp.stock         = this.initProduct.stock;
                        this.temp.quantity      = this.initProduct.quantity;
                        this.temp.discount      = this.initProduct.discount;
                        this.temp.price         = this.initProduct.price;
                        this.temp.oldPrice      = this.initProduct.oldPrice;
                        this.temp.totalPrice    = this.initProduct.price;
                    }).catch((err) => {
                        alertService.error(this.$t('message.maximum_quantity'));
                        this.variationComponent = true;
                        this.selectedVariation  = null;
                        this.temp.stock         = this.initProduct.stock;
                        this.temp.quantity      = this.initProduct.quantity;
                    });
                }).catch((err) => {
                });
            } else {
                this.$store.dispatch("frontendCart/lists", this.productArray).then((res) => {
                    alertService.success(this.$t('message.add_to_cart'));
                    this.enableAddToCardButton = false;
                    this.productArray          = {};
                    this.selectedVariation     = null;
                    this.temp.isVariation      = this.initProduct.isVariation;
                    this.temp.variationId      = this.initProduct.variationId;
                    this.temp.sku              = this.initProduct.sku;
                    this.temp.stock            = this.initProduct.stock;
                    this.temp.quantity         = this.initProduct.quantity;
                    this.temp.discount         = this.initProduct.discount;
                    this.temp.price            = this.initProduct.price;
                    this.temp.oldPrice         = this.initProduct.oldPrice;
                    this.temp.totalPrice       = this.initProduct.price;
                }).catch((err) => {
                    alertService.error(this.$t('message.maximum_quantity'));
                    this.enableAddToCardButton = false;
                    this.selectedVariation     = null;
                    this.temp.stock            = this.initProduct.stock;
                    this.temp.quantity         = this.initProduct.quantity;
                });
            }
        }
    },
    watch: {
        $route() {
            this.show();
            this.showRelatedProduct();
        }
    }
}
</script>
