<template>
  <section class="sptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="wrapper bg-white p-4 p-md-5 shadow rounded-3 text-center">
            <div class="mb-4">
              <div class="icon-failed mb-3">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="64"
                  height="64"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="#dc3545"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="15" y1="9" x2="9" y2="15"></line>
                  <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
              </div>
              <h4 class="text-danger">PAYMENT FAILED</h4>
              <div class="divider-center bg-danger"></div>
            </div>

            <div class="payment-status mb-4">
              <h5 class="fw-bold mb-3">We couldn't process your payment</h5>
              <div class="alert alert-danger text-start" role="alert">
                <strong>Error {{ code }}:</strong> {{ message }}
              </div>

              <div
                class="payment-details bg-light p-4 rounded-3 text-start mb-4"
              >
                <h6 class="fw-bold mb-3">Transaction Details</h6>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Reference Number:</span>
                  <span class="fw-medium">{{ reference }}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted">Status:</span>
                  <span class="badge bg-danger">Failed</span>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2">
              <!-- <button @click="retryPayment" class="btn btn-danger">
                Retry Payment
              </button> -->
              <Link
                :href="`/checkout-now?subscription_id=${subscriptionID}&property_id=${propertyID}`"
                class="btn btn-danger"
              >
                Retry Payment
              </Link>

              <Link href="/dashboard" class="btn btn-outline-secondary"
                >Go to Dashboard</Link
              >
            </div>

            <div class="mt-4 text-start">
              <h6 class="fw-bold">Need help?</h6>
              <p class="text-muted small">
                If you're experiencing issues with your payment, please contact
                our support team at
                <a href="mailto:support@example.com">info@justhomesapp.com</a>
                with your reference number.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import { useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
  reference: String,
  code: String,
  message: String,
  subscriptionID: String,
  propertyID: String,
});

const retryPayment = () => {
  //   router.visit("/subscriptions", {
  //     only: ["subscriptions"],
  //     preserveState: true,
  //     preserveScroll: true,
  //   });
};
</script>

<style scoped>
.icon-failed {
  animation: shake 0.5s;
}

@keyframes shake {
  0%,
  100% {
    transform: translateX(0);
  }
  10%,
  30%,
  50%,
  70%,
  90% {
    transform: translateX(-5px);
  }
  20%,
  40%,
  60%,
  80% {
    transform: translateX(5px);
  }
}

.divider-center {
  width: 80px;
  height: 3px;
  margin: 10px auto;
  border-radius: 3px;
}

.bg-danger {
  background: #dc3545;
}
</style>