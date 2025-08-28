<template>
  <Head
    title="Just Homes- Classifieds, Dealer, Rentel, Builder and Agent Properties Listing"
  />

  <!-- Google Fonts for smooth bold titles -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- <HomeSearch /> -->
  <div id="main">
    <section class="banner-1 section-first">
      <div class="container">
        <div
          class="row justify-content-center align-items-center"
          style="min-height: 90vh"
        >
          <div class="col-12 col-md-11 col-lg-10 text-center">
            <!-- Added text-center here -->

            <!-- Centered Post New Button -->
            <div class="d-flex justify-content-center mt-7">
              <!-- <Link
                href="/post"
                class="btn btn-purple rounded-circle d-flex flex-column align-items-center justify-content-center"
              >
                <i class="fa fa-plus mb-1" style="font-size: 30px"></i>
                <span class="small" style="font-size: 10px">Post New</span>
              </Link> -->
            </div>

            <form @submit.prevent="submitForm" class="w-100">
              <!-- Rest of your form remains exactly the same -->
              <div class="container mt-10">
                <div class="search-bar p-6">
                  <div class="row">
                    <div class="col-md-3">
                      <div
                        class="btn-group btn-group-toggle mb-3 w-100"
                        data-toggle="buttons"
                      >
                        <label
                          class="btn btn-outline-success"
                          :class="{ active: form.leaseType == '2' }"
                        >
                          <input
                            type="radio"
                            name="buyRent"
                            id="2"
                            v-model="form.leaseType"
                            value="2"
                          />
                          Buy
                        </label>
                        <label
                          class="btn btn-outline-success"
                          :class="{ active: form.leaseType == '1' }"
                        >
                          <input
                            type="radio"
                            name="buyRent"
                            id="1"
                            v-model="form.leaseType"
                            value="1"
                          />
                          Rent
                        </label>
                      </div>
                      <div id="">
                        <div
                          class="btn-group btn-group-toggle w-100"
                          data-toggle="buttons"
                        >
                          <label
                            class="btn btn-outline-success"
                            :class="{ active: form.offplan == 'all' }"
                          >
                            <input
                              type="radio"
                              name="offplan"
                              id="ofpplan-all"
                              autocomplete="off"
                              value="all"
                              v-model="form.offplan"
                            />
                            All
                          </label>
                          <label
                            class="btn btn-outline-success"
                            :class="{ active: form.offplan == '0' }"
                          >
                            <input
                              type="radio"
                              name="offplan"
                              id="offplan-0"
                              autocomplete="off"
                              value="0"
                              v-model="form.offplan"
                            />
                            Ready
                          </label>
                          <label
                            class="btn btn-outline-success"
                            :class="{ active: form.offplan == '1' }"
                          >
                            <input
                              type="radio"
                              name="offplan"
                              id="offplan-1"
                              autocomplete="off"
                              value="1"
                              v-model="form.offplan"
                            />
                            Off-Plan
                          </label>
                        </div>
                      </div>

                      <div class="form-group pt-5">
                        <div class="form-check">
                          <input
                            type="checkbox"
                            class="form-check-input"
                            id="onAuction"
                            value="1"
                            v-model="form.onauction"
                          />
                          <label class="form-check-label" for="onAuction">
                            <strong> On Auction</strong>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group col-md-12">
                        <div class="row">
                          <input
                            id="autocomplete"
                            class="form-control"
                            type="text"
                            placeholder="Enter a location (town, estate, etc.)"
                            v-model="form.propertyLocation"
                          />
                        </div>
                      </div>

                      <!-- <div class="row">
                        <div class="form-group col-md-12">
                          <SimpleTypeahead
                            id="typeahead_id"
                            placeholder="Enter the Location"
                            :items="locations2"
                            :minInputLength="3"
                            :itemProjection="itemProjectionFunction"
                            @selectItem="selectItemEventHandler"
                            @onInput="onInputEventHandler"
                            @onFocus="onFocusEventHandler"
                            @onBlur="onBlurEventHandler"
                            class="form-control"
                          >
                            <template #list-item-text="slot">
                              <span
                                v-html="
                                  slot.boldMatchText(
                                    slot.itemProjection(slot.item)
                                  )
                                "
                              ></span>
                            </template>
                          </SimpleTypeahead>
                          <span>
                            <i class="fa fa-map-marker location-gps me-1"></i>
                          </span>
                        </div>
                      </div> -->

                      <div class="row">
                        <div class="form-group col-md-4 appartment_types">
                          <multiselect
                            v-model="form.propertyType"
                            :options="propertyTypeOptions"
                            :multiple="true"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Property Type"
                            label="name"
                            track-by="id"
                            :preselect-first="false"
                          >
                            <template #selection="{ values, isOpen }">
                              <span v-if="values.length && !isOpen">
                                <span
                                  v-for="(value, index) in values"
                                  :key="index"
                                  class="multiselect__tag"
                                >
                                  {{ value.name }}
                                  <span v-if="index < values.length - 1"></span>
                                </span>
                              </span>
                            </template>
                          </multiselect>
                        </div>

                        <div class="form-group col-md-4">
                          <multiselect
                            v-model="form.bedroom"
                            :options="bedroomOptions"
                            :multiple="true"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Bedrooms"
                            label="name"
                            track-by="id"
                            :preselect-first="false"
                          >
                            <template #selection="{ values, isOpen }">
                              <span v-if="values.length && !isOpen">
                                <span
                                  v-for="(value, index) in values"
                                  :key="index"
                                  class="multiselect__tag"
                                >
                                  {{ value.name }}
                                  <span v-if="index < values.length - 1"></span>
                                </span>
                              </span>
                            </template>
                          </multiselect>
                        </div>
                        <div class="form-group col-md-4">
                          <multiselect
                            v-model="form.selectedPrice"
                            :options="priceOptions"
                            :multiple="false"
                            :close-on-select="true"
                            placeholder="Price"
                            label="name"
                            track-by="id"
                          ></multiselect>
                        </div>
                      </div>

                      <button
                        type="submit"
                        class="btn btn-success"
                        style="
                          float: right;
                          margin-top: 15px;
                          background-color: #24894a !important;
                        "
                      >
                        <i class="fa fa-search"></i> SEARCH
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="header-text text mb-0">
        <div class="container">
          <!-- <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 d-block">
              <div class="item-search-tabs">
                <form
                  id="register_form"
                  method="get"
                  @submit.prevent="submitForm"
                >
                  <div class="item-search-menu">
                    <ul class="nav">
                      <li class="">
                        <a
                          href="#"
                          class="active"
                          data-bs-toggle="tab"
                          v-on:click.prevent.stop="typeSelect(2)"
                        >
                          <strong>Buy</strong>
                        </a>
                      </li>
                      <li>
                        <a
                          href="#"
                          data-bs-toggle="tab"
                          v-on:click.prevent.stop="typeSelect(1)"
                        >
                          <strong>Rent</strong>
                        </a>
                      </li>
                      <li>
                        <a href="/post"><strong>Sell</strong></a>
                      </li>
                    </ul>
                  </div>

                  <div class="tab-content index-search-select">
                    <div class="">
                      <div class="form row no-gutters">
                        <div
                          class="form-group col-xl-11 col-lg-11 col-md-12 mb-0"
                        >
                          <SimpleTypeahead
                            id="typeahead_id"
                            placeholder="Enter the Location"
                            :items="locations2"
                            :minInputLength="3"
                            :itemProjection="itemProjectionFunction"
                            @selectItem="selectItemEventHandler"
                            @onInput="onInputEventHandler"
                            @onFocus="onFocusEventHandler"
                            @onBlur="onBlurEventHandler"
                            class="form-control"
                          >
                            <template #list-item-text="slot">
                              <span
                                v-html="
                                  slot.boldMatchText(
                                    slot.itemProjection(slot.item)
                                  )
                                "
                              ></span>
                            </template>
                          </SimpleTypeahead>
                          <span>
                            <i class="fa fa-map-marker location-gps me-1"></i>
                          </span>
                        </div>
                        <div class="col-xl-1 col-lg-1 col-md-12 mb-0">
                          <button
                            type="submit"
                            class="btn btn-block btn-secondary fs-14 green_b"
                          >
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </section>
  </div>

  <section
    class="sptb bg-white"
    style="padding-top: 30px; padding-bottom: 50px"
  >
    <div class="container">
      <div class="section-title center-block text-center">
        <h2 style="font-size: 35px">Our Trusted Partners</h2>
        <p>
          We collaborate with industry leaders to provide you with the best real
          estate experience
        </p>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="partners-carousel">
            <div
              id="partnersCarousel"
              class="carousel slide"
              data-bs-ride="carousel"
            >
              <div class="carousel-inner">
                <div
                  class="carousel-item"
                  :class="{ active: index === 0 }"
                  v-for="(chunk, index) in partnerChunks"
                  :key="index"
                >
                  <div class="row mobile-row">
                    <div
                      class="partner-column"
                      v-for="(partner, partnerIndex) in chunk"
                      :key="partnerIndex"
                    >
                      <a :href="partner.url" class="partner-link">
                        <div class="partner-card">
                          <img
                            :src="partner.image"
                            :alt="partner.name"
                            class="partner-image"
                          />
                          <div class="partner-info">
                            <h4 class="partner-name">{{ partner.name }}</h4>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#partnersCarousel"
                data-bs-slide="prev"
              >
                <span
                  class="carousel-control-prev-icon"
                  aria-hidden="true"
                ></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#partnersCarousel"
                data-bs-slide="next"
              >
                <span
                  class="carousel-control-next-icon"
                  aria-hidden="true"
                ></span>
                <span class="visually-hidden">Next</span>
              </button>
              <div class="carousel-indicators">
                <button
                  v-for="(chunk, index) in partnerChunks"
                  :key="index"
                  type="button"
                  data-bs-target="#partnersCarousel"
                  :data-bs-slide-to="index"
                  :class="{ active: index === 0 }"
                  :aria-current="index === 0 ? 'true' : 'false'"
                  :aria-label="'Slide ' + (index + 1)"
                ></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="sptb" style="padding-top: 30px">
    <div class="container">
      <h2 style="text-align: center; font-size: 35px" class="pb-3 pt-3">
        Explore Our Wide Range of Luxury Properties
      </h2>

      <div style="display: flex; justify-content: center; align-items: center">
        <Link
          href="/search/?search=1"
          class="btn btn-info"
          style="background: #24894a; border-color: #24894a !important"
        >
          <strong> EXPLORE ALL THE PROPERTIES</strong>
        </Link>
        <!-- <a
          href="#"
          class="btn btn-success"
          style="background: purple; border-radius: 40px; font-size: 14px"
        >
          EXPLORE RESIDENCE
        </a> -->
      </div>
    </div>

    <div class="container pt-5">
      <!-- <div class="row">
        <div>test</div>
      </div> -->

      <SkeletonLoader v-if="!processing" />

      <div class="row">
        <div
          class="col-xl-4 col-lg-4 col-md-6 col-sm-12"
          v-for="(property, propKey) in listData"
          :key="propKey"
        >
          <PropertyCard :property="property" />
        </div>

        <div
          style="display: flex; justify-content: center; align-items: center"
          class="col-md-12"
        >
          <Link
            href="/search/?search=1"
            class="btn btn-success"
            style="background: #24894a"
          >
            <strong> EXPLORE ALL THE PROPERTIES</strong>
          </Link>
        </div>
      </div>
    </div>
  </section>

  <section class="sptb bg-white">
    <div class="container">
      <div class="section-title center-block text-center">
        <h2 style="font-size: 35px">What Makes Us The Preferred Choice ?</h2>
        <p>
          At Just Homes, we combine market expertise, personalized service, and
          innovative technology to make your real estate journey seamless and
          satisfying.
        </p>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="">
            <div class="mb-lg-0 mb-5">
              <div class="service-card text-center">
                <div class="bg-white icon-bg icon-service about">
                  <i class="fe fe-pocket"></i>
                </div>
                <div class="servic-data mt-3">
                  <h4 class="font-weight-semibold mb-2">Buyers Trust Us</h4>
                  <p class="text-muted mb-0">
                    We empower buyers with expert guidance and a seamless
                    experience in finding their dream home.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="">
            <div class="mb-sm-0 mb-5">
              <div class="service-card text-center">
                <div class="bg-white icon-bg icon-service about">
                  <i class="fe fe-thumbs-up"></i>
                </div>
                <div class="servic-data mt-3">
                  <h4 class="font-weight-semibold mb-2">Seller Prefer Us</h4>
                  <p class="text-muted mb-0">
                    We provide sellers with expert insights and personalized
                    support to maximize property value and streamline the
                    selling process.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="">
            <div class="mb-sm-0 mb-5">
              <div class="service-card text-center">
                <div class="bg-white icon-bg icon-service about">
                  <i class="fe fe-file-text"></i>
                </div>
                <div class="servic-data mt-3">
                  <h4 class="font-weight-semibold mb-2">Maximum Choices</h4>
                  <p class="text-muted mb-0">
                    Explore a wide range of properties tailored to your needs,
                    ensuring you find the perfect fit for your lifestyle.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="">
            <div class="">
              <div class="service-card text-center">
                <div class="bg-white icon-bg icon-service about">
                  <i class="fe fe-users"></i>
                </div>
                <div class="servic-data mt-3">
                  <h4 class="font-weight-semibold mb-2">Expert Guidance</h4>
                  <p class="text-muted mb-0">
                    Our experienced team is here to provide personalized support
                    and insights, ensuring you make informed decisions every
                    step of the way.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="sptb">
    <div class="container">
      <div class="section-title center-block text-center">
        <h2>Download Our App</h2>
        <p>Download Just app From Google Play Store and App Store</p>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="text-center text-wrap">
            <div class="btn-list">
              <a
                href="https://play.google.com/store/apps/details?id=ke.co.justhomes.app"
                class="btn btn-success btn-lg mb-sm-0"
                style="
                  background: #24894a !important;
                  border-color: #24894a !important;
                "
                ><i class="fa fa-android fa-1x me-2"></i> Google Play</a
              >
              <a
                href="https://apps.apple.com/app/just-homes-kenya/id6693024490"
                class="btn btn-success btn-lg mb-sm-0"
                style="
                  background: #24894a !important;
                  border-color: #24894a !important;
                "
                ><i class="fa fa-apple fa-1x me-2"></i> Apple Store</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- <div class="container mx-auto" v-if="processing">
    <div
      class="category_listing"
      v-for="(listCat, catKey) in listData"
      :key="catKey"
    >
      <h4 class="font-bold pb-2 mt-12 border-b border-gray-200 text-xl">
        Latest {{ listCat.category_name }}
      </h4>

      <div class="md:flex md:justify-between">
        <div
          class="w-full md:w-3/12 p-2"
          v-for="(productDetails, productKey) in listCat.product_list"
          :key="productKey"
        >
          <Card
            :productDetails="productDetails"
            :catSlug="listCat.category_slug"
          />
        </div>
      </div>
    </div>
  </div> -->
