<template>
    <LoadingComponent :props="loading" />
    <section class="mb-28 sm:mb-20">
        <div class="container">
            <!-- Default Router -->
            <router-view />
            <!-- Default Router -->
        </div>
    </section>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent.vue";

export default {
    name: "TaxComponent",
    components: { LoadingComponent},
    data() {
        return {
            loading: {
                isActive: false,
            },
            currentRoute: null,
        }
    },
}
</script>