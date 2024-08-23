
<template>
    <div v-if="categories.length > 0" class="max-md:hidden">
        <ul class="flex flex-wrap items-center">
            <li v-for="(category, categoryKey) in categories"
                class="after:content-['\e037'] after:font-icon rtl:after:rotate-180 after:text-sm after:mx-2 last:after:hidden">
                <router-link
                    v-if="(categoryKey + 1) <= Object.keys(categories).length -1"
                    :to="{name: 'frontend.product', query:{ category: category.slug}}"
                    class="text-base font-medium capitalize transition-all duration-500 hover:text-primary">
                    <div v-if="language == 1">
                        {{ category.name }}:
                    </div>
                    <div v-else-if="language == 2">
                        <span v-if="category.name_et !== null && category.name_et !== ''">
                            {{ category.name_et  }}:
                        </span>
                        <span v-else>
                            {{ category.name }}:
                        </span>
                    </div>
                    <div v-else-if="language == 3">
                        <span v-if="category.name_ru !== null && category.name_ru !== ''">
                            {{ category.name_ru  }}:
                        </span>
                        <span v-else>
                            {{ category.name }}:
                        </span>
                    </div>
                    <div v-else>
                        {{ category.name }}:
                    </div>
                </router-link>

                <div v-else>
                    <div v-if="language == 1">
                        <span class="text-base font-medium capitalize text-text">
                            {{ category.name }}
                        </span>
                    </div>
                    <div v-else-if="language == 2">
                        <span v-if="category.name_et !== null && category.name_et !== ''" class="text-base font-medium capitalize text-text">
                            {{ category.name_et  }}:
                        </span>
                        <span v-else class="text-base font-medium capitalize text-text">
                            {{ category.name }}:
                        </span>
                    </div>
                    <div v-else-if="language == 3">
                        <span v-if="category.name_ru !== null && category.name_ru !== ''" class="text-base font-medium capitalize text-text">
                            {{ category.name_ru  }}:
                        </span>
                        <span v-else class="text-base font-medium capitalize text-text">
                            {{ category.name }}:
                        </span>
                    </div>
                    <div v-else>
                        <span class="text-base font-medium capitalize text-text">
                            {{ category.name }}
                        </span>
                    </div>
                </div>

            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "CategoryBreadcrumbComponent",
    props: {
        "categories": "object",
        language:{
            type: Number,
            required: true
        },
    }
}

</script>
