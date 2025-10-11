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
                  <h3 class="pb-1">Post Property</h3>

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
                      class="btn btn-success pull-right mb-5"
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
import Dropzone from "dropzone"; // Import Dropzone
import { useForm } from "@inertiajs/inertia-vue3";
import imageCompression from "browser-image-compression";

export default {
  components: {
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
      uploadedImages: [],
      processing: false, // For disabling the button during submission
      form: useForm({
        town: "",
        subRegion: "",
        propertyTitle: "",
        images: [],
        step: "new",
        uploadedImages: [],
        propertyLocation: "",
        address: "", // For storing the full address
        latitude: "", // For storing the latitude
        longitude: "", // For storing the longitude
        subLocation: "", // For storing sub-location (e.g., town or region)
        country: "",
        countryCode: "",
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
        apiKey: "AIzaSyACciAL0i2VbKZ_koXAuEkgDEmkCE71yLA", // Replace with your API key
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
        center: { lat: -1.286389, lng: 36.817223 }, // Default center (adjust as needed)
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

      // Extract full address directly from the `formatted_address`
      this.address = place.formatted_address || this.address;
      this.form.address = this.address; // Store address in the form

      // Store the latitude and longitude
      if (place.geometry.location) {
        this.latitude = place.geometry.location.lat();
        this.longitude = place.geometry.location.lng();
        this.form.latitude = this.latitude;
        this.form.longitude = this.longitude;

        this.map.setCenter(place.geometry.location);
        this.map.setZoom(15);
        this.placeMarker(place.geometry.location);
      }

      // Extract town and sub-location information
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

    // extractLocationDetails(place) {
    //   // Initialize variables for town, sub-location, and country
    //   this.town = "";
    //   this.subLocation = "";
    //   this.address = "";
    //   this.country = "";

    //   // Iterate through the address components to extract detailed address info
    //   if (place.address_components) {
    //     place.address_components.forEach((component) => {
    //       const types = component.types;

    //       // Check if the component is the town (locality) or sub-location (sublocality)
    //       if (types.includes("locality")) {
    //         this.town = component.long_name; // Store the town
    //       }

    //       if (types.includes("sublocality_level_1")) {
    //         this.subLocation = component.long_name; // Store sub-location (e.g., region or area)
    //       }

    //       // Check if the component is the country
    //       if (types.includes("country")) {
    //         this.country = component.long_name; // Store the country
    //       }
    //     });
    //   }

    //   // Build the address string with full details
    //   if (this.subLocation && this.town && this.country) {
    //     this.address = `${place.name || ""} ${this.subLocation}, ${
    //       this.town
    //     }, ${this.country}`; // Ensure place name is included
    //   } else {
    //     this.address = place.formatted_address || ""; // Fallback to the full formatted address
    //   }

    //   // Update the form's address
    //   this.form.address = this.address;
    // },

    extractLocationDetails(place) {
      // Initialize variables for town, sub-location, and country
      this.town = "";
      this.subLocation = "";
      this.address = "";
      this.country = "";
      this.countryCode = "";

      // Iterate through the address components to extract detailed address info
      if (place.address_components) {
        place.address_components.forEach((component) => {
          const types = component.types;

          // Check if the component is the town (locality) or sub-location (sublocality)
          if (types.includes("locality")) {
            this.town = component.long_name; // Store the town
          }

          if (types.includes("sublocality_level_1")) {
            this.subLocation = component.long_name; // Store sub-location (e.g., region or area)
          }

          // Check if the component is the country
          if (types.includes("country")) {
            this.country = component.long_name; // Store the country
            this.countryCode = component.short_name;
          }
        });
      }

      // Build the address string with full details
      if (this.subLocation && this.town && this.country) {
        this.address = `${place.name || ""} ${this.subLocation}, ${
          this.town
        }, ${this.country}`; // Ensure place name is included
      } else {
        this.address = place.formatted_address || ""; // Fallback to the full formatted address
      }

      // Update the form's address and country
      this.form.address = this.address;
      this.form.town = this.town;
      this.form.subRegion = this.subLocation;
      this.form.country = this.country; // Include country in the form data
      this.form.countryCode = this.countryCode;
    },
    // initializeDropzone() {
    //   const dropzone = new Dropzone(this.$refs.dropzone, {
    //     url: "/property/upload-drop-images",
    //     paramName: "file",
    //     maxFilesize: 50,
    //     acceptedFiles: "image/*",
    //     autoProcessQueue: true,
    //     headers: {
    //       "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
    //         .content, // Add CSRF token
    //     },
    //     init: function () {
    //       this.on("success", (file, response) => {
    //         console.log(response);
    //         if (response && response.imagePath) {
    //           this.vueInstance.uploadedImages.push(response.imagePath);
    //         }

    //         const checkmark = document.createElement("div");
    //         checkmark.classList.add("checkmark");
    //         checkmark.innerHTML = "&#10004;";

    //         const removeButton = document.createElement("button");
    //         removeButton.classList.add("remove-button");
    //         removeButton.innerHTML = "&times;";

    //         removeButton.addEventListener("click", () => {
    //           this.removeFile(file);
    //         });

    //         file.previewElement.appendChild(removeButton);
    //         file.previewElement.appendChild(checkmark);
    //       });

    //       this.on("removedfile", (file) => {
    //         console.log("Image removed:", file);
    //       });
    //     },
    //   });

    //   dropzone.vueInstance = this;
    // },

    initializeDropzone() {
      const dropzone = new Dropzone(this.$refs.dropzone, {
        url: "/property/upload-drop-images",
        paramName: "file",
        maxFilesize: 50,
        acceptedFiles: "image/*",
        autoProcessQueue: true,
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
        },

        // 👇 compress image before upload
        transformFile: async function (file, done) {
          try {
            const options = {
              maxSizeMB: 1,
              maxWidthOrHeight: 1920,
              useWebWorker: true,
            };

            const compressedFile = await imageCompression(file, options);
            const compressedBlob = new Blob([compressedFile], {
              type: file.type,
            });
            const newFile = new File([compressedBlob], file.name, {
              type: file.type,
              lastModified: Date.now(),
            });

            done(newFile); // 🔥 this sends the compressed version
          } catch (error) {
            console.error("Compression failed:", error);
            done(file); // fallback to original if compression fails
          }
        },

        init: function () {
          this.on("success", (file, response) => {
            console.log(response);
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
            console.log("Image removed:", file);
          });

          this.on("error", (file, errorMessage) => {
            console.warn("File rejected:", errorMessage);
            const removeButton = document.createElement("button");
            removeButton.classList.add("remove-button");
            removeButton.innerHTML = "&times;";
            removeButton.addEventListener("click", () => {
              this.removeFile(file);
            });

            if (file.previewElement) {
              file.previewElement.appendChild(removeButton);
            }
          });
        },
      });

      dropzone.vueInstance = this;
    },

    removeImage(index) {
      this.uploadedImages.splice(index, 1);
    },
    async submitForm() {
      this.processing = true;
      try {
        this.form.images = this.uploadedImages;
        await this.form.post("/property/store"); // Replace with your endpoint
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

::v-deep .dropzone .dz-preview .dz-image {
  position: relative;
}

::v-deep .remove-button {
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
  width: 20px; /* Set a fixed width */
  height: 20px;
  line-height: 20px;
  font-weight: bold;
}

::v-deep .checkmark {
  position: absolute;
  bottom: 50%; /* Center vertically */
  right: 50%; /* Center horizontally */
  transform: translate(50%, 50%);
  color: green;
  font-size: 18px;
  font-weight: bold;
}
</style>
