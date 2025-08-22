<template>
  <Head title="Register" />
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
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1">Register</h3>
                    <div class="form-group">
                      <input
                        type="text"
                        name="fullNames"
                        v-model="form.fullNames"
                      />
                      <label for="fullNames">Full Names</label>
                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.fullNames"
                        v-text="$page.props.errors.fullNames"
                      ></div>
                    </div>
                    <div class="form-group">
                      <input
                        type="text"
                        name="telephone"
                        v-model="form.telephone"
                      />
                      <label for="telephone">Telephone</label>
                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.telephone"
                        v-text="$page.props.errors.telephone"
                      ></div>
                    </div>
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
                    <div class="form-group">
                      <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                      />
                      <label>Re-enter Password</label>

                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.password_confirmation"
                        v-text="$page.props.errors.password_confirmation"
                      ></div>
                    </div>
                    <div class="submit">
                      <button
                        type="submit"
                        class="btn btn-success btn-block"
                        :disabled="!isEnabled"
                      >
                        Register
                      </button>
                    </div>

                    <p class="text-dark">
                      Have an account?<Link
                        href="/login"
                        class="text-primary mx-1"
                        >Login</Link
                      >
                    </p>

                    <div class="row">
                      <br />
                      <hr class="divider" />
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
  fullNames: "",
  telephone: "",
  email: "",
  password: "",
  password_confirmation: "",
});

let isEnabled = ref(true);
let submitForm = () => {
  form.post("/register/store", form, {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => {
      isEnabled.value = true;
    },
  });
};
</script>