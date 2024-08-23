<template>
    <LoadingComponent :props="loading" />

    <div class="col-12">
        <div id="product" class="db-tab-div active">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 mb-5">

                <button @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'information')"
                    class="tab-action active w-full flex items-center gap-3 h-10 px-4 rounded-lg bg-white hover:text-primary hover:bg-primary/5">
                    <i class="lab lab-fill-info lab-font-size-16"></i>
                    {{ $t("label.information") }}
                </button>
                <button type="button" @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'image')"
                    class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                    <i class="lab lab-fill-image lab-font-size-16"></i>
                    {{ $t("label.images") }}
                </button>
                <button type="button" @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'variations')"
                    class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                    <i class="lab lab-fill-variation lab-font-size-16"></i>
                    {{ $t("label.variation") }}
                </button>


                <div class="relative w-full">
                    <button @click.prevent="tabMore = !tabMore"
                        class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg bg-white hover:text-primary hover:bg-primary/5">
                        <i :class="{ 'rotate-180': tabMore }"
                            class="lab lab-fill-circle-chevron-down text-sm transition-all duration-500"></i>
                        <span class="capitalize tracking-wide">{{ $t('label.more') }}</span>
                    </button>
                    <div :class="{ 'scale-y-100': tabMore == true, 'scale-y-0': tabMore == false }"
                        class="absolute top-11 right-0 w-full z-30 p-2 rounded-md origin-top bg-white shadow-lg transition-all duration-500">
                        <button type="button" @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'offer')"
                            class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                            <i class="lab lab-fill-offers lab-font-size-16"></i>
                            {{ $t("label.offer") }}
                        </button>
                        <button type="button"
                            class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5"
                            @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'video')">
                            <i class="lab lab-fill-video lab-font-size-16"></i>
                            {{ $t("label.video") }}
                        </button>
                        <button type="button"
                            @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'sizes')"
                            class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                            <i class="lab lab-line-item-attributes lab-font-size-16"></i>
                            {{ $t("label.sizes") }}
                        </button>
                        <button type="button" @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'seo')"
                            class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                            <i class="lab lab-fill-seo lab-font-size-16"></i>
                            {{ $t("label.seo") }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="db-card tab-content active" id="information">
                <div class="db-card-header">
                    <h3 class="db-card-title">{{ $t('label.information') }}</h3>
                </div>
                <div class="db-card-body">
                    <div class="row py-2">
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.name") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.name }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.sku") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.sku }}</span>
                            </div>
                        </div>
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.name") }} [ET]</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.name_et }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.category") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.category }}</span>
                            </div>
                        </div>
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.name") }} [RU]</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.name_ru }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.brand") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.brand }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.tax") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.tax }}</span>
                            </div>
                        </div>

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.buying_price") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.flat_buying_price }}</span>
                            </div>
                        </div> -->

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.selling_price") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.flat_selling_price }}</span>
                            </div>
                        </div>

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{
                                    $t("label.maximum_purchase_quantity")
                                }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.maximum_purchase_quantity
                                }}</span>
                            </div>
                        </div> -->

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{
                                    $t("label.low_stock_quantity_warning")
                                }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.low_stock_quantity_warning
                                }}</span>
                            </div>
                        </div> -->

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.weight") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.weight }}</span>
                            </div>
                        </div> -->

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.unit") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ product.unit }}</span>
                            </div>
                        </div> -->

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.purchasable") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{
                                    enums.askEnumArray[product.can_purchasable]
                                }}</span>
                            </div>
                        </div> -->
