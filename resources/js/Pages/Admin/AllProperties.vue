<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">All Listings</h3>
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
                          <th></th>
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
                              />
                              <span class="custom-control-label"></span>
                            </label>
                          </td>
                          <td>
                            <div class="media mt-0 mb-0">
                              <div class="card-aside-img">
                                <Link
                                  :href="
                                    '/' +
                                    property.property_type_slug +
                                    '/' +
                                    property.slug
                                  "
                                ></Link>
                                <img
                                  :src="'/' + property.thumbnail"
                                  alt="img"
                                />
                              </div>
                              <div class="media-body">
                                <div class="card-item-desc ms-4 p-0 mt-2">
                                  <Link
                                    :href="
                                      '/' +
                                      property.property_type_slug +
                                      '/' +
                                      property.slug
                                    "
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
                                    <small
                                      >By: {{ property.created_by_name }}</small
                                    >
                                  </p>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{ property.property_type_name }}</td>
                          <td class="font-weight-semibold">
                            <!-- {{ $page.props.currency }} -->

                            {{ property.currency_name }}
                            {{ numberFormat(property.amount) }}
                          </td>
                          <!-- <td>
                            <Link
                              :href="'/post-edit/1/' + property.id"
                              class="badge badge-success"
                              >Published</Link
                            >
                          </td> -->

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

                          <td>
                            <Link
                              :href="'/post-edit/1/' + property.id"
                              class="btn btn-success btn-sm text-white"
                            >
                              <i class="fa fa-pencil"></i>
                            </Link>
                            <Link
                              :href="'/post-delete/' + property.id"
                              class="btn btn-danger btn-sm text-white"
                            >
                              <i class="fa fa-trash-o"></i>
                            </Link>
                            <Link
                              :href="
                                '/' +
                                property.property_type_slug +
                                '/' +
                                property.slug
                              "
                              class="btn btn-success btn-sm text-white btn-flat"
                            >
                              <i class="fa fa-eye"></i>
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
import { onMounted } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import UserNav from "../Dashboard/UserNav.vue";
import $ from "jquery";
import "datatables.net";
import "datatables.net-bs5"; // Bootstrap 5 styling for DataTables

defineProps({
  properties: Array,
});

let dateFormat = (date) => {
  let objectDate = new Date(date);

  // Date formatting
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

  // Time formatting
  let hours = objectDate.getHours();
  let minutes = objectDate.getMinutes();
  let ampm = hours >= 12 ? "pm" : "am";
  hours = hours % 12 || 12; // Convert 0 to 12
  minutes = minutes < 10 ? "0" + minutes : minutes;

  let time = `${hours}:${minutes} ${ampm}`;

  return `${day}-${month}-${year} ${time}`;
};

let numberFormat = (x) => {
  return x ? x.toLocaleString("en-US") : "";
};

// Initialize DataTables on mount
onMounted(() => {
  $("#propertiesTable").DataTable({
    responsive: true,
    pageLength: 10,
    lengthChange: false, // Disable changing the number of rows displayed
    autoWidth: false,
    ordering: true,
    searching: true, // Enable search
  });
});
</script>

