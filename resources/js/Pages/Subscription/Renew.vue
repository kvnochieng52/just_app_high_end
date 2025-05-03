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
                  <h4 style="text-align: center">Upgrade Subscription</h4>

                  <!-- Active Subscription Section -->
                  <div
                    class="active-subscription"
                    v-if="userActiveSubscription"
                  >
                    <h4>
                      Current Plan:
                      {{ userActiveSubscription?.sbscription_title || "N/A" }}
                    </h4>
                    <p>
                      <strong>
                        Utilized:
                        {{ userActiveSubscription?.properties_count || 0 }} /
                        {{
                          userActiveSubscription?.properties_post_count === -1
                            ? "Unlimited"
                            : userActiveSubscription?.properties_post_count || 0
                        }}
                        Properties
                      </strong>
                      (per Month)
                    </p>
                    <p>
                      Valid Until:
                      {{
                        userActiveSubscription?.end_date
                          ? formatDate(userActiveSubscription.end_date)
                          : "N/A"
                      }}
                    </p>
                  </div>

                  <!-- Upgrade Subscription Button -->
                  <!-- <button
                    v-if="userActiveSubscription && subscriptions.length > 1"
                    class="btn btn-outline-success"
                    @click="showUpgradeOptions = !showUpgradeOptions"
                  >
                    <strong>UPGRADE SUBSCRIPTION</strong>
                  </button> -->

                  <!-- Subscription Form -->
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <label
                      v-for="subscription in filteredSubscriptions"
                      :key="subscription.id"
                      :for="'subscription-' + subscription.id"
                      class="subscription-option"
                    >
                      <div class="form-check me-3">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="subscription"
                          :id="'subscription-' + subscription.id"
                          :value="subscription.id"
                          v-model="form.subscription"
                        />
                      </div>
                      <div>
                        <div class="subscription-title">
                          {{ subscription.sbscription_title }}
                        </div>
                        <div class="subscription-price">
                          {{ $page.props.currency }}
                          {{ formatAmount(subscription.amount) }}
                        </div>
                        <div class="subscription-description">
                          {{ subscription.description }}
                        </div>
                      </div>
                    </label>

                    <!-- Continue Button with Spinner -->
                    <div class="text-center">
                      <div
                        class="text-danger text-bold"
                        v-if="$page.props.errors.subscription"
                        v-text="$page.props.errors.subscription"
                      ></div>
                      <button
                        type="submit"
                        class="btn btn-primary w-100 mt-3"
                        :disabled="form.processing"
                      >
                        <span v-if="form.processing">
                          <i class="spinner-border spinner-border-sm"></i>
                          Processing...
                        </span>
                        <span v-else>Continue</span>
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
import { ref, computed, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  subscriptions: Array,
  userActiveSubscription: Object,
});

const showUpgradeOptions = ref(!props.userActiveSubscription);

// Filter out the active subscription from the upgrade options
const filteredSubscriptions = computed(() => {
  if (!props.userActiveSubscription) return props.subscriptions; // Return all if no active subscription
  return props.subscriptions.filter(
    (s) => s.id !== props.userActiveSubscription?.subscription_id
  );
});

// Vue's useForm for managing form state
const form = useForm({
  subscription: "",
  price: 0,
  step: 4,
});

onMounted(() => {
  if (!props.userActiveSubscription && props.subscriptions.length > 0) {
    form.subscription = props.subscriptions[0].id;
  }
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString();
};

// const submitForm = async () => {
//   try {
//     await form.post("/subscription/renew-process", {
//       forceFormData: true,
//       preserveScroll: true,
//     });

//     if (!form.hasErrors() && form.success) {
//       window.location.href = form.success.redirect_url;
//     }
//   } catch (error) {
//     console.error("Payment failed:", error);
//   }
// };

const submitForm = async () => {
  window.location.href =
    "/checkout-now?subscription_id=" + form.subscription + "&property_id=0";

  // try {
  //   await form.post("/subscription/renew-process", {
  //     forceFormData: true,
  //     preserveScroll: true,
  //   });

  //   if (!form.hasErrors() && form.success) {
  //     window.location.href = form.success.redirect_url;
  //   }
  // } catch (error) {
  //   console.error("Payment failed:", error);
  // }
};

const formatAmount = (amount) => {
  return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
.active-subscription {
  text-align: center;
  background: #f8f9fa;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 15px;
}
</style>
