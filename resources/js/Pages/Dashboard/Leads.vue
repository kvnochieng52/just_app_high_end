<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Lead Management</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body p-4">
                      <div class="ms-4 mt-1">
                        <h3 class="mb-0 font-weight-bold">
                          {{ telephoneLeadsCount + messagesCount }}
                        </h3>
                        <p class="mb-0 text-muted">Detail views</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body p-4">
                      <div class="ms-4 mt-1">
                        <h3 class="mb-0 font-weight-bold">0</h3>
                        <p class="mb-0 text-muted">Search views</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body p-4">
                      <div class="ms-4 mt-1">
                        <h3 class="mb-0 font-weight-bold">
                          {{ messagesCount }}
                        </h3>
                        <p class="mb-0 text-muted">Email leads</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body p-4">
                      <div class="ms-4 mt-1">
                        <h3 class="mb-0 font-weight-bold">
                          {{ telephoneLeadsCount }}
                        </h3>
                        <p class="mb-0 text-muted">Phone Leads</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <br />
                  <h4>All Leads</h4>
                  <div
                    class="tab-pane active table-responsive userprof-tab pt-5"
                  >
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
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { onMounted } from "vue";
import UserNav from "./UserNav.vue";

let props = defineProps({
  telephoneLeadsCount: Number,
  messagesCount: Number,
  appartmentsCount: Number,
  housesCount: Number,
  officeCount: Number,
  recentMessages: Object,
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
</script>

<style>
.chart-size {
  width: 280px;
  height: 280px;
  max-width: 100%;
  max-height: 100%;
}
</style>
