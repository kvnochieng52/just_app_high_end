<template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Refund & Cancellation Policy</strong></h4>
            </div>
            <div class="card-body">
              <h4>1. Subscription Payments</h4>
              <p>
                Just Homes offers subscription-based plans for property
                listings. By subscribing, you agree to the terms outlined in
                this policy. All payments made for subscriptions are
                non-refundable except under the conditions specified below.
              </p>

              <h4>2. Refund Eligibility</h4>
              <p>Refunds may be issued under the following circumstances:</p>
              <ul>
                <li>
                  <strong>Duplicate Payment:</strong> If you were mistakenly
                  charged twice for the same subscription.
                </li>
                <li>
                  <strong>Technical Issues:</strong> If a technical error on our
                  platform prevents you from accessing your subscription
                  benefits.
                </li>
                <li>
                  <strong>Unauthorized Transaction:</strong> If you notice an
                  unauthorized charge on your account and report it within 7
                  days of the transaction.
                </li>
              </ul>

              <h4>3. Non-Refundable Cases</h4>
              <p>We do not offer refunds in the following cases:</p>
              <ul>
                <li>Change of mind after subscribing.</li>
                <li>
                  Failure to use the subscription within the billing cycle.
                </li>
                <li>Cancellation after the subscription period has started.</li>
                <li>Incorrect selection of subscription plan.</li>
              </ul>

              <h4>4. Cancellation Policy</h4>
              <p>
                You can cancel your subscription at any time, but the
                cancellation will take effect at the end of your current billing
                cycle.
              </p>
              <p>
                No prorated refunds will be issued for unused days within a
                billing cycle.
              </p>

              <h4>5. Refund Request Process</h4>
              <p>
                To request a refund, please contact our support team at
                <span class="contact">info@justhomes.com</span> with the
                following details:
              </p>
              <ul>
                <li>Your registered email address.</li>
                <li>Proof of payment (transaction ID or receipt).</li>
                <li>A brief explanation of the refund request.</li>
              </ul>
              <p>
                Refund requests will be reviewed within
                <strong>5-10 business days</strong>, and approved refunds will
                be processed to the original payment method within
                <strong>7-14 business days</strong>.
              </p>

              <h4>6. Changes to the Refund Policy</h4>
              <p>
                Just Homes reserves the right to modify this refund policy at
                any time. Any changes will be updated on our website, and
                continued use of our services implies acceptance of the revised
                policy.
              </p>

              <p>
                For any questions or concerns, feel free to reach out to us at
                <span class="contact">info@justhomes.com</span>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<style scoped>
.contact {
  font-weight: bold;
}
</style>