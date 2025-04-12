<template>
  <div>
    <!-- Show upgrade dialog if needed -->
    <div class="card border-danger text-dark mb-3" v-if="showUpgradeDialog">
      <div class="card-body">
        <h2 class="card-title text-danger">
          <i class="fa fa-exclamation-circle"></i>&nbsp; No Active Subscription
        </h2>
        <p class="card-text text-dark">
          You currently don’t have an active subscription. You will be able to
          post properties but won't get approved & Listed until you renew your
          subscription.
        </p>
        <Link href="/subscription/renew" class="btn btn-danger">
          Renew Subscription
        </Link>
      </div>
    </div>

    <!-- Show active subscription info -->
    <div class="card border-success text-dark mb-3" v-else>
      <div class="card-body">
        <h2 class="card-title mb-2 text-success">
          <i class="fa fa-check-circle"></i>&nbsp; Subscription Active
        </h2>
        <p class="subscription-info text-dark">
          <span>
            Current Plan:
            <strong>{{ userActiveSubscription.sbscription_title }}</strong>
          </span>

          <span>
            Utilized:
            <strong>
              {{ userActiveSubscription.properties_count }} /
              {{
                userActiveSubscription.properties_post_count === -1
                  ? "Unlimited"
                  : userActiveSubscription.properties_post_count
              }}
            </strong>
          </span>

          <span>
            Valid Until:
            <strong>{{ formatDate(userActiveSubscription.end_date) }}</strong>
          </span>
        </p>
        <Link href="/subscription/renew" class="btn btn-success">
          Upgrade Subscription
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Link } from "@inertiajs/inertia-vue3";

const showUpgradeDialog = ref(false);
const userActiveSubscription = ref({});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString();
};

const fetchSubscriptionStatus = async () => {
  try {
    const response = await axios.get("/subscription/status");
    const data = response.data;

    if (!data || !data.subscription) {
      showUpgradeDialog.value = true;
      return;
    }

    userActiveSubscription.value = data.subscription;

    if (
      data.subscription.properties_post_count !== -1 &&
      data.subscription.properties_count >=
        data.subscription.properties_post_count
    ) {
      showUpgradeDialog.value = true;
    }
  } catch (error) {
    console.error("Failed to fetch subscription status:", error);
    showUpgradeDialog.value = true;
  }
};

onMounted(fetchSubscriptionStatus);
</script>

<style>
.subscription-info span {
  margin-right: 20px;
}
</style>
