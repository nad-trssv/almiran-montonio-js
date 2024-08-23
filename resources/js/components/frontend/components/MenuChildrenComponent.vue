<template>
    <div class="p-0 m-0">
        <p v-if="categories.length > 0" v-for="category in categories" :key="category">
            <router-link
                        v-if="defaultLanguage == 2"
                        :to="{ name: 'frontend.product', query: {category : category.slug} }"
                         class="text-sm capitalize py-1 transition-all duration-300 hover:text-primary hover:underline" :class="!icon ? 'font-medium' : ''">
                <i v-if="icon" class="lab lab-line-chevron-right"></i>
                <span v-if="category.name_et !== null ">
                    {{ category.name_et }}
                </span>
                <span v-else >
                    {{ category.name }}
                </span>
            </router-link>
            <router-link
                        v-else-if="defaultLanguage == 3"
                        :to="{ name: 'frontend.product', query: {category : category.slug} }"
                         class="text-sm capitalize py-1 transition-all duration-300 hover:text-primary hover:underline" :class="!icon ? 'font-medium' : ''">
                <i v-if="icon" class="lab lab-line-chevron-right"></i>
                <span v-if="category.name_ru !== null ">
                    {{ category.name_ru }}
                </span>
                <span v-else >
                    {{ category.name }}
                </span>
            </router-link>
            <router-link
                        v-else-if="defaultLanguage == 1"
                        :to="{ name: 'frontend.product', query: {category : category.slug} }"
                         class="text-sm capitalize py-1 transition-all duration-300 hover:text-primary hover:underline" :class="!icon ? 'font-medium' : ''">
                <i v-if="icon" class="lab lab-line-chevron-right"></i>
                {{ category.name }}
            </router-link>
            <router-link
                        v-else
                        :to="{ name: 'frontend.product', query: {category : category.slug} }"
                         class="text-sm capitalize py-1 transition-all duration-300 hover:text-primary hover:underline" :class="!icon ? 'font-medium' : ''">
                <i v-if="icon" class="lab lab-line-chevron-right"></i>
                {{ category.name }}
            </router-link>
            <MenuChildrenComponent :icon="true" class="ml-3" v-if="category.children" :key="category" :categories="category.children"/>
        </p>
    </div>
</template>

<script>
export default {
    name: "MenuChildrenComponent",
    props: {
        categories: {
            type: Array,
            required: true
        },
        defaultLanguage: {
            type: Number,
        },
        icon: {
            type: Boolean,
            default: false
        },
    },
}
</script>
