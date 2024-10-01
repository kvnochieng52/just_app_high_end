<template>
  <Head
    title="Just Appartments- Classifieds, Dealer, Rentel, Builder and Agent Properties Listing"
  />

  <!-- <HomeSearch /> -->
  <div id="main">
    <!-- <section
      class="banner-1 section-first bg-background-6"
      :data-vidbg-bg="'mp4: https://justapartments.net/video/video_slide3.mp4, poster:https://justapartments.net/video/video-img.jpg'"
      :data-vidbg-options="'loop: true, muted: true, overlay: false'"
      style="background-color: rgb(31, 31, 31)"
    >
      <div class="header-text text mb-0">
        <div class="container">
          <div class="text-center text-white">
            <h1 class="">Find Your Dream Home</h1>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 d-block mx-auto">
              <div class="item-search-tabs">
                <form
                  id="register_form"
                  class="card-body"
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
                          ><strong>Buy</strong></a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          data-bs-toggle="tab"
                          v-on:click.prevent.stop="typeSelect(1)"
                          ><strong>Rent</strong></a
                        >
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
                            <template #list-item-text="slot"
                              ><span
                                v-html="
                                  slot.boldMatchText(
                                    slot.itemProjection(slot.item)
                                  )
                                "
                              ></span
                            ></template>
                          </SimpleTypeahead>
                          <span
                            ><i class="fa fa-map-marker location-gps me-1"></i
                          ></span>
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
          </div>
        </div>
      </div>
      
    </section> -->

    <section class="banner-1 section-first bg-background-6">
      <div class="header-text text mb-0">
        <div class="container">
          <!-- <div class="text-white pt-10">
            
           
          </div> -->

          <img
            src="/images/brand/letters.png"
            style="width: 500px; margin-top: 80px"
          />

          <div class="row">
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
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="sptb" style="padding-top: 30px">
    <div class="container">
      <h2 style="text-align: center; padding-top: 50px; font-size: 60px">
        Explore Our Wide Range of Luxury Properties
      </h2>

      <div style="display: flex; justify-content: center; align-items: center">
        <a
          href="#"
          class="btn btn-primary"
          style="background: purple; border-radius: 40px; font-size: 14px"
        >
          EXPLORE RESIDENCE
        </a>
      </div>
    </div>

    <div class="container pt-5">
      <SkeletonLoader v-if="!processing" />

      <div class="row">
        <div
          class="col-xl-4 col-lg-4 col-md-6 col-sm-12"
          v-for="(property, propKey) in listData"
          :key="propKey"
        >
          <div class="card overflow-hidden">
            <div class="item-card2-img">
              <Link
                :href="'/' + property.property_type_slug + '/' + property.slug"
              ></Link>
              <img
                :src="'/' + property.thumbnail"
                :alt="property.property_title + ' image'"
                class="cover-image"
              />
              <div class="tag-text">
                <span
                  style="background-color: purple !important"
                  :class="
                    'bg-' + property.lease_type_color_code + ' tag-option'
                  "
                  ><strong>For {{ property.lease_type_name }}</strong>
                </span>
              </div>
            </div>
            <div class="item-card2-icons">
              <Link
                :href="'/' + property.property_type_slug + '/' + property.slug"
                class="item-card2-icons-r bg-primary"
                ><i class="fa fa fa-heart-o"></i
              ></Link>
            </div>
            <div class="card-body">
              <div class="item-card2">
                <div class="item-card2-text">
                  <Link
                    :href="
                      '/' + property.property_type_slug + '/' + property.slug
                    "
                    class="text-dark"
                  >
                    <h4 class="">
                      {{ property.property_title }}
                    </h4>
                  </Link>
                  <!-- <p class="mb-2">
                    <i class="fa fa-map-marker text-danger me-1"></i
                    >{{ property.address }}, {{ property.sub_region_name }},{{
                      property.town_name
                    }}
                  </p> -->
                  <h5 class="font-weight-bold mb-3">
                    KSH {{ property.amount }}
                    <span class="fs-12 font-weight-normal"></span>
                  </h5>
                </div>

                <Link
                  :href="
                    '/' + property.property_type_slug + '/' + property.slug
                  "
                  class="icons"
                  ><i class="fa fa-diamond text-muted me-1"></i>
                  {{ property.condition_name }}</Link
                >
                &nbsp;

                <Link
                  :href="
                    '/' + property.property_type_slug + '/' + property.slug
                  "
                  class="icons"
                  ><i class="fa fa-bed text-muted me-1"></i>
                  {{ property.bedrooms }} Bedroom</Link
                >
                &nbsp;

                <Link
                  :href="
                    '/' + property.property_type_slug + '/' + property.slug
                  "
                  class="icons"
                  ><i class="fa fa-car text-muted me-1"></i>
                  {{ property.parking_spaces }} Parking</Link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="sptb bg-white">
    <div class="container">
      <div class="section-title center-block text-center">
        <h2>What Makes Us The Preferred Choice ?</h2>
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
                <div class="bg-white icon-bg icon-service text-purple about">
                  <i class="fe fe-pocket text-primary"></i>
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
                <div class="bg-white icon-bg icon-service text-purple about">
                  <i
                    class="fe fe-thumbs-up text-primary"
                    style="color: #800080 !important"
                  ></i>
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
                <div class="bg-white icon-bg icon-service text-primary about">
                  <i
                    class="fe fe-file-text text-primary"
                    style="color: #800080 !important"
                  ></i>
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
                <div class="bg-white icon-bg icon-service text-primary about">
                  <i class="fe fe-users text-primary"></i>
                </div>
                <div class="servic-data mt-3">
                  <h4 class="font-weight-semibold mb-2">Expert Guidance</h4>
                  <p class="text-muted mb-0">
                    Nam libero tempore, cum soluta nobis est eligendi cumque
                    facere possimus
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
                href="javascript:void(0);"
                class="btn btn-success btn-lg mb-sm-0"
                ><i class="fa fa-android fa-1x me-2"></i> Google Play</a
              >
              <a
                href="javascript:void(0);"
                class="btn btn-primary btn-lg mb-sm-0"
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
import { ref, onMounted } from "vue";
import SkeletonLoader from "../../Shared/SkeletonLoader.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { Link } from "@inertiajs/inertia-vue3";
import SimpleTypeahead from "vue3-simple-typeahead";
import "vue3-simple-typeahead/dist/vue3-simple-typeahead.css";
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
  locations: Array,
});

let processing = ref(false);

let selectedType = ref(2);

let locations2 = ref([]);

let selectedRegion = ref("");

let listData = ref([]);
let fetchListingData = () => {
  axios.get("/home/fetch_latest_listings").then((res) => {
    listData.value = res.data;
    processing.value = true;
  });
};

onMounted(() => {
  fetchListingData();
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

let typeSelect = (type) => {
  selectedType.value = type;
};

let form = useForm({
  search: 1,
  region: selectedRegion,
  leaseTypeHome: selectedType,
});

let submitForm = () => {
  form.get("/search/", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};
</script>
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
  background-color: purple;
  /* background-image: linear-gradient(
    to bottom,
    #6a11cb 0%,
    #800080 60%,
    #800080 10%
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
</style>