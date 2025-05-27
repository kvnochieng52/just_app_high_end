<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">PENDING APPROVAL</h3>
            </div>
            <div class="card-body">
              <div class="ads-tabs">
                <div class="tabs-menus"></div>
                <div class="tab-content">
                  <div
                    class="tab-pane active table-responsive userprof-tab"
                    id="tab1"
                  >
                    <table
                      id="propertiesTable"
                      class="table table-bordered table-hover table-striped"
                    >
                      <thead>
                        <tr style="background-color: #f3f3f3">
                          <th>Title</th>
                          <th>Type</th>
                          <th>Price</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="media mt-0 mb-0">
                              <div class="card-aside-img">
                                <Link
                                  target="_blank"
                                  :href="`/${property.property_type_slug}/${property.slug}`"
                                ></Link>
                                <img
                                  :src="'/' + property.thumbnail"
                                  alt="img"
                                />
                              </div>
                              <div class="media-body">
                                <div class="card-item-desc ms-4 p-0 mt-2">
                                  <Link
                                    :href="`/${property.property_type_slug}/${property.slug}`"
                                    class="text-dark"
                                  >
                                    <h4 class="font-weight-semibold">
                                      {{ property.property_title }}
                                    </h4>
                                  </Link>
                                  <a href="javascript:void(0);">
                                    <i class="fa fa-clock-o me-1"></i>
                                    {{ dateFormat(property.created_at) }}
                                  </a>
                                  <br />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{ property.property_type_name }}</td>
                          <td class="font-weight-semibold">
                            {{ property.currency_name }}
                            {{ numberFormat(property.amount) }}
                          </td>
                          <td>
                            <Link
                              :href="'/post-edit/1/' + property.id"
                              class="badge"
                              :style="{
                                backgroundColor: property.status_color_code,
                                color: property.status_text_color_code,
                              }"
                            >
                              {{ property.status_name }}
                            </Link>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <hr />

                    <!-- Approval/Reject Form -->
                    <div class="mt-4">
                      <h4>Approve or Reject Property</h4>
                      <form @submit.prevent="submitDecision">
                        <div class="mb-3">
                          <label class="form-label"
                            >Comment (Required for rejection)</label
                          >
                          <textarea
                            v-model="comment"
                            class="form-control"
                            :class="{
                              'is-invalid':
                                showError && !comment && isRejecting,
                            }"
                            placeholder="Enter comment here..."
                            rows="3"
                          ></textarea>
                          <div
                            v-if="showError && !comment && isRejecting"
                            class="invalid-feedback"
                          >
                            Comment is required when rejecting.
                          </div>
                        </div>

                        <div class="d-flex gap-2">
                          <button
                            type="button"
                            class="btn btn-success"
                            :disabled="loading"
                            @click="approveProperty"
                          >
                            <span v-if="loading && !isRejecting"
                              >Loading... Please wait</span
                            >
                            <span v-else>Approve</span>
                          </button>

                          <button
                            type="button"
                            class="btn btn-danger"
                            :disabled="loading"
                            @click="rejectProperty"
                          >
                            <span v-if="loading && isRejecting"
                              >Loading... Please wait</span
                            >
                            <span v-else>Reject</span>
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- End Approval/Reject Form -->
                  </div>
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
import { ref } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import UserNav from "../Dashboard/UserNav.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  property: Object,
});

const comment = ref("");
const loading = ref(false);
const isRejecting = ref(false);
const showError = ref(false);

const dateFormat = (date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let monthNames = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  let month = monthNames[objectDate.getMonth()];
  let year = objectDate.getFullYear();
  return `${day}-${month}-${year}`;
};

const numberFormat = (x) => {
  return x ? x.toLocaleString("en-US") : "";
};

// Approve property
const approveProperty = () => {
  isRejecting.value = false;
  submitDecision();
};

// Reject property
const rejectProperty = () => {
  isRejecting.value = true;
  if (!comment.value) {
    showError.value = true;
    return;
  }
  submitDecision();
};

// Submit approval or rejection
const submitDecision = () => {
  showError.value = false;
  loading.value = true;

  const action = isRejecting.value ? "reject" : "approve";

  Inertia.post(
    `/admin/decision`,
    {
      property_id: props.property.id,
      comment: comment.value,
      action: action, // Ensure action is a string
    },
    {
      onFinish: () => {
        loading.value = false;
      },
    }
  );
};
</script>
