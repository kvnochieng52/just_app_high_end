<template>
    <form @submit.prevent="submitSearchForm">
        <div class="md:flex md:justify-between">
            <div class="w-full md:w-4/12 p-2">
                <select
                    v-model="form.category"
                    id="category"
                    name="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-4"
                    placeholder="Select Category"
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
                    class="text-red-500 font-bold text-sm bg-gray-800 mt-2 pt-1 pb-1"
                ></div>
            </div>

            <div class="w-full md:w-4/12 p-2">
                <input
                    v-model="form.keywords"
                    type="search"
                    id="keywords"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Enter Keywords....e.g. Mercedes benz"
                    name="keywords"
                    dusk="keywords"
                />
            </div>

            <div class="w-full md:w-4/12 p-2">
                <button
                    class="w-full flex-auto bg-orange-600 text-gray-100 hover:bg-orange-400 font-bold py-4 px-4 rounded inline-flex items-center"
                    dusk="submitSearch"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                        />
                    </svg>
                    <span>Search Products</span>
                </button>
            </div>
        </div>
    </form>
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
