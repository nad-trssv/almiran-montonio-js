<template>
    <div v-if="menuTemplateId === 1">
        <ContactUsComponent />
    </div>
    <div v-if="menuTemplateId === 2">
        <DeliveryComponent />
    </div>
</template>

<script>

import ContactUsComponent from "../page/ContactUsComponent";
import DeliveryComponent from "../page/DeliveryComponent";
export default {
    name: "TemplateManagerComponent",
    props: ["menuTemplateId"],
    components: { ContactUsComponent, DeliveryComponent },
}
</script>
