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
              <!-- Bulk Action Controls -->
              <div class="row mb-3" v-if="selectedProperties.length > 0">
                <div class="col-md-12">
                  <div class="btn-group">
                    <button
                      :disabled="form.processing"
                      @click="bulkApprove"
                      class="btn btn-success btn-sm"
                    >
                      Approve Selected ({{ selectedProperties.length }})
                    </button>
                    <button
                      :disabled="form.processing"
                      @click="bulkReject"
                      class="btn btn-danger btn-sm ms-2"
                    >
                      Reject Selected ({{ selectedProperties.length }})
                    </button>
                    <button
                      :disabled="form.processing"
                      @click="clearSelection"
                      class="btn btn-secondary btn-sm ms-2"
                    >
                      Clear Selection
                    </button>
                  </div>
                </div>
              </div>

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
                          <th>
                            <label class="custom-control custom-checkbox">
                              <input
                                type="checkbox"
                                class="custom-control-input"
                                v-model="selectAll"
                                @change="toggleSelectAll"
                              />
                              <span class="custom-control-label"></span>
                            </label>
                          </th>
                          <th>Title</th>
                          <th>Type</th>
                          <th>Price</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(property, propertyKey) in properties"
                          :key="propertyKey"
                        >
                          <td>
                            <label class="custom-control custom-checkbox">
                              <input
                                type="checkbox"
                                class="custom-control-input"
                                v-model="selectedProperties"
                                :value="property.id"
                              />
                              <span class="custom-control-label"></span>
                            </label>
                          </td>
                          <td>
                            <div class="media mt-0 mb-0">
                              <div class="card-aside-img">
                                <Link
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
                                  <p>
                                    <small>
                                      By: {{ property.created_by_name }}
                                    </small>
                                  </p>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{ property.property_type_name }}</td>
                          <td class="font-weight-semibold">
                            {{ $page.props.currency }}
                            {{ numberFormat(property.amount) }}
                          </td>
                          <td>
                            <Link
                              :href="`/post-edit/1/${property.id}`"
                              class="badge"
                              :style="{
                                backgroundColor: property.status_color_code,
                                color: property.status_text_color_code,
                              }"
                            >
                              {{ property.status_name }}
                            </Link>
                          </td>
                          <td>
                            <Link
                              :href="`/admin/update-status/${property.id}`"
                              class="btn btn-success btn-sm text-white"
                            >
                              UPDATE STATUS
                            </Link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
import { onMounted, ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import UserNav from "../Dashboard/UserNav.vue";
import $ from "jquery";
import "datatables.net";
import "datatables.net-bs5";

// Props
const props = defineProps({
  properties: Array,
});

// State
const selectedProperties = ref([]);
const selectAll = ref(false);

// Inertia Form
const form = useForm({
  property_ids: [],
});

// Toggle all checkbox
const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedProperties.value = props.properties.map((p) => p.id);
  } else {
    selectedProperties.value = [];
  }
};

// Watch for changes to update selectAll
watch(selectedProperties, (newVal) => {
  selectAll.value = newVal.length === props.properties.length;
});

// Clear all selections
const clearSelection = () => {
  selectedProperties.value = [];
  selectAll.value = false;
};

// Bulk Approve
const bulkApprove = () => {
  if (selectedProperties.value.length === 0) return;

  if (
    confirm(
      `Are you sure you want to approve ${selectedProperties.value.length} properties?`
    )
  ) {
    form.property_ids = selectedProperties.value;

    form.post("/admin/bulk-approve", {
      onSuccess: () => {
        clearSelection();
      },
    });
  }
};

// Bulk Reject
const bulkReject = () => {
  if (selectedProperties.value.length === 0) return;

  if (
    confirm(
      `Are you sure you want to reject ${selectedProperties.value.length} properties?`
    )
  ) {
    form.property_ids = selectedProperties.value;

    form.post("/admin/bulk-reject", {
      onSuccess: () => {
        clearSelection();
      },
    });
  }
};

// Date format
const dateFormat = (date) => {
  const objectDate = new Date(date);
  const day = objectDate.getDate();
  const monthNames = [
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
  const month = monthNames[objectDate.getMonth()];
  const year = objectDate.getFullYear();
  let hours = objectDate.getHours();
  let minutes = objectDate.getMinutes();
  const ampm = hours >= 12 ? "pm" : "am";
  hours = hours % 12 || 12;
  minutes = minutes < 10 ? "0" + minutes : minutes;
  return `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;
};

// Number format
const numberFormat = (x) => {
  return x ? x.toLocaleString("en-US") : "";
};

// Init DataTables
onMounted(() => {
  $("#propertiesTable").DataTable({
    responsive: true,
    pageLength: 10,
    autoWidth: false,
    ordering: true,
    searching: true,
  });
});
</script>
