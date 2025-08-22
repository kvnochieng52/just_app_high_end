<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body">
              <div class="ads-tabs">
                <div class="tabs-menus">
                  <!-- Tabs -->
                  <!-- <ul class="nav panel-tabs">
                    <li class="">
                      <a href="#tab1" class="active" data-bs-toggle="tab"
                        >All Ads (20)</a
                      >
                    </li>
                    <li>
                      <a href="#tab2" data-bs-toggle="tab">Published (08)</a>
                    </li>
                    <li>
                      <a href="#tab3" data-bs-toggle="tab">Featured (05)</a>
                    </li>
                    <li><a href="#tab4" data-bs-toggle="tab">Sold (03)</a></li>
                    <li>
                      <a href="#tab5" data-bs-toggle="tab">Active (03)</a>
                    </li>
                    <li>
                      <a href="#tab6" data-bs-toggle="tab">Expired (01)</a>
                    </li>
                  </ul> -->
                </div>
                <div class="tab-content">
                  <div
                    class="tab-pane active table-responsive userprof-tab"
                    id="tab1"
                  >
                    <table
                      ref="usersTable"
                      class="table table-bordered table-hover table-striped"
                    >
                      <thead>
                        <tr style="background-color: #f3f3f3">
                          <th></th>
                          <th>Name</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(user, userKey) in users" :key="userKey">
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
                                <a href="javascript:void(0);"></a>
                                <img :src="user.avatar" alt="img" />
                              </div>
                              <div class="media-body">
                                <div class="card-item-desc ms-4 p-0 mt-2">
                                  <h4 class="font-weight-semibold">
                                    {{ user.name }}
                                  </h4>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{ user.role_name }}</td>
                          <td class="font-weight-semibold">
                            {{ user.is_active == 1 ? "Active" : "Suspended" }}
                          </td>
                          <td>
                            <Link
                              :href="'/dashboard/user-edit/' + user.id"
                              class="btn btn-success btn-sm text-white"
                            >
                              <i class="fa fa-pencil"></i>
                            </Link>
                            <Link
                              :href="'/dashboard/user-delete/' + user.id"
                              class="btn btn-success btn-sm text-white"
                            >
                              <i class="fa fa-trash-o"></i>
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
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import UserNav from "./UserNav.vue";
import { onMounted, ref } from "vue";
import $ from "jquery";
import "datatables.net-bs5";

defineProps({
  users: Object,
});

const usersTable = ref(null);

onMounted(() => {
  $(usersTable.value).DataTable({
    responsive: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    order: [[1, "asc"]],
  });
});
</script>

