<template>
  <section class="sptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="wrapper bg-white p-4 p-md-5 shadow rounded-3 text-center">
            <div class="mb-4">
              <h4>PROCESSING YOUR PAYMENT</h4>
              <div class="divider-center"></div>
            </div>

            <div class="payment-status mb-4">
              <h5 v-if="paymentMethod == 'mobile_money'" class="fw-bold mb-2">
                Enter The M-pesa Pin on the Prompt
              </h5>

              <h5 v-else>Wait We confirm</h5>
              <p class="text-muted">Then wait we confirm your payment</p>

              <div
                class="spinner-border text-purple mb-3"
                role="status"
                style="width: 15px; height: 15px"
              >
                <span class="visually-hidden">Loading...</span>
              </div>
              <!-- <p class="countdown">
                Checking your payment status in: {{ countdown }} seconds...
              </p> -->
              <p class="text-muted small">
                Time remaining: {{ totalTimeRemaining }} seconds
              </p>
            </div>

            <div class="payment-details bg-light p-4 rounded-3 text-start mb-4">
              <h6 class="fw-bold mb-3">Transaction Details</h6>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Reference:</span>
                <span class="fw-medium">{{ transactionReference }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Amount:</span>
                <span class="fw-medium"
                  >{{ $page.props.currency }}
                  {{ subscriptionDetails.amount }}</span
                >
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-muted">Plan:</span>
                <span class="fw-medium">{{
                  subscriptionDetails.sbscription_title
                }}</span>
              </div>
            </div>

            <Link
              :href="`/checkout-now?subscription_id=${subscriptionDetails.id}&property_id=${propertyID}`"
              style="
                background: none;
                border: none;
                color: red;
                padding: 0;
                cursor: pointer;
                text-decoration: underline;
              "
            >
              Cancel
            </Link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onUnmounted, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  transactionReference: String,
  subscriptionDetails: Object,
  propertyID: String,
  paymentMethod: String,
});

const countdown = ref(8);
const totalTimeRemaining = ref(60);
const checkInterval = ref(null);
const timeoutInterval = ref(null);

// Status codes that indicate we should keep checking
const pendingStatuses = ["900", "001", "002", "003", "005", "007"];

// Status codes that indicate success
const successStatuses = ["000"];

// Status codes that indicate immediate failure
const failureStatuses = [
  "901",
  "902",
  "903",
  "904",
  "950",
  "801",
  "802",
  "803",
  "804",
];

const checkPaymentStatus = () => {
  axios
    .post("/check-payment-status", {
      reference: props.transactionReference,
    })
    .then((response) => {
      const statusCode = response.data.code;
      const message = response.data.message;

      if (successStatuses.includes(statusCode)) {
        // Payment succeeded
        clearIntervals();
        Inertia.visit(
          "/payment-success?reference=" + props.transactionReference
        );
      } else if (failureStatuses.includes(statusCode)) {
        // Payment failed
        clearIntervals();
        Inertia.visit(
          `/payment-failed?reference=${
            props.transactionReference
          }&code=${statusCode}&message=${encodeURIComponent(
            message
          )}&subscription_id=${props.subscriptionDetails.id}&property_id=${
            props.propertyID
          }`
        );
      } else if (pendingStatuses.includes(statusCode)) {
        // Still pending, continue checking
        countdown.value = 3;
      } else {
        // Unknown status code - treat as failure
        clearIntervals();
        Inertia.visit(
          `/payment-failed?reference=${
            props.transactionReference
          }&code=unknown&message=${encodeURIComponent(
            "Unknown payment status"
          )}}&subscription_id=${props.subscriptionDetails.id}&property_id=${
            props.propertyID
          }`
        );
      }
    })
    .catch((error) => {
      console.error("Error checking payment status:", error);
      countdown.value = 3;
    });
};

const clearIntervals = () => {
  if (checkInterval.value) clearInterval(checkInterval.value);
  if (timeoutInterval.value) clearInterval(timeoutInterval.value);
};

onMounted(() => {
  // Start countdown timer for individual checks
  checkInterval.value = setInterval(() => {
    if (countdown.value > 0) {
      countdown.value--;
    } else {
      checkPaymentStatus();
    }
  }, 1000);

  // Start total timeout timer (60 seconds)
  timeoutInterval.value = setInterval(() => {
    if (totalTimeRemaining.value > 0) {
      totalTimeRemaining.value--;
    } else {
      // Timeout reached
      clearIntervals();
      Inertia.visit(
        `/payment-failed?reference=${
          props.transactionReference
        }&code=timeout&message=${encodeURIComponent(
          "Payment confirmation timeout"
        )}`
      );
    }
  }, 1000);
});

// Clean up intervals when component unmounts
onUnmounted(() => {
  clearIntervals();
});
</script>

<style scoped>
/* Add your styles here */
.payment-status {
  padding: 2rem 0;
}

.countdown {
  font-size: 1.1rem;
  font-weight: 500;
  color: #6a0dad;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}

.text-purple {
  color: #6a0dad;
}

.divider-center {
  width: 80px;
  height: 3px;
  background: #6a0dad;
  margin: 10px auto;
  border-radius: 3px;
}
</style>