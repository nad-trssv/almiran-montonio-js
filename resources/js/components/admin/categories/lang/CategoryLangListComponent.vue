<template>
    <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t("menu.products") }}</h3>
                <div class="db-card-filter">
                    <CategoryCreateComponent :props="props" />
                </div>
            </div>
    <div class="db-table-responsive">
        <table class="db-table stripe">
            <thead class="db-table-head">
                <tr class="db-table-head-tr">
                    <th class="db-table-head-th">{{ $t("label.name") }}</th>
                    <th class="db-table-head-th">{{ $t("label.name") }} (RU)</th>
                    <th class="db-table-head-th">{{ $t("label.name") }} (ET)</th>
                    <th class="db-table-head-th">{{ $t("label.action") }}</th>
                </tr>
            </thead>
            <tbody class="db-table-body">
                <tr class="db-table-body-tr">
                    <td class="db-table-body-td">
                        {{ category.name }}
                    </td>
                    <td class="db-table-body-td">
                        {{ category.name_ru }}
                    </td>
                    <td class="db-table-body-td">
                        {{ category.name_et }}
                    </td>
                    <td class="db-table-body-td">
                        <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                            <SmIconSidebarModalEditComponent @click="edit(category)"/>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import SmIconSidebarModalEditComponent from "../../components/buttons/SmIconSidebarModalEditComponent";
import appService from "../../../../services/appService";
import CategoryLangCreateComponent from "./CategoryLangCreateComponent";

export default {
    name: "CategoryLangListComponent",
    components: {
        SmIconSidebarModalEditComponent,
        CategoryLangCreateComponent,
    },
    props: ['category'],
    data() {
        return {
            loading: {
                isActive: false
            },
            props: {
                form: {
                    name: "",
                    name_ru: "",
                    name_et: "",
                    description: "",
                    parent_id: null,
                },
            }
        }
    },
    methods: {
        edit: function (category) {
            appService.modalShow();
            this.loading.isActive = true;
            this.$store.dispatch('productCategory/edit', category.id);
            this.props.form = {
                name: category.name,
                name_ru: category.name_ru,
                name_et: category.name_et,
                parent_id: category.parent_id === 0 ? null : category.parent_id,
                description: category.description
            };
            this.loading.isActive = false;
        },
    }
}
</script>
