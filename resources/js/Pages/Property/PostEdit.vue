<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="tab-content" id="myTabContent">
            <div class="card">
              <div class="card-body">
                <div class="">
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1">Post Property</h3>
                    <span class="text_grayish">Step 2 of 4 &nbsp;</span>
                    <div class="progress">
                      <div
                        class="progress-bar bg-info progress-bar-striped gold pull-right"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="50"
                      >
                        <strong>50%</strong>
                      </div>
                    </div>
                    <br />
                    <div class="row pb-3">
                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Property Type</label>
                          <Select2
                            id="propertType"
                            name="propertType"
                            placeholder="Select the Property Type"
                            v-model="form.propertType"
                            :options="propertyTypes"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="propertyTypeChangeEvent($event)"
                            @select="propertyTypeSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.propertType"
                            v-text="$page.props.errors.propertType"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6" v-if="form.propertType != 7">
                        <div class="form-group mb-0">
                          <label for="location">The Condition</label>
                          <Select2
                            id="propertyCondition"
                            name="propertyCondition"
                            placeholder="Select the Property Condition"
                            v-model="form.propertyCondition"
                            :options="propertyConditions"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="propertyConditionChangeEvent($event)"
                            @select="propertyConditionSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.propertyCondition"
                            v-text="$page.props.errors.propertyCondition"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div v-if="form.propertType == 7">
                      <div class="form-group mb-3">
                        <label for="landType">Land Type</label>
                        <select v-model="form.landType" class="form-control">
                          <option value="" disabled>Select Land Type</option>
                          <option
                            v-for="landType in landTypes"
                            :key="landType.id"
                            :value="landType.id"
                          >
                            {{ landType.value }}
                          </option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="landMeasurement"
                          >Land Measurement (Acres) (Optional)</label
                        >
                        <select
                          v-model="form.landMeasurement"
                          class="form-control"
                        >
                          <option value="" disabled>Select Measurement</option>
                          <option
                            v-for="measurement in landMeasurements"
                            :key="measurement.id"
                            :value="measurement.id"
                          >
                            {{ measurement.value }}
                          </option>
                        </select>
                      </div>

                      <div class="mb-3" v-if="form.landMeasurement == 10">
                        <label for="landMeasurementName" class="form-label"
                          >Specify Measurement</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="landMeasurementName"
                          v-model="form.landMeasurementName"
                          placeholder="Specify"
                        />
                        <div
                          class="text-danger text-left small"
                          v-if="$page.props.errors.landMeasurementName"
                          v-text="$page.props.errors.landMeasurementName"
                        ></div>
                      </div>
                    </div>

                    <div class="row pb-3">
                      <div class="col-md-6" v-if="form.propertType != 7">
                        <div class="form-group mb-0">
                          <label for="location">Furnished</label>
                          <Select2
                            id="furnishStatus"
                            name="furnishStatus"
                            placeholder="Please Furnishing Status"
                            v-model="form.furnishStatus"
                            :options="furnishStatuses"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="furnishStatusChangeEvent($event)"
                            @select="furnishStatusSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.furnishStatus"
                            v-text="$page.props.errors.furnishStatus"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Lease Type</label>
                          <Select2
                            id="leaseType"
                            name="leaseType"
                            placeholder="Select the Lease Type"
                            v-model="form.leaseType"
                            :options="leaseTypes"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="leaseTypeChangeEvent($event)"
                            @select="leaseTypeSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.leaseType"
                            v-text="$page.props.errors.leaseType"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div class="row pb-3" v-if="showOffplanAuction">
                      <div class="col-md-6">
                        <label>Property on Auction?</label><br />
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="auction"
                            value="0"
                            id="auctionNo"
                            v-model="auction"
                            :disabled="offplan === '1'"
                          />
                          <label class="form-check-label" for="auctionNo"
                            >No</label
                          >
                        </div>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="auction"
                            value="1"
                            id="auctionYes"
                            v-model="auction"
                            :disabled="offplan === '1'"
                          />
                          <label class="form-check-label" for="auctionYes"
                            >Yes</label
                          >
                        </div>
                      </div>

                      <div class="col-md-6" v-if="form.propertType != 7">
                        <label>Property is Off-Plan?</label><br />
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="offplan"
                            value="0"
                            id="offplanNo"
                            v-model="offplan"
                            :disabled="auction === '1'"
                          />
                          <label class="form-check-label" for="offplanNo"
                            >No</label
                          >
                        </div>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="offplan"
                            value="1"
                            id="offplanYes"
                            v-model="offplan"
                            :disabled="auction === '1'"
                          />
                          <label class="form-check-label" for="offplanYes"
                            >Yes</label
                          >
                        </div>
                      </div>
                    </div>

                    <div class="row pb-3">
                      <div class="col-md-6" v-if="form.propertType != 7">
                        <div class="form-group mb-0">
                          <label for="location">Bedrooms</label>
                          <Select2
                            id="bedrooms"
                            name="bedrooms"
                            placeholder="Select the Property Type"
                            v-model="form.bedrooms"
                            :options="bedroomsArray"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="propertyTypeChangeEvent($event)"
                            @select="propertyTypeSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.bedrooms"
                            v-text="$page.props.errors.bedrooms"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div class="row pb-3">
                      <div class="col-md-12">
                        <label for="description"
                          >Description (Describe your property in-depth)</label
                        >
                        <textarea
                          class="form-control"
                          name="description"
                          id="description"
                          rows="4"
                          v-model="form.description"
                        ></textarea>

                        <div
                          class="text-red text-left smaller-text"
                          v-if="$page.props.errors.description"
                          v-text="$page.props.errors.description"
                        ></div>
                      </div>
                    </div>
                    <br />
                    <div class="row pb-3">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="address" class="form-label"
                            >Address</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            name="address"
                            v-model="form.address"
                            placeholder="Enter the address"
                          />
                          <div
                            class="text-danger text-left small"
                            v-if="$page.props.errors.address"
                            v-text="$page.props.errors.address"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-">
                          <label for="amount" class="form-label">Amount</label>
                          <input
                            type="text"
                            class="form-control"
                            name="amount"
                            v-model="form.amount"
                            min="0"
                            placeholder="Specify the amount"
                          />
                          <div
                            class="text-danger text-left small"
                            v-if="$page.props.errors.amount"
                            v-text="$page.props.errors.amount"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Currency</label>
                          <Select2
                            id="currency"
                            name="currency"
                            placeholder="Select the Currency"
                            v-model="form.currency"
                            :options="currencies"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="currencyChangeEvent($event)"
                            @select="currencySelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.propertyCondition"
                            v-text="$page.props.errors.propertyCondition"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div class="row pb-3">
                      <div class="col-md-6" v-if="form.propertType != 7">
                        <div class="mb-3">
                          <label for="parking" class="form-label"
                            >Parking Spaces (optional)</label
                          >
                          <input
                            type="number"
                            class="form-control"
                            name="parking"
                            min="0"
                            v-model="form.parking"
                            placeholder="Specify parking slots"
                          />
                          <div
                            class="text-danger text-left small"
                            v-if="$page.props.errors.parking"
                            v-text="$page.props.errors.parking"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="measurement" class="form-label"
                            >Square metres (sqm) (optional)</label
                          >
                          <input
                            type="number"
                            class="form-control"
                            name="measurement"
                            v-model="form.measurement"
                            min="0"
                            placeholder="Specify the property measurement"
                          />
                          <div
                            class="text-danger text-left small"
                            v-if="$page.props.errors.measurement"
                            v-text="$page.props.errors.measurement"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div class="submit">
                      <Link
                        :href="'/post-edit/1/' + props.property.id"
                        class="text-dark pull-left mb-5"
                      >
                        <strong
                          ><i class="fa fa-arrow-left"></i>&nbsp;
                          <span>Previous</span></strong
                        >
                      </Link>

                      <button
                        type="submit"
                        class="btn btn-primary pull-right mb-5"
                      >
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
    </div>
  </section>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import Select2 from "vue3-select2-component";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";

