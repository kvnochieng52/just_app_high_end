<template>
    <div class="container mx-auto">
        <div class="md:flex md:justify-between">
            <div class="w-full md:w-9/12 md:mr-5 pt-4">
                <div
                    class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="flex items-center justify-between mb-4">
                        <h5
                            class="text-xl font-bold leading-none text-gray-900 dark:text-white"
                        >
                            Search Results
                        </h5>
                        <a
                            v-if="products.total > 0"
                            href="#"
                            class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
                        >
                            {{ products.total }} Records found
                        </a>
                    </div>
                    <p
                        class="text-red-600 font-bold"
                        v-if="products.total == 0"
                    >
                        No Product found matching your Query. Please check your
                        query and try again
                    </p>

                    <div v-if="products.total > 0">
                        <div class="flow-root">
                            <ul
                                role="list"
                                class="divide-y divide-gray-200 dark:divide-gray-700"
                            >
                                <li
                                    class="py-3 sm:py-4"
                                    v-for="(
                                        productDetails, productKey
                                    ) in products.data"
                                    :key="productKey"
                                >
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <Link
                                                :href="
                                                    '/' +
                                                    productDetails.category_slug +
                                                    '/' +
                                                    productDetails.slug
                                                "
                                            >
                                                <img
                                                    class="w-40 h-35 rounded"
                                                    :src="
                                                        '/images/' +
                                                        productDetails.image
                                                    "
                                                />
                                            </Link>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-xl font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                <Link
                                                    :href="
                                                        '/' +
                                                        productDetails.category_slug +
                                                        '/' +
                                                        productDetails.slug
                                                    "
                                                >
                                                    {{ productDetails.title }}
                                                </Link>
                                            </p>
                                            <p
                                                class="text-base text-gray-500 truncate dark:text-gray-400"
                                            >
                                                {{ productDetails.description }}
                                            </p>

                                            <p
                                                class="text-sm text-gray-900 truncate dark:text-gray-400"
                                            >
                                                <span class="font-bold"
                                                    >Date Posted:</span
                                                >
                                                {{
                                                    productDetails.formatted_date
                                                }}
                                                |
                                                <span class="font-bold">
                                                    Category:
                                                </span>

                                                {{
                                                    productDetails.category_name
                                                }}
                                                |
                                                <span class="font-bold">
                                                    Date Offline:
                                                </span>

                                                {{
                                                    productDetails.date_offline
                                                }}
                                            </p>

                                            <p
                                                class="font-bold text-green-900 dark:text-white"
                                            >
                                                <Link
                                                    :href="
                                                        '/' +
                                                        productDetails.category_slug +
                                                        '/' +
                                                        productDetails.slug
                                                    "
                                                >
                                                    {{
                                                        productDetails.currency
                                                    }}
                                                    {{
                                                        productDetails.price
                                                            .toString()
                                                            .replace(
                                                                /\B(?=(\d{3})+(?!\d))/g,
                                                                ","
                                                            )
                                                    }}
                                                </Link>
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center">
                                            <Link
                                                :href="
                                                    '/' +
                                                    productDetails.category_slug +
                                                    '/' +
                                                    productDetails.slug
                                                "
                                                class="px-2 py-1 inline-flex items-center text-sm text-center text-white bg-orange-700 rounded-lg"
                                            >
                                                More Details
                                                <svg
                                                    aria-hidden="true"
                                                    class="w-4 h-4 ml-2 -mr-1"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    ></path>
                                                </svg>
                                            </Link>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-6" v-if="products.total > 0">
                    <ul class="inline-flex -space-x-px">
                        <Paginator :Links="products.links" />
                    </ul>
                </div>
            </div>

            <div class="w-full md:w-3/12 md:mr-5 pt-4">
                <AdvancedSearch :Categories="categories" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Paginator from "../../Shared/Paginator.vue";
import AdvancedSearch from "../../Shared/AdvancedSearch.vue";
defineProps({
    products: Array,
    categories: Array,
});
</script>
