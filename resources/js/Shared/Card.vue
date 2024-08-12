<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
    >
        <Link :href="'/' + catSlug + '/' + productDetails.slug">
            <img
                class="rounded-t-lg"
                :src="'/images/' + productDetails.image"
                alt=""
            />
        </Link>
        <div class="p-5">
            <Link :href="'/' + catSlug + '/' + productDetails.slug">
                <h5
                    class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ productDetails.title }}
                </h5>
            </Link>

            <p class="text-gray-600">
                {{ productDetails.description.substring(0, 50) }}...
            </p>

            <div class="flex justify-between mt-5">
                <p
                    class="mb-3 font-normal text-green-700 dark:text-green-700 font-bold"
                >
                    {{ productDetails.currency }}
                    {{
                        productDetails.price
                            .toString()
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    }}
                </p>

                <span>
                    <div class="badge">
                        <svg
                            class="inline-block w-5"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        <span>{{ productDetails.date_online }}</span>
                    </div>
                </span>
            </div>

            <div class="mt-5">
                <Link
                    :href="'/' + catSlug + '/' + productDetails.slug"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-orange-700 rounded-lg"
                >
                    Read more
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
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    productDetails: Array,
    catSlug: String,
});
</script>