</template>
<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { ref, onMounted, reactive, computed } from "vue";
// No external carousel library needed

import SkeletonLoader from "../../Shared/SkeletonLoader.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { Link } from "@inertiajs/inertia-vue3";
import SimpleTypeahead from "vue3-simple-typeahead";
import "vue3-simple-typeahead/dist/vue3-simple-typeahead.css";
import { useForm } from "@inertiajs/inertia-vue3";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
import PropertyCard from "../Property/details/PropertyCard.vue";

const isOpen = ref(false);
const partners = ref([
  {
    name: "Make Magic Yours",
    image: "/images/partners/mmy_real_estate.jpg",
    url: "/profile/364",
  },
  {
    name: "Jay Comfie Homes",
    image: "/images/partners/jay_comfie_homes.jpg",
    url: "/profile/205",
  },
  {
    name: "NickLink Properties",
    image: "/images/partners/nicklink.JPG",
    url: "profile/204",
  },
  {
    name: "One Eleven Properties",
    image: "/images/partners/one_eleven.jpg",
    url: "/profile/176",
  },
  {
    name: "Maxiven Realtors",
    image: "/images/partners/maxiven.jpg",
    url: "/profile/363",
  },
  {
    name: "Make Magic Yours",
    image: "/images/partners/mmy_real_estate.jpg",
    url: "/profile/364",
  },
  {
    name: "Jay Comfie Homes",
    image: "/images/partners/jay_comfie_homes.jpg",
    url: "/profile/205",
  },
]);
const selectedTab = ref("residential");

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const selectTab = (tab) => {
  selectedTab.value = tab;
};

