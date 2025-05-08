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
                  class="col-xl-4 col-lg-4 col-md-6 col-sm-12"
                  v-for="(property, propKey) in properties.data"
                  :key="propKey"
                >
                  <PropertyCard :property="property" />
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
import PropertyCard from "../Property/details/PropertyCard.vue";

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
