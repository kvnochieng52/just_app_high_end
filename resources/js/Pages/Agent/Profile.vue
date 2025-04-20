<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div
              class="col-md-3 d-flex justify-content-center align-items-center"
            >
              <img
                :src="
                  agentDetails.avatar
                    ? agentDetails.avatar
                    : '/images/no_user.png'
                "
                class="img-fluid rounded-circle border border-secondary"
                style="width: 150px; height: 150px; padding: 5px"
                alt="user"
              />
            </div>
            <div class="col-md-9">
              <div
                class="d-flex justify-content-between align-items-center position-relative"
              >
                <h3>{{ agentDetails.name }}</h3>
                <button @click="toggleShareDropdown" class="btn btn-info">
                  <i class="fa fa-share"></i> Share Profile
                </button>

                <div v-if="showShareDropdown" class="share-dropdown">
                  <h4>Share on:</h4>
                  <ul class="share-options">
                    <li>
                      <a
                        :href="whatsappUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="share-icon whatsapp"
                      >
                        <i class="fa fa-whatsapp"></i>
                      </a>
                    </li>
                    <li>
                      <a
                        :href="facebookUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="share-icon facebook"
                      >
                        <i class="fa fa-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a
                        :href="twitterUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="share-icon twitter"
                      >
                        <i class="fa fa-twitter"></i>
                      </a>
                    </li>
                  </ul>
                  <button @click="toggleShareDropdown" class="close-button">
                    Close
                  </button>
                </div>
              </div>

              <p>Real Estate Agent</p>
              <div class="mb-3">
                <a
                  :href="agentDetails.facebook"
                  target="_blank"
                  class="text-secondary me-3"
                >
                  <i class="fa fa-facebook"></i>
                </a>
                <a
                  :href="agentDetails.twitter"
                  target="_blank"
                  class="text-secondary me-3"
                >
                  <i class="fa fa-twitter"></i>
                </a>
                <a
                  :href="agentDetails.linkedin"
                  target="_blank"
                  class="text-secondary me-3"
                >
                  <i class="fa fa-linkedin"></i>
                </a>
                <a
                  :href="agentDetails.tiktok"
                  target="_blank"
                  class="text-secondary me-3"
                >
                  <i class="fa fa-tiktok"></i>
                </a>
              </div>
              <div class="mb-3">
                <button
                  @click="callAgent(agentDetails.telephone)"
                  class="btn btn-primary me-2 green_b"
                >
                  <i class="fa fa-phone"></i> Call Agent
                </button>
                <button
                  @click="emailAgent(agentDetails.email)"
                  class="btn btn-secondary green_b"
                >
                  <i class="fa fa-envelope"></i> Email Agent
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Active Properties</h4>

              <div class="row mt-5">
                <div
                  class="col-xl-12 col-lg-12 col-md-12 col-sm-12"
                  v-for="(property, propKey) in properties.data"
                  :key="propKey"
                >
                  <div class="card overflow-hidden mb-4">
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <a
                          :href="`/${property.property_type_slug}/${property.slug}`"
                        >
                          <img
                            :src="`/${property.thumbnail}`"
                            :alt="`${property.property_title} image`"
                            class="img-fluid w-100"
                          />
                        </a>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <div class="item-card2">
                            <div class="item-card2-text">
                              <Link
                                :href="`/${property.property_type_slug}/${property.slug}`"
                                class="text-dark"
                              >
                                <h4>{{ property.property_title }}</h4>
                              </Link>
                              <p class="mb-2">
                                <i
                                  class="fa fa-map-marker text-danger me-1"
                                ></i>
                                {{ property.address }},
                                {{ property.sub_region_name }},
                                {{ property.town_name }}
                              </p>
                              <h5 class="font-weight-bold mb-3">
                                {{ $page.props.currency }} {{ property.amount }}
                                <span class="fs-12 font-weight-normal"></span>
                              </h5>
                            </div>
                            <ul class="item-card2-list">
                              <li>
                                <Link
                                  :href="`/${property.property_type_slug}/${property.slug}`"
                                  class="icons"
                                >
                                  <i class="fa fa-diamond text-muted me-1"></i>
                                  {{ property.condition_name }}
                                </Link>
                              </li>
                              <li>
                                <Link
                                  :href="`/${property.property_type_slug}/${property.slug}`"
                                  class="icons"
                                >
                                  <i class="fa fa-bed text-muted me-1"></i>
                                  {{ property.bedrooms }} Bedroom
                                </Link>
                              </li>
                              <li>
                                <Link
                                  :href="`/${property.property_type_slug}/${property.slug}`"
                                  class="icons"
                                >
                                  <i class="fa fa-car text-muted me-1"></i>
                                  {{ property.parking_spaces }} Parking
                                </Link>
                              </li>
                              <li>
                                <Link
                                  :href="`/${property.property_type_slug}/${property.slug}`"
                                >
                                  <i
                                    class="fa fa-arrows-alt text-muted me-1"
                                  ></i
                                  >Views
                                </Link>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="item-card2-icons">
                          <Link
                            :href="`/${property.property_type_slug}/${property.slug}`"
                            class="item-card2-icons-r bg-primary"
                          >
                            <i class="fa fa fa-heart-o"></i>
                          </Link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3"></div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <Paginator :links="properties.links" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Paginator from "../../Shared/Paginator.vue";
import { ref, computed } from "vue"; // Import computed

const props = defineProps({
  agentDetails: Object,
  properties: Array,
});

const showShareDropdown = ref(false);

const whatsappUrl = computed(() => {
  const message = `Check out this profile for: ${props.agentDetails.name}\nEmail: ${props.agentDetails.email}\nPhone: ${props.agentDetails.telephone}\n`;
  const url = window.location.href; // Current page URL
  return `https://api.whatsapp.com/send?text=${encodeURIComponent(
    message + " " + url
  )}`;
});

const facebookUrl = computed(() => {
  const url = window.location.href;
  return `https://www.facebook.com/sharer/sharer.php?u=${url}`;
});

const twitterUrl = computed(() => {
  const url = window.location.href;
  const message = `Check out this profile: ${props.agentDetails.name}\nEmail: ${props.agentDetails.email}\nPhone: ${props.agentDetails.telephone}\n`;
  return `https://twitter.com/intent/tweet?url=${url}&text=${encodeURIComponent(
    message
  )}`;
});

function toggleShareDropdown() {
  showShareDropdown.value = !showShareDropdown.value;
}

function callAgent(phoneNumber) {
  window.location.href = `tel:${phoneNumber}`;
}

function emailAgent(emailAddress) {
  window.location.href = `mailto:${emailAddress}`;
}
</script>

<style scoped>
.fa {
  margin-right: 5px;
}

.position-relative {
  position: relative;
}

.share-dropdown {
  position: absolute;
  top: 100%; /* Position below the share button */
  right: 0; /* Align with the right of the button */
  background: #f9f9f9; /* Background color */
  border: 1px solid #ccc; /* Border color */
  padding: 10px; /* Padding inside the dropdown */
  z-index: 1000; /* Ensure it appears above other elements */
}

.share-options {
  list-style: none;
  padding: 0;
  margin: 0;
}

.share-options li {
  display: inline-block;
  margin-right: 10px;
}

.share-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 30px;
  height: 30px;
  background-color: #eee;
  border-radius: 50%;
  color: #333;
  text-decoration: none;
}

.whatsapp {
  background-color: #25d366;
  color: white;
}

.facebook {
  background-color: #3b5998;
  color: white;
}

.twitter {
  background-color: #1da1f2;
  color: white;
}

.close-button {
  display: block;
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 3px;
}
</style>
