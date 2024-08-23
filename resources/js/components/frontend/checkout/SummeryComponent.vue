<template>
    <div>
        <div v-if="profileCheck === true">
        <div v-if="balance === false" @click.prevent="showTarget('credit-modal', 'modal-active')" class="mb-6 rounded-2xl border border-primary flex items-center gap-3 p-4 cursor-pointer">
            <div class="relative flex-shrink-0">
                <i class="lab lab-fill-shape lab-font-size-2xl opacity-[0.3] text-orange-500"></i>
                <i class="lab lab-fill-wallet lab-font-size-8 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-orange-500"></i>
            </div>
            <div class="flex-auto overflow-hidden">
                <h4 class="font-semibold leading-5 mb-1 whitespace-nowrap overflow-hidden text-ellipsis capitalize text-orange-500">
                    {{ $t('message.credit') }}</h4>
                <h5 class="text-xs font-normal whitespace-nowrap overflow-hidden text-ellipsis">
                    {{ $t('message.apply_credit') }}
                </h5>
            </div>
            <i class="lab lab-line-chevron-right rtl:rotate-180 lab-font-size-2xl text-orange-500"></i>
        </div>
        <div v-else class="mb-6 rounded-2xl border border-success flex items-center gap-3 p-4 cursor-pointer">
            <div class="relative flex-shrink-0">
                <i class="lab-fill-shape lab-font-size-2xl opacity-[0.3] text-success"></i>
                <i class="lab-fill-wallet lab-font-size-8 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-success"></i>
            </div>
            <div class="flex-auto overflow-hidden">
                <h4 class="font-semibold leading-5 mb-1 whitespace-nowrap overflow-hidden text-ellipsis capitalize text-success">
                    {{ $t('message.bonus_applied') }}
                </h4>
                <h5 class="text-xs font-normal whitespace-nowrap overflow-hidden text-ellipsis">
                        {{ $t('message.you_saved', { amount: currencyFormat(usedBalance, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }) }}
                </h5>
            </div>
            <button @click.prevent="destroyCredit" class="lab-line-trash lab-font-size-xl text-danger"></button>
        </div>
        <div id="credit-modal" class="fixed inset-0 z-50 p-3 w-screen h-screen overflow-y-auto bg-black/50 transition-all duration-300 opacity-0 invisible">
            <div class="w-full rounded-xl mx-auto bg-white transition-all duration-300 max-w-[360px]">
                <div class="flex items-center justify-between gap-2 py-4 px-4 border-b border-slate-100"><h3
                    class="text-lg font-bold capitalize"> {{ $t('message.credit') }}</h3>
                    <button @click.prevent="hideTarget('credit-modal', 'modal-active')" type="button" class="lab-line-circle-cross text-lg text-[#E93C3C]"></button>
                </div>
                <div class="px-4 pt-4 flex flex-col gap-4">
                    <div class="bg-[#EEF7FF] relative rounded-xl">
                        <h3 class="py-1 px-2 rounded font-medium text-xs w-fit mb-2 bg-[#FFDB1F]">
                            {{ $t('message.credit_max_available') }}: {{ wallet_balance }}
                        </h3>
                    </div>
                </div>
                <form @submit.prevent="creditChecking" class="w-full flex items-center px-4 px-4 pt-4 pb-6">
                    <input type="number" v-model="useCreditAmount" class="h-11 w-full px-3 ltr:rounded-tl-lg rtl:rounded-tr-lg ltr:rounded-bl-lg rtl:rounded-br-lg border ltr:border-r-0 rtl:border-l-0 border-[#D9DBE9]" :max="(profile.currency_balance).slice(0, -1)" step="0.01">
                    <button type="submit" class="h-11 px-4 leading-11 ltr:rounded-tr-lg rtl:rounded-tl-lg rtl:rounded-bl-lg ltr:rounded-br-lg rtl:rounded-br-0 rtl:rounded-tr-0
                    capitalize font-semibold text-white bg-[#007FE3]">
                        {{ $t('button.apply') }}
                    </button>
                </form>
                <small class="w-full px-4 pt-0 db-field-alert" v-if="error">{{ error }}</small>
            </div>
        </div>
        </div>
        <div class="bg-white rounded-2xl shadow-card">
            <div class="p-4 border-b border-[#EFF0F6]">
                <h3 class="text-lg font-semibold capitalize">{{ $t('label.order_summery') }}</h3>
            </div>
            <ul class="flex flex-col gap-3 p-4 border-b border-[#EFF0F6]">
                <li class="flex items-center justify-between">
                    <span class="capitalize">{{ $t('label.subtotal') }}</span>
                    <span class="font-medium">{{ currencyFormat(subtotal, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="capitalize">{{ $t('label.tax') }}</span>
                    <span class="font-medium">{{ currencyFormat(totalTax, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="capitalize">{{ $t('label.shipping_charge') }}</span>
                    <span class="font-medium" v-if="(subtotal - discount) >= 100">{{ currencyFormat(0, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                    <span class="font-medium"  v-if="(subtotal - discount) < 100">{{ currencyFormat(shippingCharge, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="capitalize">{{ $t('label.discount') }}</span>
                    <span class="font-medium">{{ currencyFormat(discount, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
                <li class="flex items-center justify-between" v-if="usedBalance > 0">
                    <span class="capitalize">Credit bonus</span>
                    <span class="font-medium">{{ currencyFormat(usedBalance, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
                <li class="flex items-center justify-between" v-if="(subtotal - discount) < 100">
                    <span class="font-medium text-danger">{{ $t('label.sum_to_free_shipping') }} {{ currencyFormat((100 - (subtotal - discount)), setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</span>
                </li>
            </ul>
            <div class="p-4">
                <dl class="flex items-center justify-between">
                    <dt class="font-semibold capitalize">{{ $t('label.total') }}</dt>
                    <dd class="font-semibold">{{ currencyFormat(total, setting.site_digit_after_decimal_point,
                        setting.site_default_currency_symbol, setting.site_currency_position) }}</dd>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import appService from "../../../services/appService";
import targetService from "../../../services/targetService";
import alertService from "../../../services/alertService";
import LoadingComponent from "../components/LoadingComponent.vue";

export default {
    name: "SummeryComponent",
    components: {LoadingComponent},
    data() {
        return {
            useCreditAmount : null,
            loading: {
                isActive: false
            },
            error: null,
            wallet_balance: 0,
            profileCheck: false,
        }
    },
    computed: {
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
        subtotal: function () {
            return this.$store.getters['frontendCart/subtotal'];
        },
        discount: function () {
            return this.$store.getters['frontendCart/discount'];
        },
        totalTax: function () {
            return this.$store.getters['frontendCart/totalTax'];
        },
        shippingCharge: function () {
            return this.$store.getters['frontendCart/shippingCharge'];
        },
        total: function () {
            return this.$store.getters['frontendCart/total'];
        },
        balance: function () {
            return this.$store.getters['frontendCart/balance'];
        },
        usedBalance: function () {
            return this.$store.getters['frontendCart/usedBalance'];
        },
        profile: function () {
            return this.$store.getters.authInfo;
        },
    },
    mounted() {
        this.walletBalance();
    },
    methods: {
        walletBalance() {
            this.loading.isActive = true;
            this.$store.dispatch("frontendOverview/walletBalance").then((res) => {
                this.wallet_balance = res.data.data.wallet_balance;
                this.profileCheck = true;
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        showTarget: function (id, cClass) {
            targetService.showTarget(id, cClass);
        },
        hideTarget: function (id, cClass) {
            targetService.hideTarget(id, cClass);
        },
        currencyFormat(amount, decimal, currency, position) {
            return appService.currencyFormat(amount, decimal, currency, position);
        },
        creditChecking() {
            this.loading.isActive = true;
            this.hideTarget('credit-modal', 'modal-active');
            this.$store.dispatch('frontendCart/useBalance', {balance: !this.balance, usedBalance: this.useCreditAmount}).then(res => {
                alertService.success(this.$t('message.bonus_add'));
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
                alertService.error(err);
            });
        },
        destroyCredit() {
            this.loading.isActive = true;
            this.$store.dispatch('frontendCart/useBalance', {balance: false, usedBalance: 0}).then(res => {
                this.loading.isActive = false;
                alertService.success(this.$t('message.credit_delete'));
            }).catch((err) => {
                this.loading.isActive = false;
                alertService.error(err);
            });
        }
    }
}
</script>