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
                        {{ userActiveSubscription?.properties_post_count || 0 }}
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

                  <button
                    v-if="userActiveSubscription && subscriptions.length > 1"
                    class="btn btn-outline-success"
                    @click="showUpgradeOptions = !showUpgradeOptions"
                  >
                    <strong>CHANGE SUBSCRIPTION</strong>
                  </button>

                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <template v-if="showUpgradeOptions">
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
                            v-model="selectedSubscription"
                          />
                        </div>
                        <div>
                          <div class="subscription-title">
                            {{ subscription.sbscription_title }}
                          </div>
                          <div class="subscription-price">
                            KSH {{ subscription.amount.toLocaleString() }}
                          </div>
                          <div class="subscription-description">
                            {{ subscription.description }}
                          </div>
                        </div>
                      </label>
                    </template>

                    <div class="text-center">
                      <!-- <input
                        type="text"
                        name="propertyID"
                        :value="property.id"
                        v-model="form.propertyID"
                      /> -->
                      <button type="submit" class="btn btn-primary w-100 mt-3">
                        Continue
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
    <!-- {{ property }} -->
  </section>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  subscriptions: Array,
  userActiveSubscription: Object,
  property: Object,
});

const showUpgradeOptions = ref(!props.userActiveSubscription);
const selectedSubscription = ref(null);
const isEnabled = ref(true);

// Filter out the active subscription from the upgrade options
const filteredSubscriptions = computed(() => {
  if (!props.userActiveSubscription) return props.subscriptions; // Return all if no active subscription
  return props.subscriptions.filter(
    (s) => s.id !== props.userActiveSubscription?.subscription_id
  );
});

// Select first available subscription if the user has no active subscription
onMounted(() => {
  if (!props.userActiveSubscription && props.subscriptions.length > 0) {
    selectedSubscription.value = props.subscriptions[0].id;
  }
});

// Watch for changes and update form values
watch(selectedSubscription, (newValue) => {
  form.subscription = newValue;
});

const form = useForm({
  subscription: selectedSubscription.value,
  price: 0,
  step: 4,
  propertyID: props.property.id,
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString();
};

const submitForm = async () => {
  isEnabled.value = false;
  try {
    const response = await form.post("/property/store", {
      forceFormData: true,
      preserveScroll: true,
      onStart: () => (isEnabled.value = false),
      onFinish: () => (isEnabled.value = true),
    });

    if (response?.data?.redirect_url) {
      window.location.href = response.data.redirect_url; // Redirect if URL exists
    }
  } catch (error) {
    console.error("Payment failed:", error.response?.data?.error);
  } finally {
    isEnabled.value = true;
  }
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