// Props passed to the component
const props = defineProps({
  propertyTypes: Array,
  propertyConditions: Array,
  furnishStatuses: Array,
  leaseTypes: Array,
  property: Object,
  landTypes: Array,
  landMeasurements: Array,
  currencies: Array,
});

// Data arrays and state variables
let bedroomsArray = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
let propertSubTypes = ref([]);
let showPropertySubtypeField = ref(false);
let showOffplanAuction = ref(false);

// State for the auction and off-plan options
let auction = ref(props.property.auction || "0"); // Default to "No"
let offplan = ref(props.property.offplan || "0"); // Default to "No"

// Form data
let form = useForm({
  propertType: props.property.type_id,
  propertSubType: "",
  propertyCondition: props.property.condition_id,
  furnishStatus: props.property.furnish_id,
  //leaseType: props.property.type_id,
  bedrooms: props.property.bedrooms,
  description: props.property.property_description,
  amount: props.property.amount ? props.property.amount.toString() : "", // Ensure it's a string
  parking: props.property.parking_spaces,
  address: props.property.address,
  measurement: props.property.measurements,
  auction: auction.value, // Add auction to the form
  offplan: offplan.value, // Add offplan to the form
  step: "2",
  propertyID: props.property.id,
  landType: props.property.land_type_id,
  landMeasurement: props.property.land_measurement_id,
  landMeasurementName: props.property.land_measurement_name,
  currency: props.property.currency_id,
  leaseType: props.property.lease_type_id,
});

