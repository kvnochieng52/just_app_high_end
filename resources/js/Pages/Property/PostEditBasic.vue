<template>
  <Head title="Post Property" />

  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="card">
            <div class="card-body" style="padding: 8px">
              <div class="wrapper wrapper2">
                <form
                  id="register_form"
                  class="card-body"
                  @submit.prevent="submitForm"
                >
                  <h3 class="pb-1">Edit Property</h3>

                  <span class="text-dark text_grayish">Step 1 of 4</span>
                  <div class="progress">
                    <div
                      class="progress-bar bg-info progress-bar-striped gold"
                      role="progressbar"
                      style="width: 25%"
                      aria-valuenow="25"
                      aria-valuemin="0"
                      aria-valuemax="25"
                    >
                      <strong>25%</strong>
                    </div>
                  </div>
                  <br />
                  <input type="hidden" name="_token" :value="csrf" />

                  <!-- Property Title -->
                  <div class="form-group">
                    <label for="propertyTitle" class="form-label"
                      >Enter The Property Title</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="propertyTitle"
                      name="propertyTitle"
                      v-model="form.propertyTitle"
                    />
                    <div
                      class="text-danger small"
                      v-if="$page.props.errors.propertyTitle"
                      v-text="$page.props.errors.propertyTitle"
                    ></div>
                  </div>

                  <!-- Location Input -->
                  <p><strong>Enter the Property Location</strong></p>
                  <input
                    id="autocomplete"
                    class="form-control"
                    type="text"
                    placeholder="Enter a location (building, street, town, etc.)"
                    v-model="form.propertyLocation"
                  />

                  <div
                    class="text-danger small"
                    v-if="$page.props.errors.propertyLocation"
                    v-text="$page.props.errors.propertyLocation"
                  ></div>
                  <div id="map" style="height: 280px; width: 100%"></div>
                  <br />

                  <!-- Image Upload Section -->
                  <p><strong>Upload Images (Max: 20 Images)</strong></p>

                  <div
                    class="text-danger small"
                    v-if="$page.props.errors.images"
                    v-text="$page.props.errors.images"
                  ></div>

                  <!-- Display existing images -->
                  <div class="uploaded-images mb-3">
                    <div
                      v-for="(image, index) in existingImages"
                      :key="image.id"
                      class="image-container"
                    >
                      <img
                        :src="'/' + image.image"
                        class="uploaded-image"
                        :alt="'Property image ' + (index + 1)"
                      />
                      <button
                        class="remove-button"
                        @click.prevent="deleteExistingImage(image.id, index)"
                      >
                        &times;
                      </button>
                    </div>
                  </div>

                  <!-- Dropzone for new images -->
                  <div
                    id="dropzone"
                    class="dropzone"
                    ref="dropzone"
                    style="
                      border: 2px dashed #bbb;
                      padding: 20px;
                      text-align: center;
                      cursor: pointer;
                    "
                  >
                    <p>Drag & Drop images here or click to select files</p>
                  </div>

                  <!-- Submit Button -->
                  <div class="submit">
                    <button
                      type="submit"
                      class="btn btn-primary pull-right mb-5"
                      :disabled="processing"
                    >
                      <span v-if="processing">Loading...Please wait.</span>
                      <strong
                        >Continue <i class="fa fa-arrow-right"></i
                      ></strong>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Loader } from "@googlemaps/js-api-loader";
