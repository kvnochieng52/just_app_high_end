<template>
  <div class="card overflow-hidden property-card">
    <div class="card-body p-0">
      <div class="d-flex flex-wrap">
        <!-- Image Section (Left) -->
        <div class="property-image-section">
          <Link :href="`/${property.property_type_slug}/${property.slug}`">
            <img
              :src="`/${property.thumbnail}`"
              :alt="`${property.property_title} image`"
              class="property-image"
            />
            <div class="property-tag">
              <span class="lease-tag property-type-label">
                For {{ property.lease_type_name }}
              </span>
            </div>
          </Link>
        </div>

        <!-- Details Section (Right) -->
        <div class="property-details-section">
          <div class="property-header">
            <Link
              :href="`/${property.property_type_slug}/${property.slug}`"
              class="text-dark"
            >
              <h4 class="property-title">{{ property.property_title }}</h4>
            </Link>
            <h5 class="property-price">
              {{ property.currency_name }}
              {{ formatAmount(property.amount) }}
            </h5>
          </div>

          <div class="property-features" v-if="property.type_id != 7">
            <div class="feature-item">
              <i class="fa fa-diamond feature-icon"></i>
              <span>{{ property.condition_name }}</span>
            </div>

            <div class="feature-item">
              <i class="fa fa-bed feature-icon"></i>
              <span
                >{{ property.bedrooms }} Bedroom{{
                  property.bedrooms !== 1 ? "s" : ""
                }}</span
              >
            </div>

            <div class="feature-item">
              <i class="fa fa-car feature-icon"></i>
              <span
                >{{ property.parking_spaces }} Parking{{
                  property.parking_spaces !== 1 ? "s" : ""
                }}</span
              >
            </div>
          </div>

          <div class="property-location">
            <i class="fa fa-map-marker location-icon"></i>
            <span>{{ property.google_address }}, {{ property.town_name }}</span>
          </div>
        </div>
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
.property-card {
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;
}

.property-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.property-image-section {
  width: 40%;
  position: relative;
  overflow: hidden;
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
}

.property-details-section {
  width: 60%;
  padding: 20px;
}

.property-image {
  width: 100%;
  height: 100%;
  min-height: 250px;
  object-fit: cover;
  display: block;
}

.property-tag {
  position: absolute;
  top: 15px;
  left: 15px;
}

.lease-tag {
  color: white;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Property type label will inherit gradient from global CSS */
.lease-tag.property-type-label {
  background: linear-gradient(135deg, #28a745 0%, #cbbe07 100%) !important;
  border: none !important;
  transition: all 0.3s ease !important;
}

.lease-tag.property-type-label:hover {
  background: linear-gradient(135deg, #20c997 0%, #ffc107 100%) !important;
  transform: scale(1.05) !important;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4) !important;
}

.property-header {
  margin-bottom: 15px;
}

.property-title {
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 8px;
  color: #333;
  transition: color 0.2s ease;
}

.property-title:hover {
  color: #6c5ce7;
}

.property-price {
  font-size: 1.1rem; /* Reduced from 1.5rem */
  font-weight: 700;
  color: #6c5ce7;
  margin-bottom: 0;
}

.property-features {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin: 15px 0;
  padding: 15px 0;
  border-top: 1px solid #f0f0f0;
  border-bottom: 1px solid #f0f0f0;
}

.feature-item {
  display: flex;
  align-items: center;
  font-size: 14px;
  color: #555;
}

.feature-icon {
  margin-right: 8px;
  color: #6c5ce7;
  font-size: 16px;
}

.property-location {
  display: flex;
  align-items: center;
  margin-top: 10px;
  font-size: 14px;
  color: #666;
}

.location-icon {
  margin-right: 8px;
  color: #6c5ce7;
  font-size: 18px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .property-image-section,
  .property-details-section {
    width: 100%;
  }

  .property-image-section {
    border-top-right-radius: 8px;
    border-bottom-left-radius: 0;
  }

  .property-price {
    font-size: 1.1rem; /* Slightly smaller on mobile */
  }
}
</style>