<!-- 
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.show_stock_out") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{
                                    enums.activityEnumArray[product.show_stock_out]
                                }}</span>
                            </div>
                        </div> -->

                        <!-- <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.refundable") }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{
                                    enums.askEnumArray[product.refundable]
                                }}</span>
                            </div>
                        </div> -->

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.status") }}</span>
                                <span class="db-list-item-text">{{ enums.statusEnumArray[product.status] }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t("label.tags") }}</span>
                                <span class="db-list-item-text">{{ product.tags }}</span>
                            </div>
                        </div>
                        <div class="col-12 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-text mt-2 w-full">
                                    <span class="mt-2 db-list-item-title">{{ $t("label.description") }}</span><br />
                                    <span class="mt-2" v-html="product.description"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-text mt-2 w-full">
                                    <span class="mt-2 db-list-item-title">{{ $t("label.description") }} [ET]</span><br />
                                    <span class="mt-2" v-html="product.description_et"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-text mt-2 w-full">
                                    <span class="mt-2 db-list-item-title">{{ $t("label.description") }} [RU]</span><br />
                                    <span class="mt-2" v-html="product.description_ru"></span>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-12 !py-1.5" v-if="reviews[0]">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-text mt-2 w-full">
                                    <span class="mt-2 db-list-item-title">{{ $t("label.reviews") }}</span><br />
                                </span>
                            </div>
                            <div v-for="review in reviews.slice(-5)" class="mb-8">
                                <h4 class="text-lg font-semibold capitalize mb-2">{{ review.name }}</h4>
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <starRating
                                        border-color="#FFBC1F"
                                        inactive-color="#FFFFFF"
                                        active-color="#FFBC1F"
                                        :rounded-corners="true"
                                        :padding="2.5" :border-width="2.5"
                                        :star-size="11" class="-mt-0.5"
                                        :round-start-rating="false"
                                        :show-rating="false" :read-only="true"
                                        :max-rating="5"
                                        :rating="review.star"/>
                                </div>
                                <p class="mb-4">{{ review.review }}</p>


                                <div class="flex flex-wrap gap-4" v-if="review.images.length > 0">
                                    <img v-for="reviewImage in review.images" :src="reviewImage" alt="image" class="w-20 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="db-card tab-content px-4" id="image">
                <div class="row py-4 p-3">
                    <div class="w-full max-w-[620px] flex flex-col-reverse sm:flex-row gap-3 sm:gap-5">
                        <nav class="flex-shrink-0 w-full sm:max-w-[90px] flex flex-row sm:flex-col gap-3 sm:gap-5">
                            <label for="addImage" v-if="product.images && product.images.length < 6"
                                class="relative w-full h-16 sm:h-20 flex items-center justify-center rounded-2xl cursor-pointer text-heading bg-gray-200">
                                <input type="file" id="addImage" @change="saveImage" ref="imageProperty"
                                    class="w-full h-full absolute -z-10 rounded-2xl opacity-0"
                                    accept="image/png, image/jpeg, image/jpg">
                                <i class="lab-fill-circle-plus text-xl sm:text-3xl"></i>
                            </label>

                            <button class="w-full" type="button" v-for="(image, index) in product.images">
                                <img class="w-full h-16 sm:h-20 object-top object-cover rounded-2xl" :src="image"
                                     @click.prevent="switchImage(image, index)" />
                            </button>
                        </nav>
                        <div class="w-full relative" v-if="livePreview">
                            <img class="w-full h-96 sm:h-[480px] object-top object-cover rounded-2xl" alt="products"
                                :src="livePreview" />
                            <button v-if="imageCount > 0" @click.prevent="deleteImage"
                                class="lab-line-cross text-3xl absolute -top-3 -right-3 w-9 h-9 leading-9 text-center rounded-full shadow-md bg-white text-danger"
                                type="button"></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="db-card tab-content" id="variations">
                <ProductVariationListComponent />
            </div>

            <div class="db-card tab-content" id="offer">
                <div class="db-card-header">
                    <h3 class="db-card-title">{{ $t('label.offer') }}</h3>
                </div>
                <div class="db-card-body">
                    <form @submit.prevent="offerSsave" class="d-block w-full">
                        <div class="form-row">
                            <div class="form-col-12 sm:form-col-6">
                                <label for="offer_start_date" class="db-field-title required">{{
                                    $t("label.offer_start_date")
                                }}</label>
                                <Datepicker hideInputIcon autoApply v-model="form.offer_start_date" :enableTimePicker="true" 
                                    :is24="false" :monthChangeOnScroll="false" utc="false"
                                    :input-class-name="offerError.offer_start_date ? 'invalid' : ''">
                                    <template #am-pm-button="{ toggle, value }">
                                        <button @click="toggle">{{ value }}</button>
                                    </template>
                                </Datepicker>
                                <small class="db-field-alert" v-if="offerError.offer_start_date">{{
                                    offerError.offer_start_date[0]
                                }}</small>
                            </div>
                            <div class="form-col-12 sm:form-col-6">
                                <label for="offer_end_date" class="db-field-title required">{{ $t("label.offer_end_date")
                                }}</label>
                                <Datepicker hideInputIcon autoApply v-model="form.offer_end_date" :enableTimePicker="true" 
                                    :is24="false" :monthChangeOnScroll="false" utc="false"
                                    :input-class-name="offerError.offer_end_date ? 'invalid' : ''">
                                    <template #am-pm-button="{ toggle, value }">
                                        <button @click="toggle">{{ value }}</button>
                                    </template>
                                </Datepicker>
                                <small class="db-field-alert" v-if="offerError.offer_end_date">{{
                                    offerError.offer_end_date[0]
                                }}</small>
                            </div>

                            <div class="form-col-12 sm:form-col-6">
                                <label for="discount" class="db-field-title required">
                                    {{ $t("label.discount_percentage") }}
                                </label>
                                <input v-model="form.discount" v-on:keypress="floatNumber($event)"
                                    v-bind:class="offerError.discount ? 'invalid' : ''" type="text" id="discount"
                                    class="db-field-control" />
                                <small class="db-field-alert" v-if="offerError.discount">{{ offerError.discount[0]
                                }}</small>
                            </div>

                            <div class="form-col-12 sm:form-col-6">
                                <label class="db-field-title required" for="yes">{{ $t("label.add_to_flash_sale")
                                }}</label>
                                <div class="db-field-radio-group">
                                    <div class="db-field-radio">
                                        <div class="custom-radio">
                                            <input type="radio" v-model="form.add_to_flash_sale" id="yes"
                                                :value="enums.askEnum.YES" class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label for="yes" class="db-field-label">{{ $t('label.yes') }}</label>
                                    </div>
                                    <div class="db-field-radio">
                                        <div class="custom-radio">
                                            <input type="radio" class="custom-radio-field" v-model="form.add_to_flash_sale"
                                                id="no" :value="enums.askEnum.NO">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label for="no" class="db-field-label">{{ $t('label.no') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-col-12">
                                <button type="submit" class="db-btn text-white bg-primary">
                                    <i class="lab lab-fill-save"></i>
                                    <span>{{ $t("button.save") }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="db-card tab-content" id="video">
                <ProductVideoListComponent />
            </div>

            <div class="db-card tab-content" id="sizes">
                <div class="db-card-header">
                    <h3 class="db-card-title">{{ $t('label.sizes') }}</h3>
                    <div class="btns">
                        <button v-on:click="fAddNewRow" class="db-btn h-[37px] text-white bg-primary mr-2"><i class="lab lab-line-add-circle"></i><span>{{ $t("button.row") }}</span></button>
                        <button v-on:click="fAddNewCol" class="db-btn h-[37px] text-white bg-primary mr-2"><i class="lab lab-line-add-circle"></i><span>{{ $t("button.col") }}</span></button>
                        <button class="db-btn h-[37px] text-white bg-primary mr-2" v-on:click="fDeleteRow"><i class="lab lab-line-trash"></i><span>{{ $t("button.row") }}</span></button>
                        <button class="db-btn h-[37px] text-white bg-primary" v-on:click="fRemoveNewCol"><i class="lab lab-line-trash"></i><span>{{ $t("button.col") }}</span></button>
                    </div>
                </div>
                <div class="db-card-body">
                    <div class="w-full py-2 mb-2">
                        <form @submit.prevent="saveSizes" class="d-block w-full">
                            <button type="submit" class="db-btn h-[37px] text-white bg-success">
                                <i class="lab lab-fill-save"></i>
                                <span class="hidden sm:inline-block">{{ $t("button.save") }}</span>
                            </button>
                        </form>
                    </div>
                    <table class="w-full my-4" style="overflow-y: scroll; display: block;">
                        <h3 class="db-card-title">{{ $t('label.sizes') }} [EN]</h3>
                        <thead>
                        <tr>
                            <th v-for="(entry, index) in sizesForm.shipping_and_return[0].string.length"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(entrycol, indexcol) in sizesForm.shipping_and_return.length">
                            <td style="text-align: center; min-width: 90px;" v-for="(entry, index) in sizesForm.shipping_and_return[0].string.length">
                                <input type="text" class="db-field-control border-primary required" v-model="tableArray[indexcol].string[index]" placeholder="" required />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="w-full my-4" style="overflow-y: scroll; display: block;">
                        <h3 class="db-card-title">{{ $t('label.sizes') }} [ET]</h3>
                        <thead>
                        <tr>
                            <th v-for="(entry, index) in sizesForm.shipping_and_return_et[0].string.length"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(entrycol, indexcol) in sizesForm.shipping_and_return_et.length">
                            <td style="text-align: center; min-width: 90px;" v-for="(entry, index) in sizesForm.shipping_and_return_et[0].string.length">
                                <input type="text" class="db-field-control border-primary" v-model="tableArray_et[indexcol].string[index]" placeholder="" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="w-full my-4" style="overflow-y: scroll; display: block;">
                        <h3 class="db-card-title">{{ $t('label.sizes') }} [RU]</h3>
                        <thead>
                        <tr>
                            <th v-for="(entry, index) in sizesForm.shipping_and_return_ru[0].string.length"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(entrycol, indexcol) in sizesForm.shipping_and_return_ru.length">
                            <td style="text-align: center; min-width: 90px;" v-for="(entry, index) in sizesForm.shipping_and_return_ru[0].string.length">
                                <input type="text" class="db-field-control border-primary" v-model="tableArray_ru[indexcol].string[index]" placeholder="" />
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="w-full py-2 mb-2">
                        <form @submit.prevent="saveSizes" class="d-block w-full">
                            <button type="submit" class="db-btn h-[37px] text-white bg-success w-full">
                                <i class="lab lab-fill-save"></i>
                                <span class="hidden sm:inline-block">{{ $t("button.save") }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="db-card tab-content" id="seo">
                <ProductSeoComponent />
            </div>
        </div>
    </div>
</template>
<style>
textarea.shipping_and_return__table {
    border: 1px solid #b5b5b5;
    width: 100%;
    border-radius: 5px;
}
.shipping_and_return__table table td {
    border: 1px solid #c5c5c5;
    padding: 3px 10px;
}
.shipping_and_return__table table {
    width: 100%;
}
</style>
<script>
import LoadingComponent from "../components/LoadingComponent";
import statusEnum from "../../../enums/modules/statusEnum";
import shippingTypeEnum from "../../../enums/modules/shippingTypeEnum";
import askEnum from "../../../enums/modules/askEnum";
import appService from "../../../services/appService";
import targetService from "../../../services/targetService";
import alertService from "../../../services/alertService";
import ProductVariationListComponent from "./variation/ProductVariationListComponent";
import ProductSeoComponent from "./seo/ProductSeoComponent";
import ProductVideoListComponent from "./video/ProductVideoListComponent";
import { quillEditor } from 'vue3-quill'
import Datepicker from "@vuepic/vue-datepicker";
import activityEnum from "../../../enums/modules/activityEnum";
import starRating from "vue-star-rating";

export default {
    name: "ProductShowComponent",
    components: {
        LoadingComponent,
        ProductVariationListComponent,
        ProductVideoListComponent,
        quillEditor,
        ProductSeoComponent,
        starRating,
        Datepicker
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            tabMore: false,
            enums: {
                statusEnum: statusEnum,
                askEnum: askEnum,
                shippingTypeEnum: shippingTypeEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive"),
                },
                shippingTypeEnumArray: {
                    [shippingTypeEnum.FREE]: this.$t("label.free"),
                    [shippingTypeEnum.FLAT_RATE]: this.$t("label.flat_rate"),
                },
                askEnumArray: {
                    [askEnum.YES]: this.$t("label.yes"),
                    [askEnum.NO]: this.$t("label.no"),
                },
                activityEnumArray: {
                    [activityEnum.ENABLE]: this.$t("label.enable"),
                    [activityEnum.DISABLE]: this.$t("label.disable"),
                }
            },
            deleteIndex: 0,
            imageCount: 0,
            defaultImage: null,
            previewImage: null,
            livePreview: null,
            form: {
                add_to_flash_sale: "",
                discount: "1.5",
                offer_start_date: "",
                offer_end_date: "",
            },
            shippingAndReturnForm: {
                shipping_type: shippingTypeEnum.FREE,
                shipping_cost: 0,
                is_product_quantity_multiply: askEnum.NO,
            },
            sizesForm: {
                shipping_and_return: [ { id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },],
                shipping_and_return_et: [ { id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },],
                shipping_and_return_ru: [ { id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },],
            },
            shippingError: {},
            offerError: {},
            arrayrev: [],
            string: [],
        };
    },
    computed: {
        product: function () {
            return this.$store.getters["product/show"];
        },
        reviews: function () {
            return this.$store.getters["product/showReviews"];
        }, 
        tableArray: function() {
            return this.sizesForm.shipping_and_return;
        },
        tableArray_et: function() {
          return this.sizesForm.shipping_and_return_et;
        },
        tableArray_ru: function() {
          return this.sizesForm.shipping_and_return_ru;
        }
    },
    mounted() {
        this.loading.isActive = true;
        this.show();
    },
    methods: {
        multiTargets: function (event, commonBtnClass, commonDivClass, targetID) {
            targetService.multiTargets(event, commonBtnClass, commonDivClass, targetID);
        },
        floatNumber(e) {
            return appService.floatNumber(e);
        },
        switchImage: function (link, index) {
            this.livePreview = link;
            this.deleteIndex = index;
        },
        show: function () {
            this.$store.dispatch("product/show", this.$route.params.id).then((res) => {
                this.defaultImage = res.data.data.preview;
                this.previewImage = res.data.data.preview;
                this.livePreview = res.data.data.image;
                this.imageCount = res.data.data.images.length;
                if(Array.isArray(res.data.data.shipping_and_return)){
                    this.sizesForm.shipping_and_return = res.data.data.shipping_and_return;
                } else {
                    this.sizesForm.shipping_and_return = [{ id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },];
                }
                if(Array.isArray(res.data.data.shipping_and_return_et)){
                    this.sizesForm.shipping_and_return_et = res.data.data.shipping_and_return_et;
                } else {
                    this.sizesForm.shipping_and_return_et = [{ id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },];
                }
                if(Array.isArray(res.data.data.shipping_and_return_ru)){
                    this.sizesForm.shipping_and_return_ru = res.data.data.shipping_and_return_ru;
                } else {
                    this.sizesForm.shipping_and_return_ru = [{ id: 0, string: [ '', '' ] }, { id: 1, string: [ '', '' ] },];
                }
                this.shippingAndReturnForm.shipping_type = res.data.data.shipping_type;
                this.shippingAndReturnForm.shipping_cost = res.data.data.shipping_cost;
                this.shippingAndReturnForm.is_product_quantity_multiply = res.data.data.is_product_quantity_multiply;
                this.form.add_to_flash_sale = res.data.data.add_to_flash_sale;
                this.form.discount = res.data.data.discount_percentage;
                this.form.offer_start_date = res.data.data.offer_start_date;
                this.form.offer_end_date = res.data.data.offer_end_date;
                this.loading.isActive = false;
            }).catch((error) => {
                this.loading.isActive = false;
            });
        },
        saveImage: function () {
            if (this.$refs.imageProperty.files[0]) {
                try {
                    this.loading.isActive = true;
                    const formData = new FormData();
                    formData.append("image", this.$refs.imageProperty.files[0]);
                    this.$store.dispatch("product/uploadImage", {
                        id: this.$route.params.id,
                        form: formData
                    }).then((res) => {
                        alertService.success(this.$t("message.image_update"));
                        this.defaultImage = res.data.data.preview;
                        this.previewImage = res.data.data.preview;
                        this.livePreview = res.data.data.image;
                        this.imageCount = res.data.data.images.length;

                        if (this.$refs.imageProperty) {
                            this.$refs.imageProperty.value = null;
                        }
                        this.loading.isActive = false;
                    }).catch((err) => {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.errors.image[0]);
                    });
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }
        },
        deleteImage: function () {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch("product/deleteImage", {
                        id: this.$route.params.id,
                        index: this.deleteIndex,
                    }).then((res) => {
                        this.show();
                        this.loading.isActive = false;
                        alertService.success(this.$t("message.image_delete"));
                        this.deleteIndex = 0;
                    }).catch((err) => {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.message);
                    });
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        saveSizes: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch("product/shippingAndReturn", {
                    id: this.$route.params.id,
                    form: this.sizesForm,
                }).then((res) => {
                    alertService.success(this.$t("message.shipping_and_return"));
                    this.loading.isActive = false;
                    this.shippingError = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.shippingError = err.response.data.errors;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        offerSsave: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch("product/productOffer", {
                    id: this.$route.params.id,
                    form: this.form,
                }).then((res) => {
                    alertService.success(this.$t("message.product_offer"));
                    this.loading.isActive = false;
                    this.offerError = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.offerError = err.response.data.errors;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        
        fAddNewRow: function () {
              let i = 0;
              let max = this.sizesForm.shipping_and_return[0].string;
              for (let obj of max) {
                this.string.push('');
                i++;
              }
          this.sizesForm.shipping_and_return.push(
                { id: this.sizesForm.shipping_and_return.length, 
                  string: this.string
                }   
               );
              this.string = [];
          
          
              let i_et = 0;
              let max_et = this.sizesForm.shipping_and_return_et[0].string;
              for (let obj_et of max_et) {
                this.string.push('');
                i_et++;
              }
              this.sizesForm.shipping_and_return_et.push(
                { id: this.sizesForm.shipping_and_return_et.length, 
                  string: this.string
                }   
               );
          
              this.string = [];
          
          
              let i_ru = 0;
              let max_ru = this.sizesForm.shipping_and_return_ru[0].string;
              for (let obj_ru of max_ru) {
                this.string.push('');
                i_ru++;
              }
              this.sizesForm.shipping_and_return_ru.push(
                { id: this.sizesForm.shipping_and_return_ru.length, 
                  string: this.string
                }   
               );
          
              this.string = [];
            },
          
            fAddNewCol: function () {
              let i = 0;
              let maximum = this.sizesForm.shipping_and_return.length;
              while( i < maximum) {
                this.sizesForm.shipping_and_return[i].string.push('');
                this.sizesForm.shipping_and_return_et[i].string.push('');
                this.sizesForm.shipping_and_return_ru[i].string.push('');
                  ++i;
              }
            },
            fRemoveNewCol: function () {
              if(this.sizesForm.shipping_and_return[0].string.length > 2 ){
                this.sizesForm.shipping_and_return[0].string.pop();
                this.sizesForm.shipping_and_return_et[0].string.pop();
                this.sizesForm.shipping_and_return_ru[0].string.pop();
              }
            },
            fDeleteRow: function () {
              if(this.sizesForm.shipping_and_return.length > 2 ){
                this.sizesForm.shipping_and_return.pop();
                this.sizesForm.shipping_and_return_et.pop();
                this.sizesForm.shipping_and_return_ru.pop();
              }
              
            },
    },
};
</script>