import Dropzone from "dropzone";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  props: {
    towns: Object,
    property: Object,
    defaultSubRegion: Object,
    propertyImages: Array,
  },
  data() {
    return {
      map: null,
      autocomplete: null,
      marker: null,
      address: "",
      latitude: null,
      longitude: null,
      town: "",
      subRegion: "",
      uploadedImages: [], // For newly uploaded images
      existingImages: this.propertyImages || [], // For existing images from server
      deletedImages: [], // Track deleted image IDs
      processing: false,
      form: useForm({
        town: this.property.town_id,
        subRegion: this.property.region_id,
        propertyTitle: this.property.property_title,
        images: [],
        step: "1",
        uploadedImages: [],
        propertyLocation: this.property.google_address,
        address: this.property.google_address,
        latitude: this.property.lat,
        longitude: this.property.log,
        subLocation: this.property.region_id,
        country: this.property.country,
        countryCode: this.property.country_code,
        deletedImages: [], // Will be populated when images are deleted
        propertyID: this.property.id,
      }),
    };
  },
  mounted() {
    this.loadGoogleMaps();
    this.initializeDropzone();
  },
  methods: {
    loadGoogleMaps() {
      const loader = new Loader({
        apiKey: "AIzaSyBP_0fcfVMUL_4vQmkOa1dKjJJslcVUJ44",
        version: "weekly",
        libraries: ["places"],
      });

      loader.load().then(() => {
        this.initAutocomplete();
        this.initMap();
      });
    },
    initMap() {
      this.map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -1.286389, lng: 36.817223 },
        zoom: 10,
      });
    },
    initAutocomplete() {
      const input = document.getElementById("autocomplete");
      this.autocomplete = new google.maps.places.Autocomplete(input);
      this.autocomplete.addListener("place_changed", this.onPlaceChanged);
    },
    onPlaceChanged() {
      const place = this.autocomplete.getPlace();
      if (!place.geometry) return;

      this.address = place.formatted_address || this.address;
      this.form.address = this.address;

      if (place.geometry.location) {
        this.latitude = place.geometry.location.lat();
        this.longitude = place.geometry.location.lng();
        this.form.latitude = this.latitude;
        this.form.longitude = this.longitude;

        this.map.setCenter(place.geometry.location);
        this.map.setZoom(15);
        this.placeMarker(place.geometry.location);
      }

      this.extractLocationDetails(place);
    },
    placeMarker(location) {
      if (this.marker) {
        this.marker.setMap(null);
      }
      this.marker = new google.maps.Marker({
        position: location,
        map: this.map,
        draggable: true,
      });
      this.marker.addListener("dragend", this.onMarkerDragEnd);
    },
    onMarkerDragEnd() {
      const position = this.marker.getPosition();
      this.updateAddress(position);
    },
    updateAddress(location) {
      const geocoder = new google.maps.Geocoder();
      geocoder.geocode({ location }, (results, status) => {
        if (status === "OK" && results[0]) {
          this.address = results[0].formatted_address;
          this.form.address = this.address;
          document.getElementById("autocomplete").value = this.address;
        }
      });
    },
    extractLocationDetails(place) {
      this.town = "";
      this.subLocation = "";
      this.address = "";
      this.country = "";
      this.countryCode = "";

      if (place.address_components) {
        place.address_components.forEach((component) => {
          const types = component.types;

          if (types.includes("locality")) {
            this.town = component.long_name;
          }

          if (types.includes("sublocality_level_1")) {
            this.subLocation = component.long_name;
          }

          if (types.includes("country")) {
            this.country = component.long_name;
            this.countryCode = component.short_name;
          }
        });
      }

      if (this.subLocation && this.town && this.country) {
        this.address = `${place.name || ""} ${this.subLocation}, ${
          this.town
        }, ${this.country}`;
      } else {
        this.address = place.formatted_address || "";
      }

      this.form.address = this.address;
      this.form.town = this.town;
      this.form.subRegion = this.subLocation;
      this.form.country = this.country;
      this.form.countryCode = this.countryCode;
    },
    initializeDropzone() {
      const dropzone = new Dropzone(this.$refs.dropzone, {
        url: "/property/upload-drop-images",
        paramName: "file",
        maxFilesize: 20,
        acceptedFiles: "image/*",
        autoProcessQueue: true,
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
        },
        init: function () {
          this.on("success", (file, response) => {
            if (response && response.imagePath) {
              this.vueInstance.uploadedImages.push(response.imagePath);
            }

            const checkmark = document.createElement("div");
            checkmark.classList.add("checkmark");
            checkmark.innerHTML = "&#10004;";

            const removeButton = document.createElement("button");
            removeButton.classList.add("remove-button");
            removeButton.innerHTML = "&times;";

            removeButton.addEventListener("click", () => {
              this.removeFile(file);
            });

            file.previewElement.appendChild(removeButton);
            file.previewElement.appendChild(checkmark);
          });

          this.on("removedfile", (file) => {
            if (file.xhr && file.xhr.response) {
              const response = JSON.parse(file.xhr.response);
              if (response.imagePath) {
                this.vueInstance.removeUploadedImage(response.imagePath);
              }
            }
          });
        },
      });

      dropzone.vueInstance = this;
    },
    // Remove newly uploaded image (before form submission)
    removeUploadedImage(imagePath) {
      this.uploadedImages = this.uploadedImages.filter(
        (img) => img !== imagePath
      );
    },
    // Delete existing image from server
    async deleteExistingImage(imageId, index) {
      if (confirm("Are you sure you want to delete this image?")) {
        try {
          const response = await axios.delete(
            `/property/quick-image-delete/${imageId}`
          );
          if (response.data.success) {
            this.existingImages.splice(index, 1);
            this.form.deletedImages.push(imageId);
          }
        } catch (error) {
          console.error("Error deleting image:", error);
          alert("Failed to delete image. Please try again.");
        }
      }
    },
    // async submitForm() {
    //   this.processing = true;
    //   try {

    //     this.form.images = this.uploadedImages;
    //     this.form.existingImages = this.existingImages.map((img) => img.image);
    //     this.form.deletedImages = this.form.deletedImages;

    //     await this.form.post(`/property/store/`);
    //     this.processing = false;
    //   } catch (error) {
    //     console.error(error);
    //     this.processing = false;
    //   }
    // },

    async submitForm() {
      this.processing = true;
      try {
        // Combine existing images (paths) and newly uploaded images
        const existingImagePaths = this.existingImages.map((img) => img.image);
        this.form.images = [...existingImagePaths, ...this.uploadedImages];
        this.form.deletedImages = this.deletedImages;

        await this.form.post(`/property/store/`);
        this.processing = false;
      } catch (error) {
        console.error(error);
        this.processing = false;
      }
    },
  },
};
</script>

<style scoped>
.dropzone {
  border: 2px dashed #bbb;
  padding: 10px;
  text-align: center;
  cursor: pointer;
}
.uploaded-images {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 15px;
}
.image-container {
  position: relative;
  display: inline-block;
  width: 80px;
  height: 80px;
}
.uploaded-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border: 1px solid #ddd;
}
.remove-button {
  position: absolute;
  top: 5px;
  right: 5px;
  background: red;
  color: white;
  border: none;
  font-size: 16px;
  cursor: pointer;
  border-radius: 100%;
  z-index: 1000;
  width: 20px;
  height: 20px;
  line-height: 20px;
  font-weight: bold;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

::v-deep .dropzone .dz-preview .dz-image {
  position: relative;
}

::v-deep .checkmark {
  position: absolute;
  bottom: 50%;
  right: 50%;
  transform: translate(50%, 50%);
  color: green;
  font-size: 18px;
  font-weight: bold;
}
</style>