// const formatAmount = (amount) => {
//   if (!amount) return "0";
//   return new Intl.NumberFormat("en-US").format(amount);
// };

let props = defineProps({
  locations: Array,
  propertyTypes: Array,
});

let selectedpropertyType = ref([]);
// let propertyTypeOptions = ref([
//   { id: 1, name: "Appartment" },
//   { id: 2, name: "House" },
// ]);

let propertyTypeOptions = ref(props.propertyTypes);

let selectedBeds = ref([]);
let bedroomOptions = ref([
  { id: 1, name: "1 Bedroom" },
  { id: 2, name: "2 Bedrooms" },
  { id: 3, name: "3 Bedrooms" },
  { id: 4, name: "4 Bedrooms" },
  { id: 5, name: "5 Bedrooms" },
  { id: 6, name: "6 Bedrooms" },
  { id: 7, name: "7 Bedrooms" },
  { id: 8, name: "8 Bedrooms" },
  { id: 9, name: "9 Bedrooms" },
  { id: 10, name: "10 Bedrooms" },
  { id: 11, name: "11 Bedrooms" },
  { id: 12, name: "12+ Bedrooms" },
]);

const selectedPrice = ref(null);

const priceOptions = [
  { id: " 0 - 1000000", name: "0 - 1,000,000" },
  { id: "1000000 - 2000000", name: "1,000,000 - 2,000,000" },
  { id: "2000000 - 3000000", name: "2,000,000 - 3,000,000" },
  { id: "3000001", name: "3,000,000+" },
];
let processing = ref(false);

