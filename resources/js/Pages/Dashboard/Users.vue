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
                      class="table table-bordered table-hover mb-0 text-nowrap"
                    >
                      <thead>
                        <tr>
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
                                name="checkbox"
                                value=""
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
                                  <a
                                    href="javascript:void(0);"
                                    class="text-dark"
                                  >
                                    <h4 class="font-weight-semibold">
                                      {{ user.name }}
                                    </h4>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>
                            {{ user.role_name }}
                          </td>
                          <td class="font-weight-semibold">
                            {{ user.is_active == 1 ? "Active" : "Suspended" }}
                          </td>

                          <td>
                            <Link
                              :href="'/dashboard/user-edit/' + user.id"
                              class="btn btn-success btn-sm text-white"
                              ><i class="fa fa-pencil"></i>
                            </Link>

                            <Link
                              :href="'/dashboard/user-delete/' + user.id"
                              class="btn btn-primary btn-sm text-white"
                              data-bs-toggle="tooltip"
                              data-bs-original-title="Delete"
                              ><i class="fa fa-trash-o"></i
                            ></Link>
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
import Paginator from "../../Shared/Paginator.vue";
import SideBar from "../../Pages/Dashboard/SideBar.vue";
import UserNav from "./UserNav.vue";
defineProps({
  users: Object,
});

let processing = true;

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
