<template>
    <div
        class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
    >
        <Link
            href="#"
            aria-current="true"
            class="block py-2 px-4 w-full text-white bg-blue-700 rounded-t-lg border-b border-gray-200 cursor-pointer dark:bg-gray-800 dark:border-gray-600"
        >
            Dashboard
        </Link>
        <Link
            href="/dashboard/"
            class="block py-2 px-4 w-full border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white"
        >
            Products
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>