let locations2 = ref([]);

let selectedRegion = ref("");

let listData = ref([]);
let fetchListingData = () => {
  axios.get("/home/fetch_latest_listings").then((res) => {
    listData.value = res.data;
    processing.value = true;
  });
};

// Compute partner chunks for the carousel (5 partners per slide)
const partnerChunks = computed(() => {
  const chunks = [];
  const chunkSize = 5; // 5 partners per slide

  for (let i = 0; i < partners.value.length; i += chunkSize) {
    chunks.push(partners.value.slice(i, i + chunkSize));
  }

  return chunks;
});

onMounted(() => {
  fetchListingData();
  loadGoogleMaps();
});

let onInputEventHandler = (data) => {
  if (data.input.length >= 3) {
    axios.get("/home/fetch_location_axios/" + data.input).then((res) => {
      locations2.value = res.data;

      console.log("here", res.data);
    });
  } else {
    console.log("4");
  }
};

let selectItemEventHandler = (item) => {
  // console.log(item);
};

let onBlurEventHandler = (selValue) => {
  selectedRegion.value = selValue.input;
};

let form = useForm({
  search: 1,
  quickSearch: 1,
  region: selectedRegion,
  leaseType: "2",
  propertyType: [],
  bedroom: [],
  offplan: "all",
  selectedPrice: "",
  onauction: "",

  //maps fileds

  propertyLocation: "",
  address: "",
  town: "",
  subRegion: "",
  country: "",
  countryCode: "",
  latitude: null,
  longitude: null,
});

