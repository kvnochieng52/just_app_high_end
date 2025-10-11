<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Settings</h3>
            </div>
            <div class="card-body">
              <div class="ads-tabs">
                <div class="tab-content">
                  <div
                    class="tab-pane active table-responsive userprof-tab"
                    id="tab1"
                  >
                    <div class="single-page">
                      <div class="wrapper wrapper2">
                        <form
                          id="register_form"
                          class="card-body"
                          @submit.prevent="submitForm"
                        >
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <input
                                  type="text"
                                  name="name"
                                  v-model="form.name"
                                  placeholder="Enter your Full Names"
                                />
                                <label for="name">Full Names</label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.name"
                                  v-text="$page.props.errors.name"
                                ></div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="email"
                                  name="email"
                                  v-model="form.email"
                                  placeholder="Enter Email Address"
                                />
                                <label for="email">Email Address</label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.email"
                                  v-text="$page.props.errors.email"
                                ></div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="text"
                                  name="mobile"
                                  v-model="form.mobile"
                                  placeholder="Mobile Number"
                                />
                                <label for="mobile">Mobile Number:</label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.mobile"
                                  v-text="$page.props.errors.mobile"
                                ></div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="text"
                                  name="companyName"
                                  v-model="form.companyName"
                                  placeholder="Enter Company Name"
                                />
                                <label for="companyName">Company Name</label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.companyName"
                                  v-text="$page.props.errors.companyName"
                                ></div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="url"
                                  name="website"
                                  v-model="form.website"
                                  placeholder="Enter  Website"
                                />
                                <label for="website">Website(optional)</label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.website"
                                  v-text="$page.props.errors.website"
                                ></div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="url"
                                  name="facebook"
                                  v-model="form.facebook"
                                  placeholder="Facebook Profile page"
                                />
                                <label for="facebook"
                                  >Facebook Profile page(Optional)
                                </label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.facebook"
                                  v-text="$page.props.errors.facebook"
                                ></div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="url"
                                  name="tiktok"
                                  v-model="form.tiktok"
                                  placeholder="tiktok Profile page"
                                />
                                <label for="tiktok"
                                  >Tiktok Profile page (Optional)
                                </label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.tiktok"
                                  v-text="$page.props.errors.tiktok"
                                ></div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="url"
                                  name="twitter"
                                  v-model="form.twitter"
                                  placeholder="Twitter Profile page"
                                />
                                <label for="twitter"
                                  >Twitter Profile page(Optional)
                                </label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.twitter"
                                  v-text="$page.props.errors.twitter"
                                ></div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <input
                                  type="url"
                                  name="linkedin"
                                  v-model="form.linkedin"
                                  placeholder="LinkedIn Profile page"
                                />
                                <label for="linkedin"
                                  >LinkedIn Profile page(Optional)
                                </label>
                                <div
                                  class="text-red text-left smaller-text"
                                  v-if="$page.props.errors.linkedin"
                                  v-text="$page.props.errors.linkedin"
                                ></div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <textarea
                                class="form-control"
                                name="profile"
                                id="profile"
                                rows="4"
                                v-model="form.profile"
                              ></textarea>
                              <label for="profile"
                                >Profile (Say something about yoursel)</label
                              >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <button
                                type="submit"
                                class="btn btn-success pull-left"
                              >
                                <strong>UPDATE PROFILE</strong>
                              </button>
                            </div>
                          </div>
                        </form>
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
  </section>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import Paginator from "../../Shared/Paginator.vue";
import SideBar from "../../Pages/Dashboard/SideBar.vue";
import UserNav from "./UserNav.vue";

let props = defineProps({
  userDetails: Object,
});

let form = useForm({
  name: props.userDetails.name,
  email: props.userDetails.email,
  mobile: props.userDetails.telephone,
  companyName: props.userDetails.company_name,
  website: props.userDetails.website,
  facebook: props.userDetails.facebook,
  tiktok: props.userDetails.tiktok,
  twitter: props.userDetails.twitter,
  linkedin: props.userDetails.linkedin,
  profile: props.userDetails.profile,
  UserID: props.userDetails.id,
});

let submitForm = () => {
  console.log(props.property);
  form.post("/dashboard/update-profile", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};
</script>
