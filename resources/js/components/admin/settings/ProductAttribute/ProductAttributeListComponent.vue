<template>
    <LoadingComponent :props="loading"/>

    <div class="db-card db-tab-div active">
        <div class="db-card-header border-none">
            <h3 class="db-card-title">{{ $t("menu.product_attributes") }}</h3>
            <div class="db-card-filter">
                <TableLimitComponent :method="list" :search="props.search" :page="paginationPage"/>
                <ProductAttributeCreateComponent :props="props"/>
            </div>
        </div>

        <div class="db-table-responsive">
            <table class="db-table stripe">
                <thead class="db-table-head">
                <tr class="db-table-head-tr">
                    <th class="db-table-head-th">{{ $t("label.name") }} [EN]</th>
                    <th class="db-table-head-th">{{ $t("label.name") }} [ET]</th>
                    <th class="db-table-head-th">{{ $t("label.name") }} [RU]</th>
                    <th class="db-table-head-th">
                        {{ $t("label.action") }}
                    </th>
                </tr>
                </thead>
                <tbody class="db-table-body" v-if="productAttributes.length > 0">
                <tr class="db-table-body-tr" v-for="productAttribute in productAttributes" :key="productAttribute">
                    <td class="db-table-body-td">
                        {{ productAttribute.name }}
                    </td>
                    <td class="db-table-body-td">
                        {{ productAttribute.name_et }}
                    </td>
                    <td class="db-table-body-td">
                        {{ productAttribute.name_ru }}
                    </td>
                    <td class="db-table-body-td">
                        <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                            <SmViewComponent :link="'admin.settings.productAttribute.show'" :id="productAttribute.id"/>
                            <SmModalEditComponent @click="edit(productAttribute)"/>
                            <SmDeleteComponent @click="destroy(productAttribute.id)"/>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6">
            <PaginationSMBox :pagination="pagination" :method="list"/>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <PaginationTextComponent :props="{ page: paginationPage }"/>
                <PaginationBox :pagination="pagination" :method="list"/>
            </div>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "../../components/LoadingComponent";
import ProductAttributeCreateComponent from "./ProductAttributeCreateComponent";
import alertService from "../../../../services/alertService";
import PaginationTextComponent from "../../components/pagination/PaginationTextComponent";
import PaginationBox from "../../components/pagination/PaginationBox";
import PaginationSMBox from "../../components/pagination/PaginationSMBox";
import appService from "../../../../services/appService";
import TableLimitComponent from "../../components/TableLimitComponent";
import SmDeleteComponent from "../../components/buttons/SmDeleteComponent";
import SmModalEditComponent from "../../components/buttons/SmModalEditComponent";
import SmViewComponent from "../../components/buttons/SmViewComponent";

export default {
    name: "ProductAttributeListComponent",
    components: {
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        ProductAttributeCreateComponent,
        LoadingComponent,
        SmDeleteComponent,
        SmModalEditComponent,
        SmViewComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            props: {
                form: {
                    name: "",
                    name_et: "",
                    name_ru: "",
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: "id",
                    order_type: "desc",
                },
            },
        };
    },
    mounted() {
        this.list();
    },
    computed: {
        productAttributes: function () {
            return this.$store.getters["productAttribute/lists"];
        },
        pagination: function () {
            return this.$store.getters["productAttribute/pagination"];
        },
        paginationPage: function () {
            return this.$store.getters["productAttribute/page"];
        },
    },
    methods: {
        statusClass: function (status) {
            return appService.statusClass(status);
        },
        textShortener: function (text, number = 30) {
            return appService.textShortener(text, number);
        },
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch("productAttribute/lists", this.props.search).then((res) => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (productAttribute) {
            appService.modalShow();
            this.loading.isActive = true;
            this.$store.dispatch("productAttribute/edit", productAttribute.id);
            this.props.form = {
                name: productAttribute.name,
                name_et: productAttribute.name_et,
                name_ru: productAttribute.name_ru,
            };
            this.loading.isActive = false;
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch("productAttribute/destroy", {
                        id: id,
                        search: this.props.search,
                    }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(
                            null,
                            this.$t("menu.product_attributes")
                        );
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
    },
};
</script>
