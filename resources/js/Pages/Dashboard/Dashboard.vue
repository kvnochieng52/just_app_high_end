<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <SubscriptionStatus />

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Dashboard</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-5">
                  <h5 class="text-center pb-5">Communication Leads</h5>
                  <canvas id="donutChart" class="chart-size"></canvas>
                </div>

                <div class="col-md-7">
                  <h5 class="text-center pb-5">Your Listings</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-building"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ appartmentsCount }}
                              </h3>
                              <p class="mb-0 text-muted">Apartments</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-home"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ housesCount }}
                              </h3>
                              <p class="mb-0 text-muted">Houses</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-map"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ landsCount }}
                              </h3>
                              <p class="mb-0 text-muted">Lands</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-object-group"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ officeCount }}
                              </h3>
                              <p class="mb-0 text-muted">Office Spaces</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-home"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ towhHouseCount }}
                              </h3>
                              <p class="mb-0 text-muted">Town Houses</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-shopping-bag"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ shoppsCount }}
                              </h3>
                              <p class="mb-0 text-muted">Shops</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body p-4">
                          <div class="d-flex">
                            <div>
                              <span
                                class="bg-secondary-transparent icon-service1 text-secondary"
                              >
                                <i class="fa fa-home"></i>
                              </span>
                            </div>
                            <div class="ms-4 mt-1">
                              <h3 class="mb-0 font-weight-bold">
                                {{ villasCount }}
                              </h3>
                              <p class="mb-0 text-muted">Villas</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Recent Requests</h3>
            </div>
            <div class="card-body">
              <div class="tab-pane active table-responsive userprof-tab">
                <table
                  class="table table-bordered table-hover mb-0 text-nowrap"
                >
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Type</th>
                      <th>Rooms</th>
                      <th>Contact</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(message, messageKey) in recentMessages"
                      :key="messageKey"
                    >
                      <td>{{ message.property_title }}</td>
                      <td>{{ message.property_type_name }}</td>
                      <td></td>
                      <td>
                        {{ message.name }}<br />
                        {{ message.telephone }}
                      </td>
                      <td>{{ message.date }}</td>
                    </tr>
                  </tbody>
                </table>
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
import { onMounted } from "vue";
import { Chart, registerables } from "chart.js";
import UserNav from "./UserNav.vue";
import SubscriptionStatus from "../Subscription/SubscriptionStatus.vue";

Chart.register(...registerables);

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString();
};

let props = defineProps({
  telephoneLeadsCount: Number,
  messagesCount: Number,
  appartmentsCount: Number,
  housesCount: Number,
  landsCount: Number,
  officeCount: Number,
  villasCount: Number,
  towhHouseCount: Number,
  shoppsCount: Number,
  recentMessages: Object,
  showUpgradeDialog: Boolean,
  userActiveSubscription: Object,
});

let dateFormat = (date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let month = objectDate.getMonth();
  let year = objectDate.getFullYear();

  let format4 = day + "-" + month + "-" + year;
  return format4;
};

let numberFormat = (x) => {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

onMounted(() => {
  const ctx = document.getElementById("donutChart").getContext("2d");
  const data = {
    labels: ["Email", "Telephone"],
    datasets: [
      {
        label: "My First Dataset",
        data: [props.messagesCount, props.telephoneLeadsCount, 0],
        backgroundColor: [
          "rgb(90, 205, 90)", // Darker green
          "rgb(184, 134, 11)", // Dark yellow/goldenrod
        ],
        hoverOffset: 4,
      },
    ],
  };

  const config = {
    type: "doughnut",
    data: data,
    options: {
      cutout: "80%",
      plugins: {
        legend: {
          position: "bottom",
        },
      },
    },
  };

  new Chart(ctx, config);
});
</script>

<style>
.chart-size {
  width: 280px;
  height: 280px;
  max-width: 100%;
  max-height: 100%;
}
</style>
