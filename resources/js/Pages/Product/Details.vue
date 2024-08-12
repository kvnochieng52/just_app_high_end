<template>
    <Head :title="product_details.title" />
    <div class="container mx-auto">
        <div class="md:flex md:justify-between">
            <div class="w-full md:w-8/12 md:mr-5 pt-4">
                <div class="md:flex md:justify-between">
                    <div class="w-full md:w-8/12 md:mr-5">
                        <h1 class="text-2xl">
                            {{ product_details.title }}
                        </h1>
                    </div>

                    <div class="w-full md:w-4/12 md:mr-5">
                        <p
                            class="text-green-700 text-3xl text-right dark:text-green-700 font-bold"
                        >
                            {{ product_details.currency }}
                            {{
                                product_details.price
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }}
                        </p>
                    </div>
                </div>

                <hr />

                <br />

                <img :src="'/images/' + product_details.image" />
                <br />

                <h2 class="text-xl font-bold">Description</h2>
                <hr />

                <p class="py-5">{{ product_details.description }}</p>
                <hr />
                <div class="md:flex md:justify-between pt-5">
                    <div class="w-full md:w-4/12 md:mr-5">
                        <p>
                            <span class="font-bold"> Date Posted:</span>
                            <br />
                            {{ product_details.date_online }}
                        </p>
                    </div>
                    <div class="w-full md:w-4/12 md:mr-5">
                        <p>
                            <span class="font-bold"> Expiry Date:</span>
                            <br />
                            {{ product_details.date_offline }}
                        </p>
                    </div>

                    <div class="w-full md:w-4/12 md:mr-5">
                        <p>
                            <span class="font-bold"> Category:</span>
                            <br />

                            {{ product_details.category_name }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-4/12 border border-gray-400">
                <h1 class="text-xl text-gray-400 bg-blue-800 p-2 pl-8">
                    CONTACT SELLER
                </h1>

                <div class="w-full">
                    <form
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    >
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="full_name"
                            >
                                Your Full Names
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="full_name"
                                type="text"
                                placeholder="Full Name"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="email"
                            >
                                Email Address
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="email"
                                type="email"
                                placeholder="Email Address"
                            />
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="telephone"
                            >
                                Telephone
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="telephone"
                                type="text"
                                placeholder="Telephone"
                            />
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="message"
                            >
                                Message
                            </label>

                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="button"
                            >
                                SEND MESSAGE
                            </button>
                        </div>
                    </form>
                </div>

                <div class="md:flex md:justify-between">
                    <div class="w-full md:w-4/12 md:mr-5 pl-4">
                        <!-- AddToAny BEGIN -->
                        <p class="fint-bold">SHARE THIS:</p>
                    </div>
                    <div class="w-full md:w-8/12 md:mr-5 pl-4">
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <a
                                class="a2a_dd"
                                href="https://www.addtoany.com/share"
                            ></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_email"></a>
                            <a class="a2a_button_whatsapp"></a>
                        </div>
                    </div>
                </div>

                <!-- AddToAny END -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    product_details: Array,
});

onMounted(() => {
    let recaptchaScript = document.createElement("script");
    recaptchaScript.setAttribute(
        "src",
        "https://static.addtoany.com/menu/page.js"
    );
    document.head.appendChild(recaptchaScript);
});
</script>
