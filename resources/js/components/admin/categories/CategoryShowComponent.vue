<template>
   <div>
     <LoadingComponent :props="loading" />

    <div class="col-12">
        <div id="promotion" class="db-tab-div active">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 mb-5">
                <button @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'categoryInformation')"
                    class="tab-action active w-full flex items-center gap-3 h-10 px-4 rounded-lg bg-white hover:text-primary hover:bg-primary/5">
                    <i class="lab lab-fill-info lab-font-size-16"></i>
                    {{ $t("label.information") }}
                </button>
                <button type="button" @click.prevent="multiTargets($event, 'tab-action', 'tab-content', 'productCategoryImage')"
                    class="tab-action w-full flex items-center gap-3 h-10 px-4 rounded-lg transition bg-white hover:text-primary hover:bg-primary/5">
                    <i class="lab lab-fill-image lab-font-size-16"></i>
                    {{ $t("label.image") }}
                </button>
            </div>

            <div class="db-card tab-content active" id="categoryInformation">
                <div class="db-card-header">
                    <h3 class="db-card-title">{{ $t('label.information') }}</h3>
                </div>

                <div class="db-card-body">
                    <div class="row py-2">
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t('label.name') }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ productCategory.name }}</span>
                            </div>
                        </div>
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t('label.slug') }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ productCategory.slug }}</span>
                            </div>
                        </div>
                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t('label.parent_category') }}</span>
                                <span class="db-list-item-text w-full sm:w-1/2">{{ productCategory.parent_category }}</span>
                            </div>
                        </div>

                        <div class="col-12 sm:col-6 !py-1.5">
                            <div class="db-list-item p-0">
                                <span class="db-list-item-title w-full sm:w-1/2">{{ $t('label.status') }}</span>
                                <span class="db-list-item-text">
                                    <span :class="statusClass(productCategory.status)">{{
                                        enums.statusEnumArray[productCategory.status]
                                    }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="db-card tab-content px-4" id="productCategoryImage">
                <div class="row py-2">
                    <div class="col-12 sm:col-5 relative">
                        <img class="db-image" :src="previewImage" />
                        <button v-if="previewImage !== 'https://almiran.local/images/default/category/cover.png'" @click.prevent="deleteImage()" class="absolute -top-3 -right-1 lab-line-cross text-3xl w-9 h-9 leading-9 text-center rounded-full shadow-md bg-admin-orange text-white" type="button"></button>
                    </div>
                    <form @submit.prevent="saveImage" class="px-4">
                        <p class="mt-2">{{ $t('label.size') }}: (640px, 960px)</p>
                        <div class="flex gap-3 md:gap-4 py-4">
                            <label for="photo"
                                class="db-btn relative cursor-pointer h-[38px] shadow-[0px_6px_10px_rgba(255,_0,_107,_0.24)] bg-primary text-white">
                                <i class="lab lab-upload-image"></i>
                                <span class="hidden sm:inline-block">{{
                                    $t("button.upload_new_image")
                                }}</span>
                                <input v-if="uploadButton" @change="changePreviewImage" ref="imageProperty"
                                    accept="image/png, image/jpeg, image/jpg" type="file" id="photo"
                                    class="absolute top-0 left-0 w-full h-full -z-10 opacity-0" />
                            </label>
                            <button v-if="saveButton" type="submit"
                                class="db-btn h-[38px] shadow-[0px_6px_10px_rgba(26,_183,_89,_0.24)] text-white bg-[#1AB759]">
                                <i class="lab lab-tick-circle-2"></i>
                                <span class="hidden sm:inline-block">{{ $t("button.save") }}</span>
                            </button>
                            <button v-if="resetButton" @click="resetPreviewImage" type="button"
                                class="db-btn-outline h-[38px] shadow-[0px_6px_10px_rgba(251,_78,_78,_0.24)] !text-[#FB4E4E] !bg-white !border-[#FB4E4E]">
                                <i class="lab lab-reset"></i>
                                <span class="hidden sm:inline-block">{{ $t("button.reset") }}</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
   </div>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent";
import alertService from "../../../services/alertService";
import appService from "../../../services/appService";
import targetService from "../../../services/targetService";
import statusEnum from "../../../enums/modules/statusEnum";
import CategoryLangListComponent from "./lang/CategoryLangListComponent";

export default {
    name: "CategoryShowComponent",
    components: {
        LoadingComponent,
        CategoryLangListComponent
    },
    data() {
        return {
            loading: {
                isActive: false
            },
            enums: {
                statusEnum: statusEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive")
                }
            },
            defaultImage: null,
            previewImage: null,
            uploadButton: true,
            resetButton: false,
            saveButton: false,
            deleteIndex: 0,
        }
    },
    computed: {
        productCategory: function () {
            return this.$store.getters['productCategory/show'];
        }
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch('productCategory/show', this.$route.params.id).then(res => {
            this.defaultImage = res.data.data.cover;
            this.previewImage = res.data.data.cover;
            this.loading.isActive = false;
        }).catch((error) => {
            this.loading.isActive = false;
        });
    },
    methods: {
        multiTargets: function (event, commonBtnClass, commonDivClass, targetID) {
            targetService.multiTargets(event, commonBtnClass, commonDivClass, targetID);
        },
        statusClass: function (status) {
            return appService.statusClass(status);
        },
        changePreviewImage: function (e) {
            if (e.target.files[0]) {
                this.previewImage = URL.createObjectURL(e.target.files[0]);
                this.saveButton = true;
                this.resetButton = true;
            }
        },
        resetPreviewImage: function () {
            this.$refs.imageProperty.value = null;
            this.previewImage = this.defaultImage;
            this.saveButton = false;
            this.resetButton = false;
        },
        saveImage: function () {
            if (this.$refs.imageProperty.files[0]) {
                try {
                    this.loading.isActive = true;
                    const formData = new FormData();                    
                    formData.append("image", this.$refs.imageProperty.files[0]);
                    this.$store
                        .dispatch("productCategory/changeImage", {
                            id: this.$route.params.id,
                            form: formData,
                        })
                        .then((res) => {
                            alertService.success(this.$t("message.image_update"));
                            this.saveButton = false;
                            this.resetButton = false;
                            this.loading.isActive = false;
                        })
                        .catch((err) => {
                            this.loading.isActive = false;
                            this.imageErrors = err.response.data.errors;
                        });
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }
        },
        deleteImage: function () {
                try {
                    this.loading.isActive = true;
                    this.$store
                        .dispatch("productCategory/deleteImage", {
                            id: this.$route.params.id
                        })
                        .then((res) => {
                            this.$store.dispatch('productCategory/show', this.$route.params.id).then(res => {
                                this.saveButton = false;
                                this.resetButton = false;
                                this.loading.isActive = false;
                            }).catch((error) => {
                                this.loading.isActive = false;
                            });
                            alertService.success(this.$t("message.image_delete"));
                        })
                        .catch((err) => {
                            this.loading.isActive = false;
                            this.imageErrors = err.response.data.errors;
                            location.reload(); 
                        });
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
        },
    }
}
</script>
