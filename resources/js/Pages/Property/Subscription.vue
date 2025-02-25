<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="w-100 p-0">
                <div class="wrapper bg-white p-5">
                  <h2 style="text-align: center">Subscription</h2>
                  <p style="text-align: center">
                    Choose a plan that best fits you
                  </p>
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <label for="free" class="subscription-option">
                      <div class="form-check me-3">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="subscription"
                          id="free"
                          value="free"
                          v-model="selectedSubscription"
                        />
                      </div>
                      <div>
                        <div class="subscription-title">Free</div>
                        <div class="subscription-price">KSH 0</div>
                        <div class="subscription-description">
                          3 listings per month
                        </div>
                      </div>
                    </label>

                    <label for="basic" class="subscription-option">
                      <div class="form-check me-3">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="subscription"
                          id="basic"
                          value="basic"
                          v-model="selectedSubscription"
                        />
                      </div>
                      <div>
                        <div class="subscription-title">Basic</div>
                        <div class="subscription-price">KSH 1,400</div>
                        <div class="subscription-description">
                          Up to 10 listings per month
                        </div>
                      </div>
                    </label>

                    <label for="pro" class="subscription-option">
                      <div class="form-check me-3">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="subscription"
                          id="pro"
                          value="pro"
                          v-model="selectedSubscription"
                        />
                      </div>
                      <div>
                        <div class="subscription-title">Pro</div>
                        <div class="subscription-price">KSH 3,000</div>
                        <div class="subscription-description">
                          Up to 100 listings per month
                        </div>
                      </div>
                    </label>

                    <label for="enterprise" class="subscription-option">
                      <div class="form-check me-3">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="subscription"
                          id="enterprise"
                          value="enterprise"
                          v-model="selectedSubscription"
                        />
                      </div>
                      <div>
                        <div class="subscription-title">Enterprise</div>
                        <div class="subscription-price">KSH 7,000</div>
                        <div class="subscription-description">
                          Unlimited listings
                        </div>
                      </div>
                    </label>

                    <div class="text-center">
                      <button
                        type="submit"
                        class="btn btn-primary px-4 py-2"
                        :disabled="!isEnabled"
                      >
                        Subscribe Now
                      </button>
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

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const selectedSubscription = ref("free");
const isEnabled = ref(true);

const subscriptionPlans = {
  free: 0,
  basic: 1400,
  pro: 3000,
  enterprise: 7000,
};

const selectedPrice = computed(
  () => subscriptionPlans[selectedSubscription.value] || 0
);

const form = useForm({
  subscription: selectedSubscription.value,
  price: selectedPrice.value,
  step: 4,
});

const submitForm = () => {
  form.subscription = selectedSubscription.value;
  form.price = selectedPrice.value;

  form.post("/property/store", {
    forceFormData: true,
    onStart: () => (isEnabled.value = false),
    onFinish: () => (isEnabled.value = true),
  });
};
</script>

<style>
.subscription-option {
  border: 1px solid #dee2e6;
  border-radius: 10px;
  padding: 16px;
  margin-bottom: 16px;
  display: flex;
  cursor: pointer;
  transition: box-shadow 0.2s ease-in-out, border-color 0.2s ease-in-out;
}
.subscription-option:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  border-color: #0d6efd;
}
.subscription-title {
  font-size: 1.25rem;
  font-weight: 600;
}
.subscription-price {
  font-size: 1.1rem;
  color: #6c757d;
  font-weight: 500;
}
.subscription-description {
  font-size: 0.95rem;
  color: #495057;
}
.form-check-input {
  margin-top: 0.4rem;
}
label {
  width: 100%;
}
</style>
