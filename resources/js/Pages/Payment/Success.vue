<template>
  <section class="sptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="wrapper bg-white p-4 p-md-5 shadow rounded-3 text-center">
            <div class="mb-4">
              <div class="icon-success mb-3">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="64"
                  height="64"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="#28a745"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
              </div>
              <h4 class="text-success">PAYMENT SUCCESSFUL</h4>
              <div class="divider-center bg-success"></div>
            </div>

            <div class="payment-status mb-4">
              <h5 class="fw-bold mb-3">Thank you for your payment!</h5>
              <p class="text-muted">
                Your subscription has been activated successfully.
              </p>

              <div
                class="payment-details bg-light p-4 rounded-3 text-start mb-4"
              >
                <h6 class="fw-bold mb-3">Transaction Details</h6>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Reference Number:</span>
                  <span class="fw-medium">{{ reference }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Date:</span>
                  <span class="fw-medium">{{
                    new Date().toLocaleString()
                  }}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted">Status:</span>
                  <span class="badge bg-success">Completed</span>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2">
              <Link href="/dashboard" class="btn btn-success"
                >Go to Dashboard</Link
              >
              <!-- <Link href="/subscriptions" class="btn btn-outline-secondary"
                >View Subscriptions</Link
              > -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  reference: String,
});
</script>

<style scoped>
.icon-success {
  animation: bounce 1s;
}

@keyframes bounce {
  0%,
  20%,
  50%,
  80%,
  100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-20px);
  }
  60% {
    transform: translateY(-10px);
  }
}

.divider-center {
  width: 80px;
  height: 3px;
  margin: 10px auto;
  border-radius: 3px;
}

.bg-success {
  background: #28a745;
}
</style>