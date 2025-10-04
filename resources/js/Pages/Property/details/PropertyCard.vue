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
            <h6 style="color: #24894a !important">
              <i
                class="fa fa-map-marker me-1"
                style="color: #24894a !important; font-size: 18px"
              ></i>
              {{ property.google_address }}, {{ property.town_name }}
            </h6>
          </Link>
          <Link :href="`/${property.property_type_slug}/${property.slug}`">
            <h5
              class="font-weight-bold mb-3 pt-2"
              style="color: #24894a !important"
            >
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
/* Enhanced Property Card Styling */
.card {
  border-radius: 18px !important;
  border: none !important;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08) !important;
  transition: all 0.4s ease !important;
  overflow: hidden !important;
  background: #ffffff !important;
  margin-bottom: 25px !important;
}

.card:hover {
  transform: translateY(-8px) !important;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

.item-card2-img {
  position: relative;
  height: 220px;
  overflow: hidden;
  border-radius: 18px 18px 0 0 !important;
}

.item-card2-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.4s ease !important;
}

.card:hover .item-card2-img img {
  transform: scale(1.05) !important;
}

.card-body {
  padding: 20px !important;
  background: #ffffff !important;
  border-radius: 0 0 18px 18px !important;
}

.tag-text {
  position: absolute;
  top: 15px;
  left: 15px;
  z-index: 2;
}

.tag-option {
  border-radius: 20px !important;
  padding: 6px 12px !important;
  font-size: 12px !important;
  font-weight: 600 !important;
  color: white !important;
  box-shadow: 0 4px 12px rgba(36, 137, 74, 0.3) !important;
}

/* Enhanced text styling */
.item-card2-text h4 {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 600 !important;
  font-size: 1.1rem !important;
  color: #2c3e50 !important;
  margin-bottom: 8px !important;
  line-height: 1.4 !important;
  transition: color 0.3s ease !important;
}

.item-card2-text h4:hover {
  color: #24894a !important;
}

.item-card2-text h6 {
  font-size: 0.9rem !important;
  margin-bottom: 12px !important;
  display: flex;
  align-items: center;
}

.item-card2-text h5 {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 700 !important;
  font-size: 1.3rem !important;
  margin-bottom: 15px !important;
}

/* Property features styling */
.icons {
  color: #6c757d !important;
  font-size: 0.85rem !important;
  text-decoration: none !important;
  display: inline-flex !important;
  align-items: center !important;
  margin-right: 15px !important;
  margin-bottom: 5px !important;
  transition: color 0.3s ease !important;
}

.icons:hover {
  color: #24894a !important;
}

.icons i {
  margin-right: 5px !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card {
    border-radius: 15px !important;
    margin-bottom: 20px !important;
  }

  .item-card2-img {
    height: 200px;
    border-radius: 15px 15px 0 0 !important;
  }

  .card-body {
    padding: 15px !important;
    border-radius: 0 0 15px 15px !important;
  }

  .item-card2-text h4 {
    font-size: 1rem !important;
  }

  .item-card2-text h5 {
    font-size: 1.2rem !important;
  }
}
</style>
