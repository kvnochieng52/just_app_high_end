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

                    <span class="text_grayish">Step 3 of 3 &nbsp;</span>
                    <div class="progress">
                      <div
                        class="progress-bar bg-info progress-bar-striped gold"
                        role="progressbar"
                        style="width: 100%"
                        aria-valuenow="100"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      >
                        <strong>100%</strong>
                      </div>
                    </div>
                    <br />
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

                    <div class="row">
                      <div class="col-md-12">
                        <label for="video"
                          >Video Address Link (Youtube/Vimeo)</label
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

                    <div class="submit" style="clear: both">
                      <Link
                        :href="'/post-edit/2/' + props.property.id"
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
                          >Finish <i class="fa fa-arrow-right"></i
                        ></strong>
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
const props = defineProps({
  featureGroups: Object,
  property: Object,
  propertyFeatures: Object,
});

let form = useForm({
  video: props.property.video_link,
  selectedFeatures: props.propertyFeatures,
  step: "3",
  propertyID: props.property.id,
});

let submitForm = () => {
  form.post("/property/store", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};
</script>