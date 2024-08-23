<template>
    <aside id="mobile-category-canvas" class="fixed inset-0 z-30 bg-black/50 duration-500 transition-all invisible opacity-0">
        <div class="w-full max-w-xs h-screen overflow-x-hidden overflow-y-auto bg-white duration-500 transition-all ltr:-translate-x-full rtl:translate-x-full">
            <div class="py-4 flex items-center justify-between px-4 border-b border-slate-100">
                <router-link :to="{ name: 'frontend.home' }"
                             class="router-link-active router-link-exact-active flex-shrink-0">
                    <img class="w-28 sm:w-32" :src="setting.theme_logo" alt="logo">
                </router-link>

                <button type="button">
                    <i @click.prevent="hideTarget('mobile-category-canvas', 'canvas-active')"
                       class="lab-line-circle-cross text-xl text-danger"></i>
                </button>
            </div>
            <ul v-if="categories.length > 0" class="px-4 pb-15">
                <li v-for="category in categories" class="border-b border-slate-100">
                    <div class="flex items-center justify-between py-3">
                        <router-link v-on:click="hideTarget('mobile-category-canvas', 'canvas-active')" :to="{ name: 'frontend.product', query: {category : category.slug} }" class="text-lg font-semibold capitalize">
                            <p v-if="language.id == 1">
                                {{ category.name }}
                            </p>
                            <p v-else-if="language.id == 3">
                                <span v-if="category.name_ru !== null ">
                                    {{ category.name_ru }}
                                </span>
                                <span v-else >
                                    {{ category.name }}
                                </span>
                            </p>
                            <p v-else-if="language.id == 2">
                                <span v-if="category.name_et !== null ">
                                    {{ category.name_et }}
                                </span>
                                <span v-else >
                                    {{ category.name }}
                                </span>
                            </p>
                            <p v-else>
                                {{ category.name }}
                            </p>
                        </router-link>
                        <button v-if="category.children.length > 0" @click.prevent="showTarget('mobile_category_' + category.slug, '!translate-x-0')" type="button">
                            <i class="lab-line-chevron-right w-8 h-8 !leading-8 text-center rounded bg-primary/10 text-primary"></i>
                        </button>
                    </div>
                    <MobileMenuChildrenComponent :key="category" v-if="category.children" :parentCategory="category" :categories="category.children" :language="language.id" />
                </li>
            </ul>
        </div>
    </aside>
</template>
<script>
import targetService from "../../../services/targetService";
import { language } from "../../../store/modules/language";
import MobileMenuChildrenComponent from "../../frontend/components/MobileMenuChildrenComponent.vue";

export default {
    name: "FrontendMobileCategoryComponent",
    components: {MobileMenuChildrenComponent},
    data() {
        return {
            defaultLanguage: null,
        }
    },
    computed: {
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
        categories: function () {
            return this.$store.getters['frontendProductCategory/trees'];
        },
        language: function () {
            return this.$store.getters['frontendLanguage/show'];
        },
    },
    methods: {
        showTarget: function (id, cClass) {
            targetService.showTarget(id, cClass);
        },
        hideTarget: function (id, cClass) {
            targetService.hideTarget(id, cClass);
        }
    },
}
</script>