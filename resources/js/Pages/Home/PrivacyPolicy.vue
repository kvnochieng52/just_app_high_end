<template>
   <h2>TEST</h2>
</template>

<script setup>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    Categories: Array,
});

let form = reactive({
    category: "",
    keywords: "",
});

let submitSearchForm = () => {
    Inertia.get("/product/search", form);
};
</script>
