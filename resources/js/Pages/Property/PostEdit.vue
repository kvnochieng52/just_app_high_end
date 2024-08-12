<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="single-page w-100 p-0">
                <div class="wrapper wrapper2">
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1">Post Property</h3>
                    <span class="text_grayish">Step 2 of 3 &nbsp;</span>
                    <div class="progress">
                      <div
                        class="progress-bar bg-info progress-bar-striped gold pull-right"
                        role="progressbar"
                        style="width: 66%"
                        aria-valuenow="66"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      >
                        <strong>66%</strong>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Property Type</label>
                          <Select2
                            id="propertType"
                            style="margin-top: 20px"
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

                        <div
                          class="form-group mb-0"
                          v-if="showPropertySubtypeField"
                        >
                          <label for="location">Select Property Sub Type</label>
                          <Select2
                            id="propertSubType"
                            style="margin-top: 10px"
                            name="propertSubType"
                            placeholder="Select Property Sub Type"
                            v-model="form.propertSubType"
                            :options="propertSubTypes"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="propertySubTypeChangeEvent($event)"
                            @select="propertySubTypeSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.propertSubType"
                            v-text="$page.props.errors.propertSubType"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">The Condition</label>
                          <Select2
                            id="propertyCondition"
                            style="margin-top: 20px"
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

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Furnished</label>
                          <Select2
                            id="furnishStatus"
                            style="margin-top: 20px"
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
                            style="margin-top: 20px"
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

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group mb-0">
                          <label for="location">Bedrooms</label>
                          <Select2
                            id="bedrooms"
                            style="margin-top: 20px"
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

                    <div class="row">
                      <div class="col-md-12">
                        <textarea
                          class="form-control"
                          name="description"
                          id="description"
                          rows="4"
                          v-model="form.description"
                        ></textarea>
                        <label for="description"
                          >Description (Describe your property in-depth)</label
                        >

                        <div
                          class="text-red text-left smaller-text"
                          v-if="$page.props.errors.description"
                          v-text="$page.props.errors.description"
                        ></div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-7">
                        <div class="form-group">
                          <input
                            type="text"
                            name="address"
                            v-model="form.address"
                            placeholder="Enter the address"
                          />
                          <label for="address">Address</label>
                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.address"
                            v-text="$page.props.errors.address"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-5">
                        <div class="form-group">
                          <input
                            type="number"
                            name="amount"
                            v-model="form.amount"
                            min="0"
                            placeholder="Specify the amount"
                          />
                          <label for="amount">Amount</label>
                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.amount"
                            v-text="$page.props.errors.amount"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input
                            type="number"
                            name="parking"
                            min="0"
                            v-model="form.parking"
                            placeholder="specify parking slots"
                          />
                          <label for="parking">Parking Spaces (optional)</label>
                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.parking"
                            v-text="$page.props.errors.parking"
                          ></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <input
                            type="number"
                            min="0"
                            name="measurement"
                            v-model="form.measurement"
                            placeholder="Specify the property measurement"
                          />
                          <label for="measurement"
                            >Square metres (sqm) (optional)</label
                          >
                          <div
                            class="text-red text-left smaller-text"
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
import { ref } from "vue";
import Select2 from "vue3-select2-component";
import { Link } from "@inertiajs/inertia-vue3";

import axios from "axios";

const props = defineProps({
  propertyTypes: Object,
  propertyConditions: Object,
  furnishStatuses: Object,
  leaseTypes: Object,
  property: Object,
});

let bedroomsArray = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];

let propertSubTypes = ref([]);
let showPropertySubtypeField = ref(false);

let form = useForm({
  propertType: props.property.type_id,
  propertSubType: "",
  propertyCondition: props.property.condition_id,
  furnishStatus: props.property.furnish_id,
  leaseType: props.property.type_id,
  bedrooms: props.property.bedrooms,
  description: props.property.property_description,
  amount: props.property.amount,
  parking: props.property.parking_spaces,
  address: props.property.address,
  measurement: props.property.measurements,
  step: "2",
  propertyID: props.property.id,
});

// hgagas
let submitForm = () => {
  console.log(props.property);
  form.post("/property/store", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};

let propertyTypeChangeEvent = (val) => {};
let propertyTypeSelectEvent = ({ id, text }) => {
  axios.get("/property/fetch-sub-properties/" + id).then((res) => {
    if (res.data.data.length > 0) {
      propertSubTypes.value = res.data.data;
      showPropertySubtypeField.value = true;
    }
    //console.log(this.subRegions);
    // listData.value = res.data;
    // processing.value = true;
  });
};

let propertyConditionChangeEvent = (val) => {};
let propertyConditionSelectEvent = ({ id, text }) => {};

let furnishStatusChangeEvent = (val) => {};
let furnishStatusSelectEvent = ({ id, text }) => {};

let leaseTypeChangeEvent = (val) => {};
let leaseTypeSelectEvent = ({ id, text }) => {};
</script>