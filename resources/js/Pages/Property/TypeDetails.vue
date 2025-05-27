<template>
  <Head :title="propertyTypeDetails.property_type_name" />
  <section class="sptb">
    <div class="container">
      <div v-if="!processing">
        <SkeletonLoader />
        <br />
        <SkeletonLoader />
      </div>

      <div class="row">
        <div
          class="col-xl-3 col-lg-4 col-md-6 col-sm-12"
          v-for="(property, propKey) in listData.data"
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
                  :class="
                    'bg-' + property.lease_type_color_code + ' tag-option'
                  "
                  >For {{ property.lease_type_name }}
                </span>
              </div>
            </div>
            <div class="item-card2-icons">
              <!-- <Link
                :href="'/' + property.property_type_slug + '/' + property.slug"
                class="item-card2-icons-l bg-primary"
              >
                <i class="fa fa-home"></i
              ></Link> -->
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
                  <p class="mb-2">
                    <i class="fa fa-map-marker text-danger me-1"></i
                    >{{ property.address }}, {{ property.sub_region_name }},{{
                      property.town_name
                    }}
                  </p>
                  <h5 class="font-weight-bold mb-3">
                    <!-- {{ $page.props.currency }} -->

                    {{ property.currency_name }}
                    {{ property.amount.toLocaleString() }}
                    <span class="fs-12 font-weight-normal"></span>
                  </h5>
                </div>
                <ul class="item-card2-list">
                  <li>
                    <Link
                      :href="
                        '/' + property.property_type_slug + '/' + property.slug
                      "
                      class="icons"
                      ><i class="fa fa-diamond text-muted me-1"></i>
                      {{ property.condition_name }}</Link
                    >
                  </li>
                  <li>
                    <Link
                      :href="
                        '/' + property.property_type_slug + '/' + property.slug
                      "
                      class="icons"
                      ><i class="fa fa-bed text-muted me-1"></i>
                      {{ property.bedrooms }} Bedroom</Link
                    >
                  </li>

                  <li>
                    <Link
                      :href="
                        '/' + property.property_type_slug + '/' + property.slug
                      "
                      class="icons"
                      ><i class="fa fa-car text-muted me-1"></i>
                      {{ property.parking_spaces }} Parking</Link
                    >
                  </li>
                  <li>
                    <Link
                      :href="
                        '/' + property.property_type_slug + '/' + property.slug
                      "
                      ><i class="fa fa-arrows-alt text-muted me-1"></i
                      >Views</Link
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import SkeletonLoader from "../../Shared/SkeletonLoader.vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps({
  propertyTypeSlug: String,
  propertyTypeDetails: Object,
});

let processing = ref(false);

let listData = ref([]);
let fetchListingData = () => {
  axios
    .get("/home/fetch_properties_by_type/" + props.propertyTypeSlug)
    .then((res) => {
      listData.value = res.data;

      processing.value = true;
    });
};

onMounted(() => {
  fetchListingData();
});
</script>