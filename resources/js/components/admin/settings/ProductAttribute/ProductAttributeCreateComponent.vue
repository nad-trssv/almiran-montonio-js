<template>
    <LoadingComponent :props="loading" />
    <SmModalCreateComponent :props="addButton" />

    <div id="modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">{{ $t("menu.product_attributes") }}</h3>
                <button class="modal-close fa-solid fa-xmark text-xl text-slate-400 hover:text-red-500"
                    @click="reset"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="save" class="d-block w-full">
                    <div class="form-row">
                        <div class="form-col-12 sm:form-col-12">
                            <label for="name" class="db-field-title required">{{ $t("label.name") }} [EN]</label>
                            <input v-model="props.form.name" v-bind:class="errors.name ? 'invalid' : ''" type="text"
                                id="name" class="db-field-control">
                            <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small>
                        </div>
                        <div class="form-col-12 sm:form-col-12">
                            <label for="name_et" class="db-field-title">{{ $t("label.name") }} [ET]</label>
                            <input v-model="props.form.name_et" v-bind:class="errors.name_et ? 'invalid' : ''" type="text"
                                id="name_et" class="db-field-control">
                            <small class="db-field-alert" v-if="errors.name_et">{{ errors.name_et[0] }}</small>
                        </div>
                        <div class="form-col-12 sm:form-col-12">
                            <label for="name_ru" class="db-field-title">{{ $t("label.name") }} [RU]</label>
                            <input v-model="props.form.name_ru" v-bind:class="errors.name_ru ? 'invalid' : ''" type="text"
                                id="name_ru" class="db-field-control">
                            <small class="db-field-alert" v-if="errors.name_ru">{{ errors.name_ru[0] }}</small>
                        </div>

                        <div class="form-col-12">
                            <div class="modal-btns">
                                <button type="button" class="modal-btn-outline modal-close" @click="reset">
                                    <i class="lab lab-fill-close-circle"></i>
                                    <span>{{ $t('button.close') }}</span>
                                </button>

                                <button type="submit" class="db-btn py-2 text-white bg-primary">
                                    <i class="lab lab-fill-save"></i>
                                    <span>{{ $t('button.save') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import SmModalCreateComponent from "../../components/buttons/SmModalCreateComponent";
import LoadingComponent from "../../components/LoadingComponent";
import alertService from "../../../../services/alertService";
import appService from "../../../../services/appService";

export default {
    name: "ProductAttributeCreateComponent",
    components: { SmModalCreateComponent, LoadingComponent },
    props: ["props"],
    data() {
        return {
            loading: {
                isActive: false,
            },
            errors: {},
        };
    },
    computed: {
        addButton: function () {
              return {title: this.$t("button.add_product_attribute")}
        }
    },
    methods: {
        reset: function () {
            appService.modalHide();
            this.$store.dispatch("productAttribute/reset").then().catch();
            this.errors = {};
            this.$props.props.form = {
                name: "",
                name_et: "",
                name_ru: "",
            };
        },

        save: function () {
            try {
                const tempId = this.$store.getters["productAttribute/temp"].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch("productAttribute/save", this.props).then((res) => {
                    appService.modalHide();
                    this.loading.isActive = false;
                    alertService.successFlip(
                        tempId === null ? 0 : 1,
                        this.$t("menu.product_attributes")
                    );
                    this.props.form = {
                        name: "",
                        name_et: "",
                        name_ru: "",
                    };
                    this.errors = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = err.response.data.errors;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },
    },
};
</script>
