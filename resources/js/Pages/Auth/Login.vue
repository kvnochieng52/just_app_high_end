<template>
  <Head title="Login" />
  <section class="sptb">
    <div class="container customerpage">
      <div class="row">
        <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
          <div class="tab-content" id="myTabContent">
            <div
              class="tab-pane fade show active"
              id="home"
              role="tabpanel"
              aria-labelledby="home-tab"
            >
              <div class="single-page w-100 p-0">
                <div class="wrapper wrapper2">
                  <form
                    id="login"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1">Login</h3>
                    <div class="row">
                      <div class="col-12 mb-2">
                        <a
                          href="/login/google"
                          class="btn btn-light btn-block d-flex justify-content-center align-items-center"
                        >
                          <img
                            src="/images/svg/google.svg"
                            alt="Google"
                            class="me-2"
                            style="width: 20px; height: 20px"
                          />
                          <span class="fw-bold fs-6">Google</span>
                        </a>
                      </div>

                      <!-- <div class="col-6 mb-2">
                        <a
                          href="http://localhost:8000/login/facebook"
                          class="btn btn-light btn-block text-start"
                        >
                          <img
                            src="/images/svg/facebook.svg"
                            alt=""
                            class="w-4 h-4 me-2"
                          />
                          <span class="font-weight-bold fs-15">Facebook</span>
                        </a>
                      </div> -->
                    </div>
                    <hr class="divider" />
                    <div class="form-group">
                      <input type="email" name="email" v-model="form.email" />
                      <label for="email">Email</label>
                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.email"
                        v-text="$page.props.errors.email"
                      ></div>
                    </div>

                    <div class="form-group">
                      <input
                        type="password"
                        name="password"
                        v-model="form.password"
                      />
                      <label for="password">Password</label>
                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.password"
                        v-text="$page.props.errors.password"
                      ></div>
                    </div>
                    <div class="submit">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block green_b"
                      >
                        LOGIN
                      </button>
                    </div>
                    <p class="mb-2">
                      <a href="/register">Forgot Password</a>
                    </p>
                    <p class="text-dark mb-0">
                      Don't have account?<Link
                        href="/register"
                        class="text-primary mx-1"
                        >Sign Up</Link
                      >
                    </p>
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

<style></style>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

let form = useForm({
  email: "",
  password: "",
});

let isEnabled = ref(true);

let submitForm = () => {
  console.log("submitted");
  form.post("/login/attempt", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};
</script>