// Function to format number with thousand separators
const formatNumber = (value) => {
  if (!value) return "";
  return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

// Watch the amount field and format it
watch(
  () => form.amount,
  (newVal) => {
    if (newVal !== "") {
      let numericValue = newVal.toString().replace(/,/g, ""); // Remove existing commas
      if (!isNaN(numericValue)) {
        form.amount = formatNumber(numericValue);
      }
    }
  }
);

// Form submission function
let submitForm = () => {
  form.auction = auction.value;
  form.offplan = offplan.value;

  console.log("Form data:", form);
  form.post("/property/store", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};

// Watchers for auction and off-plan fields
watch(auction, (newVal) => {
  if (newVal === "1") {
    offplan.value = "0"; // Reset offplan to "No"
    form.offplan = "0"; // Update the form value
  }
});

watch(offplan, (newVal) => {
  if (newVal === "1") {
    auction.value = "0"; // Reset auction to "No"
    form.auction = "0"; // Update the form value
  }
});

// Watch for leaseType changes to toggle showOffplanAuction
watch(
  () => form.leaseType,
  (newVal) => {
    showOffplanAuction.value = newVal === "2";
  }
);

// Property type change events
let propertyTypeChangeEvent = (val) => {
  form.propertType = val;
};

let propertyTypeSelectEvent = ({ id, text }) => {
  axios.get(`/property/fetch-sub-properties/${id}`).then((res) => {
    if (res.data.data.length > 0) {
      propertSubTypes.value = res.data.data;
      showPropertySubtypeField.value = true;
    } else {
      showPropertySubtypeField.value = false;
    }
  });
};

// Property condition change events
let propertyConditionChangeEvent = (val) => {
  form.propertyCondition = val;
};

let currencyChangeEvent = (val) => {
  form.currency = val;
};

let currencySelectEvent = ({ id, text }) => {
  form.currency = id;
};

let propertyConditionSelectEvent = ({ id, text }) => {
  form.propertyCondition = id;
};

// Furnish status change events
let furnishStatusChangeEvent = (val) => {
  form.furnishStatus = val;
};

let furnishStatusSelectEvent = ({ id, text }) => {
  form.furnishStatus = id;
};

// Lease type change events
let leaseTypeChangeEvent = (val) => {
  form.leaseType = val;
};

let leaseTypeSelectEvent = ({ id, text }) => {
  form.leaseType = id;
};
</script>
