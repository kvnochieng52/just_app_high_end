<template>
    <div class="border border-gray-400">
        <h1 class="text bg-gray-200 p-2 pl-8 font-bold">ADVANCED SEARCH</h1>
        <form @submit.prevent="submitSearchForm" class="p-4">
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="categories"
                >
                    Select Category
                </label>

                <select
                    v-model="form.category"
                    id="categories"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Select Category"
                    name="category"
                    dusk="category"
                >
                    <option
                        v-for="(category, id) in Categories"
                        :key="id"
                        :value="id"
                    >
                        {{ category }}
                    </option>
                </select>

                <div
                    v-if="$page.props.errors.category"
                    v-text="$page.props.errors.category"
                    class="text-red-500 font-bold tex-sm"
                ></div>
            </div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="keywords"
                >
                    Keywords
                </label>
                <input
                    v-model="form.keywords"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="keywords"
                    type="text"
                    placeholder="Enter Keywords"
                    name="keywords"
                    dusk="keywords"
                />

                <div
                    v-if="$page.props.errors.keywords"
                    v-text="$page.props.errors.keywords"
                    class="text-red-500 font-bold tex-sm"
                ></div>
            </div>

            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="price_from"
                >
                    Price From
                </label>
                <input
                    v-model="form.priceFrom"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="price_from"
                    type="number"
                    placeholder="Price From..."
                    name="price_from"
                    dusk="price_from"
                />

                <div
                    v-if="$page.props.errors.price_from"
                    v-text="$page.props.errors.price_from"
                    class="text-red-500 font-bold tex-sm"
                ></div>
            </div>

            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="price_to"
                >
                    Price To
                </label>
                <input
                    v-model="form.priceTo"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="price_to"
                    type="number"
                    placeholder="Price To..."
                    name="price_to"
                    dusk="price_to"
                />

                <div
                    v-if="$page.props.errors.price_to"
                    v-text="$page.props.errors.price_to"
                    class="text-red-500 font-bold tex-sm"
                ></div>
            </div>

            <button
                class="w-full flex-auto bg-blue-600 text-gray-100 hover:bg-blue-400 font-bold py-2 px-2 rounded inline-flex items-center"
                dusk="submitSearch"
            >
                <span>Search Products</span>
            </button>
        </form>
    </div>
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
    priceFrom: "",
    priceTo: "",
});

let submitSearchForm = () => {
    Inertia.get("/product/search", form);
};
</script>
