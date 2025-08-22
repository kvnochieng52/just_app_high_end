<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="w-100 p-0">
                <div class="wrapper bg-white">
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1 text-center">Post Property</h3>

                    <span class="text_grayish">Step 3 of 4 &nbsp;</span>
                    <div class="progress">
                      <div
                        class="progress-bar bg-info progress-bar-striped gold"
                        role="progressbar"
                        style="width: 75%"
                        aria-valuenow="75"
                        aria-valuemin="0"
                        aria-valuemax="75"
                      >
                        <strong>75%</strong>
                      </div>
                    </div>
                    <br />

                    <!-- Listing Select -->
                    <div class="row">
                      <div class="col-md-12">
                        <label for="listing">Post as:</label>
                        <div class="form-group">
                          <select
                            name="listing"
                            v-model="form.listing"
                            class="form-control"
                          >
                            <option value="" disabled>Select a listing</option>
                            <option
                              v-for="(listing, index) in listings"
                              :key="index"
                              :value="listing.id"
                              :selected="property.listing_as == listing.id"
                            >
                              {{ listing.value }}
                            </option>
                          </select>

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.listing"
                            v-text="$page.props.errors.listing"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <!-- Conditionally show company name and logo inputs -->
                    <div v-if="form.listing === 2 || form.listing === 3">
                      <div class="row">
                        <div class="col-md-12">
                          <label for="companyName">Company/Agency Name</label>
                          <div class="form-group">
                            <input
                              type="text"
                              name="companyName"
                              v-model="form.companyName"
                              placeholder="Enter company or agency name"
                              class="form-control"
                            />
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <img
                            style="width: 130px"
                            v-if="
                              companyLogoPreview ||
                              props.property.company_logo ||
                              props.userDetails.company_logo
                            "
                            :src="companyLogoPreview || getCompanyLogo()"
                            id="companyLogoPreview"
                            class="img-fluid"
                            alt="Company Logo Preview"
                          />
                        </div>
                        <div class="col-md-8">
                          <label for="companyLogo">Change Company Logo</label>
                          <div class="form-group">
                            <input
                              type="file"
                              name="companyLogo"
                              @change="handleLogoChange"
                              class="form-control"
                              accept="image/*"
                            />
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Features section (checkboxes) -->
                    <div class="filter-product-checkboxs">
                      <div class="row">
                        <div class="col-md-12">
                          <div
                            v-for="(group, groupKey) in featureGroups"
                            :key="groupKey"
                          >
                            <h4 class="mt-5">
                              {{ group.feature_group_name }}
                            </h4>

                            <div class="row" style="padding-left: 10px">
                              <div
                                v-for="(feature, featureKey) in group.features"
                                :key="featureKey"
                                class="col-md-6"
                                style="margin-bottom: 0px"
                              >
                                <label
                                  class="custom-control custom-checkbox mb-0"
                                >
                                  <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="selectedFeatures"
                                    :value="feature.id"
                                    v-model="form.selectedFeatures"
                                  />
                                  <span class="custom-control-label">
                                    <span class="text-dark">
                                      {{ feature.feature_name }}
                                    </span>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr />

                    <!-- Video Link Input -->
                    <div class="row">
                      <div class="col-md-12">
                        <label for="video"
                          >Video Address Link (Youtube only)</label
                        >
                        <div class="form-group">
                          <input
                            type="url"
                            name="video"
                            v-model="form.video"
                            placeholder="Enter the video link"
                            class="form-control"
                          />
                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.video"
                            v-text="$page.props.errors.video"
                          ></div>
                        </div>
                      </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="submit" style="clear: both">
                      <Link
                        :href="'/post-edit/2/' + props.property.id"
                        class="text-dark pull-left mb-5"
                      >
                        <strong
                          ><i class="fa fa-arrow-left"></i>&nbsp;<span
                            >Previous</span
                          ></strong
                        >
                      </Link>

                      <button
                        type="submit"
                        class="btn btn-success pull-right mb-5"
                        :disabled="submitting"
                      >
                        <strong v-if="!submitting">
                          Continue <i class="fa fa-arrow-right"></i>
                        </strong>
                        <strong v-else>Submitting, please wait...</strong>
                      </button>

                      <div style="clear: both"></div>
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
import { useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";

const props = defineProps({
  featureGroups: Object,
  property: Object,
  propertyFeatures: Object,
  listings: Object,
  userDetails: Object,
});

const companyLogoPreview = ref(null);

let form = useForm({
  video: props.property.video_link,
  selectedFeatures: props.propertyFeatures,
  step: "3",
  propertyID: props.property.id,
  companyName: props.property.company_name
    ? props.property.company_name
    : props.userDetails.company_name,
  companyLogo: null,
  listing: props.property.listing_as,
});

const submitting = ref(false); // Track submission state

// watch(
//   () => form.listing,
//   (newListing) => {
//     if (newListing === 2) {
//       form.companyName = props.userDetails.name;
//     } else {
//       form.companyName = "";
//     }
//   }
// );

// let handleLogoChange = (event) => {
//   form.companyLogo = event.target.files[0];
// };

let handleLogoChange = (event) => {
  const file = event.target.files[0];

  // Validate it's an image
  if (!file.type.match("image.*")) {
    alert("Please select an image file");
    event.target.value = ""; // Clear the input
    return;
  }

  form.companyLogo = file;

  // Create preview
  const reader = new FileReader();
  reader.onload = (e) => {
    companyLogoPreview.value = e.target.result;
  };
  reader.readAsDataURL(file);
};

let submitForm = () => {
  submitting.value = true; // Disable button and show message

  form.post("/property/store", {
    forceFormData: true,
    onFinish: () => {
      submitting.value = false; // Re-enable button after submission
    },
  });
};

const getCompanyLogo = () => {
  if (props.property.company_logo) {
    return "/" + props.property.company_logo;
  } else if (props.userDetails.company_logo) {
    return "/" + props.userDetails.company_logo;
  }
  return ""; // Fallback if no logos exist
};
</script>