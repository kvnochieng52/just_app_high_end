<template>
  <Head title="Search Properties" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 col-lg-8 col-md-12">
          <!--Add lists-->
          <div class="mb-lg-0">
            <div class="">
              <div class="item2-gl">
                <div class="mb-0">
                  <div class="">
                    <div class="p-5 bg-white item2-gl-nav border br-5">
                      <div class="row text-left">
                        <div class="col-md-8">
                          <h6 class="">Properties</h6>
                        </div>

                        <div class="col-md-4">
                          <label class="me-2 mt-1 mb-sm-1 pt-2">Sort By:</label>
                          <select name="item" class="select-sm w-75 select2">
                            <option value="1">Latest</option>
                            <option value="2">Oldest</option>
                            <option value="3">Price:Low-to-High</option>
                            <option value="5">Price:Hight-to-Low</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-5">
                  <div
                    class="col-xl-4 col-lg-4 col-md-6 col-sm-12"
                    v-for="(property, propKey) in properties.data"
                    :key="propKey"
                  >
                    <PropertyCard :property="property" />
                  </div>
                </div>

                <div class="card">
                  <div class="card-body">
                    <Paginator :links="properties.links" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-12">
          <div class="card">
            <form id="searchForm" method="get" @submit.prevent="submitForm">
              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Location</h3>
                <div class="form row no-gutters">
                  <div class="form-group col-xl-11 col-lg-11 col-md-12 mb-0">
                    <input
                      id="autocomplete"
                      class="form-control"
                      type="text"
                      placeholder="Enter a location (town, estate, etc.)"
                      v-model="form.propertyLocation"
                    />

                    <!-- <SimpleTypeahead
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
                            slot.boldMatchText(slot.itemProjection(slot.item))
                          "
                        ></span
                      ></template>
                    </SimpleTypeahead>
                    <span
                      ><i class="fa fa-map-marker location-gps me-1"></i
                    ></span> -->
                  </div>
                </div>
              </div>
              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Property Type</h3>
                <div class="" id="container">
                  <div class="filter-product-checkboxs">
                    <label
                      class="custom-control custom-checkbox mb-0"
                      v-for="(propertyType, propTypeKey) in propertyTypes"
                      :key="propTypeKey"
                    >
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        name="propertyType"
                        :value="propertyType.id"
                        v-model="form.propertyType"
                      />
                      <span class="custom-control-label">
                        <span class="text-dark">
                          {{ propertyType.property_type_name }}
                          <span class="label label-secondary float-end"></span>
                        </span>
                      </span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Price :</h3>

                <div class="row">
                  <div class="form-group col-md-6" style="padding: 0px">
                    <input
                      type="number"
                      class="form-control"
                      :placeholder="`Min (${$page.props.currency})`"
                      name="minPrice"
                      v-model="form.minPrice"
                    />
                  </div>

                  <div class="form-group col-md-6" style="padding: 0px">
                    <input
                      type="number"
                      class="form-control"
                      :placeholder="`Max (${$page.props.currency})`"
                      name="maxPrice"
                      v-model="form.maxPrice"
                    />
                  </div>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Lease Type</h3>
                <div
                  class="filter-product-checkboxs row"
                  style="padding-left: 10px"
                >
                  <label
                    class="custom-control custom-checkbox mb-2 col-md-6"
                    v-for="(leaseType, leaseTypeKey) in leaseTypes"
                    :key="leaseTypeKey"
                  >
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      name="leaseType"
                      :value="leaseType.id"
                      v-model="form.leaseType"
                    />
                    <span class="custom-control-label size_sm"
                      >For {{ leaseType.lease_type_name }}</span
                    >
                  </label>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Condition</h3>
                <div
                  class="filter-product-checkboxs row"
                  style="padding-left: 10px"
                >
                  <label
                    class="custom-control custom-checkbox mb-2 col-md-6"
                    v-for="(
                      propertyCondition, conditionKey
                    ) in propertyConditions"
                    :key="conditionKey"
                  >
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      name="condition"
                      :value="propertyCondition.id"
                      v-model="form.condition"
                    />
                    <span class="custom-control-label size_sm">{{
                      propertyCondition.condition_name
                    }}</span>
                  </label>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Bedroom</h3>
                <div class="form-group">
                  <select
                    class="form-control"
                    name="bedroom"
                    v-model="form.bedroom"
                  >
                    <option value="">None</option>

                    <option
                      v-for="(bedroomOption, bedKey) in bedroomOptions"
                      :key="bedKey"
                      :value="bedroomOption.value"
                    >
                      {{ bedroomOption.option }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Parking</h3>
                <div class="form-group">
                  <select
                    class="form-control"
                    name="parking"
                    v-model="form.parking"
                  >
                    <option value="">None</option>

                    <option
                      v-for="(parkingOption, parkKey) in parkingOptions"
                      :key="parkKey"
                      :value="parkingOption.value"
                    >
                      {{ parkingOption.option }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="card-body card-pad">
                <h3 class="card-title title-reduce-margin">Furnishing</h3>
                <div
                  class="filter-product-checkboxs row"
                  style="padding-left: 10px"
                >
                  <label
                    class="custom-control custom-checkbox mb-2 col-md-6"
                    v-for="(furnishType, furnKey) in furnishTypes"
                    :key="furnKey"
                  >
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      name="condition"
                      :value="furnishType.id"
                      v-model="form.furnishType"
                    />
                    <span class="custom-control-label size_sm">{{
                      furnishType.furnish_name
                    }}</span>
                  </label>
                </div>
              </div>

              <div class="card-body card-pad">
                <button class="btn btn-success btn-block" type="submit">
                  <strong>SEARCH</strong>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
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
import Paginator from "../../Shared/Paginator.vue";
import PropertyCard from "../Property/details/PropertyCard.vue";

const formatAmount = (amount) => {
  if (!amount) return "0";
  return new Intl.NumberFormat("en-US").format(amount);
};

let props = defineProps({
  propertyTypes: Object,
  leaseTypes: Object,
  propertyConditions: Object,
  furnishTypes: Object,
  propertyFeatures: Object,
  properties: Object,
  defaultFormValues: Array,
  minPrice: String,
  propertyType2: Array,
});

let processing = ref(false);

let selectedType = ref(2);

let locations2 = ref([]);

let selectedRegion = ref("");

let bedroomOptions = ref([
  { option: "1 Bedroom", value: 1 },
  { option: "2 Bedrooms", value: 2 },
  { option: "3 Bedrooms", value: 3 },
  { option: "4 Bedrooms", value: 4 },
  { option: "5 Bedrooms", value: 5 },
  { option: "5+ Bedrooms", value: 6 },
]);

let parkingOptions = ref([
  { option: "1 Parking Space", value: 1 },
  { option: "2 Parking Spaces", value: 2 },
  { option: "3 Parking Spaces", value: 3 },
  { option: "4 Parking Spaces", value: 4 },
  { option: "5 Parking Spaces", value: 5 },
  { option: "5+ Parking Spaces", value: 6 },
]);

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
  propertyType: props.defaultFormValues["propertyTypeDef"],
  minPrice: props.defaultFormValues["minPrice"],
  maxPrice: props.defaultFormValues["maxPrice"],
  leaseType: props.defaultFormValues["leaseTypeDef"],
  condition: props.defaultFormValues["conditionDef"],
  bedroom: props.defaultFormValues["bedroom"],
  parking: props.defaultFormValues["parking"],
  furnishType: props.defaultFormValues["furnishTypeDef"],

  propertyLocation: props.defaultFormValues["regionDef"],

  address: "",
  town: "",
  subRegion: "",
  country: "",
  countryCode: "",
  latitude: null,
  longitude: null,
  // address: "",
  // town: "",
  // subRegion: "",
  // country: "",
  // countryCode: "",
  // latitude: null,
  // longitude: null,
});

let submitForm = () => {
  console.log(props.defaultFormValues);
  form.get("/search/", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
    onSuccess: () => {
      form.defaults({
        minPrice: 3000,
        value2: null,
        value3: null,
      });

      form.reset();
    },
  });
};

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

onMounted(() => {
  loadGoogleMaps();
});
</script>

<style>
.simple-typeahead-list-item,
.simple-typeahead-list-item-text .simple-typeahead-list-item-active {
  color: black !important;
}
.title-reduce-margin {
  margin-bottom: 10px;
  font-size: 13px;
}

.card-pad {
  padding: 15px;
}

.item-card2-img {
  position: relative;
  height: 200px; /* Set a fixed height for the image container */
  overflow: hidden; /* Hide overflow to ensure images don't exceed container height */
}

.size_sm {
  font-size: 13px;
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

.btn-outline-primary:not(:disabled):not(.disabled):active,
.btn-outline-primary:not(:disabled):not(.disabled).active {
  color: #fff;
  background-color: #9307cb !important;
  border-color: #9307cb !important;
}

.multiselect__option--highlight::after {
  content: none !important;
}
</style>