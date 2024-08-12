<template>
    <div class="container mx-auto">
        <div class="md:flex md:justify-between">
            <div class="w-full md:w-3/12 md:mr-5 pt-4">
                <SideBar />
            </div>

            <div class="w-full md:w-9/12 md:mr-5 pt-4">
                <h3>New Product</h3>
                <hr />
                <form
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    @submit.prevent="submitForm"
                >
                    <div class="md:flex md:justify-between">
                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="title"
                            >
                                Product Title
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="title"
                                type="text"
                                placeholder="Enter Product Title"
                                name="title"
                                v-model="form.title"
                                dusk="title"
                            />

                            <div
                                v-if="$page.props.errors.title"
                                v-text="$page.props.errors.title"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>

                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="categories"
                            >
                                Select Category
                            </label>

                            <select
                                id="categories"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Select Category"
                                name="category"
                                v-model="form.category"
                                dusk="category"
                            >
                                <option
                                    v-for="(category, id) in categories"
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
                    </div>

                    <div class="md:flex md:justify-between">
                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
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
                                name="email"
                                v-model="form.email"
                                dusk="email"
                            />

                            <div
                                v-if="$page.props.errors.email"
                                v-text="$page.props.errors.email"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>

                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
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
                                name="telephone"
                                v-model="form.telephone"
                                dusk="telephone"
                            />

                            <div
                                v-if="$page.props.errors.telephone"
                                v-text="$page.props.errors.telephone"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>
                    </div>

                    <div class="md:flex md:justify-between">
                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="description"
                            >
                                Date Online
                            </label>

                            <Datepicker
                                id="date_online"
                                name="date_online"
                                v-model="form.date_online"
                                format="dd-MM-yyyy"
                                dusk="date_online"
                            ></Datepicker>
                            <div
                                v-if="$page.props.errors.date_online"
                                v-text="$page.props.errors.date_online"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>

                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="description"
                            >
                                Date Offline
                            </label>

                            <Datepicker
                                id="date_offline"
                                v-model="form.date_offline"
                                name="date_offline"
                                format="dd-MM-yyyy"
                                dusk="date_offline"
                            ></Datepicker>

                            <div
                                v-if="$page.props.errors.date_offline"
                                v-text="$page.props.errors.date_offline"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>
                    </div>

                    <div class="md:flex md:justify-between">
                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <div>
                                <label
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                    for="telephone"
                                >
                                    Price
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="price"
                                    type="number"
                                    placeholder="price"
                                    name="price"
                                    v-model="form.price"
                                    dusk="price"
                                />
                                <div
                                    v-if="$page.props.errors.price"
                                    v-text="$page.props.errors.price"
                                    class="text-red-500 font-bold tex-sm"
                                ></div>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                    for="description"
                                >
                                    Upload Photo
                                </label>

                                <input
                                    type="file"
                                    @input="form.image = $event.target.files[0]"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    name="image"
                                    dusk="image"
                                />

                                <div
                                    v-if="$page.props.errors.image"
                                    v-text="$page.props.errors.image"
                                    class="text-red-500 font-bold tex-sm"
                                ></div>
                            </div>
                        </div>

                        <div class="mb-4 w-full md:w-6/12 md:mr-5">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="description"
                            >
                                Product Description
                            </label>

                            <textarea
                                name="description"
                                rows="6"
                                v-model="form.description"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                dusk="description"
                            ></textarea>

                            <div
                                v-if="$page.props.errors.description"
                                v-text="$page.props.errors.description"
                                class="text-red-500 font-bold tex-sm"
                            ></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <progress
                            v-if="form.progress"
                            :value="form.progress.percentage"
                            max="100"
                        >
                            {{ form.progress.percentage }}%
                        </progress>
                        <br />
                        <button
                            :disabled="!isEnabled"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            dusk="submitForm"
                        >
                            SUBMIT PRODUCT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import SideBar from "../../Pages/Dashboard/SideBar.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
defineProps({
    categories: Array,
});

let form = useForm({
    title: "",
    category: "",
    email: "",
    telephone: "",
    date_online: "",
    date_offline: "",
    price: "",
    description: "",
    image: "",
    // image: "",
});

let isEnabled = ref(true);

let submitForm = () => {
    form.post("/dashboard/store", form, {
        forceFormData: true,
        onStart: () => (isEnabled.value = false),
        onFinish: () => {
            isEnabled.value = true;
        },
    });
};
</script>
