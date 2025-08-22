<template>
  <div class="card overflow-hidden">
    <div class="item-card2-img">
      <Link :href="`/${property.property_type_slug}/${property.slug}`"></Link>
      <img
        :src="`/${property.thumbnail}`"
        :alt="`${property.property_title} image`"
        class="cover-image"
      />
      <div class="tag-text">
        <span
          style="background-color: #24894a !important"
          :class="`bg-${property.lease_type_color_code} tag-option`"
        >
          <strong>For {{ property.lease_type_name }}</strong>
        </span>
      </div>
    </div>

    <div class="item-card2-icons"></div>

    <div class="card-body">
      <div class="item-card2">
        <div class="item-card2-text">
          <Link
            :href="`/${property.property_type_slug}/${property.slug}`"
            class="text-dark"
          >
            <h4>{{ property.property_title }}</h4>
          </Link>
          <Link :href="`/${property.property_type_slug}/${property.slug}`">
            <h5 class="font-weight-bold mb-3">
              {{ property.currency_name }}
              {{ formatAmount(property.amount) }}
            </h5>
          </Link>
        </div>

        <template v-if="property.type_id != 7">
          <Link
            :href="`/${property.property_type_slug}/${property.slug}`"
            class="icons"
          >
            <i class="fa fa-diamond text-muted me-1"></i>
            {{ property.condition_name }}
          </Link>
          &nbsp;

          <Link
            :href="`/${property.property_type_slug}/${property.slug}`"
            class="icons"
          >
            <i class="fa fa-bed text-muted me-1"></i>
            {{ property.bedrooms }} Bedroom
          </Link>
          &nbsp;

          <Link
            :href="`/${property.property_type_slug}/${property.slug}`"
            class="icons"
          >
            <i class="fa fa-car text-muted me-1"></i>
            {{ property.parking_spaces }} Parking
          </Link>
        </template>

        <Link :href="`/${property.property_type_slug}/${property.slug}`">
          <h6 class="pt-3">
            <i
              class="fa fa-map-marker me-1"
              style="color: #24894a !important; font-size: 18px"
            ></i>
            {{ property.google_address }}, {{ property.town_name }}
          </h6>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
  property: {
    type: Object,
    required: true,
  },
});

const formatAmount = (amount) => {
  if (!amount) return "0";
  return new Intl.NumberFormat("en-US").format(amount);
};
</script>

<style scoped>
.item-card2-img {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.item-card2-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}
</style>