let submitForm = () => {
  form.propertyType = form.propertyType.map((option) => option.id);
  form.bedroom = form.bedroom.map((option) => option.id);
  // form.selectedPrice = form.selectedPrice.map((option) => option.id);
  form.get("/search/", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};

// const mapsForm = reactive({
//   propertyLocation: "",
//   address: "",
//   town: "",
//   subRegion: "",
//   country: "",
//   countryCode: "",
//   latitude: null,
//   longitude: null,
// });

// const loadGoogleMaps = () => {
//   // Check if Google Maps API is already loaded
//   if (window.google && window.google.maps) {
//     initAutocomplete();
//     return;
//   }

//   // Create script element
//   const script = document.createElement("script");
//   script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBP_0fcfVMUL_4vQmkOa1dKjJJslcVUJ44&libraries=places&callback=initMap`;
//   script.async = true;
//   script.defer = true;

//   // Define callback function
//   window.initMap = () => {
//     initAutocomplete();
//   };

//   // Handle errors
//   script.onerror = () => {
//     console.error("Failed to load Google Maps API");
//   };

//   document.head.appendChild(script);
// };

// const initAutocomplete = () => {
//   const input = document.getElementById("autocomplete");
//   if (!input) return;

//   const options = {
//     componentRestrictions: { country: "ke" }, // Restrict to Kenya
//     types: ["(regions)"], // Focus on cities, neighborhoods

//     fields: ["address_components", "formatted_address", "geometry", "name"],
//   };

//   const autocomplete = new google.maps.places.Autocomplete(input, options);
//   autocomplete.addListener("place_changed", () => onPlaceChanged(autocomplete));
// };

// const onPlaceChanged = (autocomplete) => {
//   const place = autocomplete.getPlace();
//   if (!place.geometry) return;

//   mapsForm.address = place.formatted_address || "";
//   mapsForm.propertyLocation = mapsForm.address;

//   if (place.geometry.location) {
//     mapsForm.latitude = place.geometry.location.lat();
//     mapsForm.longitude = place.geometry.location.lng();
//   }

//   extractLocationDetails(place);
// };

// const extractLocationDetails = (place) => {
//   mapsForm.town = "";
//   mapsForm.subRegion = "";
//   mapsForm.country = "";
//   mapsForm.countryCode = "";

//   if (place.address_components) {
//     place.address_components.forEach((component) => {
//       const types = component.types;

//       if (types.includes("locality")) {
//         mapsForm.town = component.long_name;
//       }

//       if (
//         types.includes("sublocality_level_1") ||
//         types.includes("neighborhood")
//       ) {
//         mapsForm.subRegion = component.long_name;
//       }

//       if (types.includes("country")) {
//         mapsForm.country = component.long_name;
//         mapsForm.countryCode = component.short_name;
//       }
//     });
//   }

//   if (mapsForm.subRegion && mapsForm.town) {
//     mapsForm.address = `${mapsForm.subRegion}, ${mapsForm.town}`;
//   } else if (mapsForm.town) {
//     mapsForm.address = mapsForm.town;
//   } else {
//     mapsForm.address = place.formatted_address || "";
//   }
// };

const loadGoogleMaps = () => {
  if (window.google?.maps?.places) {
    initAutocomplete();
    return;
  }

  const script = document.createElement("script");
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBP_0fcfVMUL_4vQmkOa1dKjJJslcVUJ44&libraries=places&callback=initMap`;
  script.async = true;
  script.defer = true;

  window.initMap = () => {
    initAutocomplete();
  };

  script.onerror = () => {
    console.error("Failed to load Google Maps API");
  };

  document.head.appendChild(script);
};

const initAutocomplete = () => {
  const input = document.getElementById("autocomplete");
  if (!input) return;

  const options = {
    componentRestrictions: { country: "ke" },
    //types: ["(regions)"],
    fields: ["address_components", "formatted_address", "geometry", "name"],
  };

  const autocomplete = new google.maps.places.Autocomplete(input, options);
  autocomplete.addListener("place_changed", () => onPlaceChanged(autocomplete));
};

const onPlaceChanged = (autocomplete) => {
  const place = autocomplete.getPlace();
  if (!place.geometry) return;

  processPlaceDetails(place);
};

const processPlaceDetails = (place) => {
  // Reset form values
  form.town = "";
  form.estate = "";
  form.country = "";
  form.countryCode = "";

  // Always preserve the full selected name as the estate first
  const selectedName = place.name || "";

  if (place.address_components) {
    place.address_components.forEach((component) => {
      const types = component.types;
      const name = component.long_name;

      if (types.includes("locality")) {
        form.town = name;
      } else if (isEstateComponent(types, name)) {
        // Only set estate if not already set from selectedName
        if (!form.estate) form.estate = name;
      } else if (types.includes("country")) {
        form.country = name;
        form.countryCode = component.short_name;
      }
    });
  }

  // Special handling for places like Westlands
  if (selectedName && !form.estate && !form.town) {
    form.estate = selectedName;
  } else if (selectedName && form.town && selectedName !== form.town) {
    form.estate = selectedName;
  }

  // Get coordinates
  if (place.geometry?.location) {
    form.latitude = place.geometry.location.lat();
    form.longitude = place.geometry.location.lng();
  }

  // Build address prioritizing the selected name
  form.address = buildCleanAddress(selectedName);
  form.propertyLocation = form.address;
};

const isEstateComponent = (types, name) => {
  const estateTypes = [
    "sublocality",
    "neighborhood",
    "sublocality_level_1",
    "sublocality_level_2",
  ];
  const isEstateType = estateTypes.some((type) => types.includes(type));
  const isNotAdministrative =
    !name.toLowerCase().includes("county") &&
    !name.toLowerCase().includes("district") &&
    !name.toLowerCase().includes("ward");

  return isEstateType && isNotAdministrative;
};

const buildCleanAddress = (selectedName) => {
  const parts = [];

  // Prioritize the exact name the user selected
  if (selectedName && selectedName !== form.country) {
    if (!form.town || !selectedName.includes(form.town)) {
      parts.push(selectedName);
    }
  }

  // Fall back to estate/town if no selected name worked
  if (parts.length === 0) {
    if (form.estate) parts.push(form.estate);
    if (form.town && form.town !== form.estate) parts.push(form.town);
  } else {
    // Add town if it's not already included
    if (form.town && !selectedName.includes(form.town)) {
      parts.push(form.town);
    }
  }

  if (form.country) parts.push(form.country);

  return parts.join(", ");
};

// onMounted(() => {
//   loadGoogleMaps();
// });
</script>

<style scoped>
.partners-carousel {
  padding: 20px 0;
}

.partner-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.partner-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.partner-image {
  width: 100%;
  height: 200px; /* Fixed height for all partner images */
  object-fit: cover;
  object-position: center;
}

.partner-info {
  padding: 12px 8px;
  text-align: center;
  background-color: #f9f9f9;
}

.partner-name {
  margin: 0;
  color: #24894a; /* Purple color to match site theme */
  font-weight: 600;
  font-size: 14px; /* Reduced font size */
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

@media (max-width: 767px) {
  .partner-name {
    font-size: 12px; /* Even smaller on mobile */
  }

  .partner-image {
    height: 120px; /* Smaller images on mobile */
  }

  .partner-info {
    padding: 10px 5px; /* Less padding on mobile */
  }
}

.partner-visit {
  margin-top: 8px;
  font-size: 14px;
  color: #666;
  transition: color 0.3s ease;
}

.partner-link {
  text-decoration: none;
  display: block;
}

.partner-link:hover .partner-card {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.partner-link:hover .partner-visit {
  color: #24894a;
}

.partner-link:hover .partner-name {
  text-decoration: underline;
}

/* Partners Carousel Styles */
.partners-carousel {
  padding: 0 0px; /* Add padding for the controls */
  position: relative;
}

/* Make partner cards smaller to fit 5 in a row */
.partner-card {
  max-width: 100%;
  margin: 0 auto;
}

.partner-image {
  height: 150px; /* Reduce image height */
}

/* Custom column for partners */
.partner-column {
  position: relative;
  width: 50%; /* Default 2 per row on mobile */
  padding: 0 10px;
  margin-bottom: 20px;
  float: left;
}

/* Medium screens - 3 per row */
@media (min-width: 768px) {
  .partner-column {
    width: 33.333%;
  }
}

/* Large screens - 5 per row */
@media (min-width: 992px) {
  .partner-column {
    width: 20%;
  }
}

/* Fix for mobile row */
.mobile-row {
  display: block;
  margin-right: -10px;
  margin-left: -10px;
}

.mobile-row::after {
  content: "";
  display: table;
  clear: both;
}

/* Make carousel controls more visible */
.carousel-control-prev,
.carousel-control-next {
  width: 40px;
  opacity: 1;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: #24894a;
  padding: 20px;
  border-radius: 50%;
  background-size: 50%;
}

/* Make indicators more visible */
.carousel-indicators {
  bottom: -40px;
}

.carousel-indicators button {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #24894a;
  opacity: 0.5;
  margin: 0 5px;
}

.carousel-indicators button.active {
  opacity: 1;
}
</style>
<style>
.simple-typeahead-list-item,
.simple-typeahead-list-item-text .simple-typeahead-list-item-active {
  color: black !important;
}

.banner-1 {
  background: url("/images/brand/apartment.jpg") no-repeat center center;
  background-size: cover;
  background-color: rgb(31, 31, 31);
  min-height: 100vh; /* Adjust the height as needed */
}

.custom-button-search {
  background-color: #24894a;
  /* background-image: linear-gradient(
    to bottom,
    #6a11cb 0%,
    #24894A 60%,
    #24894A 10%
  ) !important; */
}

.item-card2-img {
  position: relative;
  height: 200px; /* Set a fixed height for the image container */
  overflow: hidden; /* Hide overflow to ensure images don't exceed container height */
}

.item-card2-img img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ensure the image covers the container without stretching */
  object-position: center; /* Center the image */
}

.search-bar {
  background-color: #f8f9fa;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.search-bar .btn,
.search-bar .form-control,
.search-bar .dropdown-menu {
  border-radius: 5px;
}
.search-bar .nav-pills .nav-link.active {
  background-color: #28a745;
  color: #fff;
}

.btn-group .btn {
  width: 100%;
  text-align: center;
}

.button-grid {
  display: inline-flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  padding: 0.5rem;
}

.appartment_types .btn {
  width: 100%;
  float: left;
}

.btn-outline-secondary {
  color: #9307cb;
  background-color: transparent;
  background-image: none;
  border-color: #9307cb;
}

/* .btn-outline-primary:not(:disabled):not(.disabled):active,
.btn-outline-primary:not(:disabled):not(.disabled).active {
  color: #fff;
  background-color: #9307cb !important;
  border-color: #9307cb !important;
} */

.multiselect__option--highlight::after {
  content: none !important;
}

.btn-purple {
  background-color: #24894aa2;
  color: white;
  border: none;
  transition: all 0.3s ease;
  width: 80px;
  height: 80px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border-radius: 50% !important;
  margin: 0 auto;
  /* Center the button */
}

.btn-purple:hover {
  background-color: #24894a;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-purple i {
  line-height: 1;
  margin-bottom: 4px;
}

.btn-purple span {
  font-size: 0.8rem;
  line-height: 1;
}

/* Smooth bold title fonts */
h1, h2, h3, h4, h5, h6 {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 700 !important;
  color: #2c3e50 !important;
}

.card-title, .property-title {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 600 !important;
  color: #2c3e50 !important;
}

/* Enhanced Property Cards */
.item-card2 {
  background: white;
  border-radius: 0 !important;
  box-shadow: none !important;
  transition: all 0.3s ease !important;
  overflow: hidden;
  border: none !important;
  margin-bottom: 30px;
}

.item-card2:hover {
  transform: none;
  box-shadow: none !important;
}

.item-card2-img {
  position: relative;
  height: 220px;
  overflow: hidden;
  border-radius: 0;
}

.item-card2-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.3s ease;
}

.item-card2:hover .item-card2-img img {
  transform: scale(1.05);
}

.card-body {
  padding: 20px !important;
}

.card-title {
  font-size: 1.1rem !important;
  margin-bottom: 8px !important;
  line-height: 1.4 !important;
}

.property-price {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 700 !important;
  color: #24894a !important;
  font-size: 1.2rem !important;
  margin-bottom: 10px !important;
}

.property-location {
  color: #6c757d !important;
  font-size: 0.9rem !important;
  margin-bottom: 15px !important;
  display: flex;
  align-items: center;
}

.property-location i {
  margin-right: 5px;
  color: #24894a;
}

.property-features {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 15px;
  border-top: 1px solid #f1f1f1;
  margin-top: 15px;
}

.property-features span {
  font-size: 0.85rem;
  color: #6c757d;
  display: flex;
  align-items: center;
}

.property-features span i {
  margin-right: 4px;
  color: #24894a;
}

/* Property badges */
.property-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #24894a;
  color: white;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
  z-index: 2;
}

.property-badge.featured {
  background: linear-gradient(45deg, #ff6b6b, #ee5a24);
}

.property-badge.new {
  background: linear-gradient(45deg, #4834d4, #686de0);
}
</style>