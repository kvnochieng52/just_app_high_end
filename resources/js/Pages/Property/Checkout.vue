<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="w-100 p-0">
                <div class="wrapper bg-white p-5 shadow rounded">
                  <h2 class="text-center mb-4">CHECKOUT</h2>

                  <!-- Subscription and Price Display -->
                  <div class="mb-4 text-center">
                    <h5 class="fw-bold">
                      Subscription:
                      <span style="text-transform: uppercase">{{
                        subscription
                      }}</span>
                    </h5>
                    <h5 class="fw-bold text-primary">
                      Price: {{ $page.props.currency }} {{ price }}
                    </h5>
                  </div>

                  <!-- Payment Form -->
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <div class="mb-4">
                      <h5 class="fw-semibold mb-3">Select Payment Method:</h5>

                      <div class="form-check mb-3 payment-option">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="mobileMoney"
                          value="mobile_money"
                          v-model="paymentMethod"
                        />
                        <label class="form-check-label" for="mobileMoney">
                          <i class="fa fa-mobile me-2"></i>Mobile Money (Mpesa)
                        </label>
                      </div>

                      <div v-if="paymentMethod === 'mobile_money'" class="mb-3">
                        <label for="mpesaNumber" class="form-label"
                          >Mpesa Mobile Number</label
                        >
                        <input
                          type="tel"
                          id="mpesaNumber"
                          v-model="mpesaNumber"
                          class="form-control"
                          placeholder="Enter your Mpesa number"
                          required
                        />
                      </div>

                      <div class="form-check mb-3 payment-option">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="cardPayment"
                          value="card"
                          v-model="paymentMethod"
                        />
                        <label class="form-check-label" for="cardPayment">
                          <i class="fa fa-credit-card me-2"></i>Credit/Debit
                          Card
                        </label>
                      </div>

                      <div v-if="paymentMethod === 'card'">
                        <div class="mb-3">
                          <label for="cardNumber" class="form-label"
                            >Card Number</label
                          >
                          <input
                            type="text"
                            id="cardNumber"
                            v-model="cardNumber"
                            class="form-control"
                            placeholder="Enter card number"
                            required
                          />
                        </div>

                        <div class="row">
                          <div class="col-6 mb-3">
                            <label for="expiry" class="form-label"
                              >Expiry (MM/YY)</label
                            >
                            <input
                              type="text"
                              id="expiry"
                              v-model="expiry"
                              class="form-control"
                              placeholder="MM/YY"
                              required
                            />
                          </div>
                          <div class="col-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input
                              type="text"
                              id="cvv"
                              v-model="cvv"
                              class="form-control"
                              placeholder="CVV"
                              required
                            />
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="text-center mb-4">
                      <h5 class="fw-bold">
                        Total Amount: {{ $page.props.currency }} {{ price }}
                      </h5>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary w-100 py-3">
                        Pay Now
                      </button>
                    </div>
                  </form>

                  <!-- Secure Payment Info -->
                  <div class="text-center mt-4">
                    <p class="mb-2">
                      Your payment is securely processed by DPO GROUP
                    </p>
                    <img
                      src="https://s3-eu-west-1.amazonaws.com/tpd/logos/5e33f602878b550001034ad8/0x0.png"
                      alt="DPO Group Logo"
                      class="dpo-logo"
                    />
                  </div>
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
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  subscription: String,
  price: Number,
});

const paymentMethod = ref(null);
const mpesaNumber = ref("");
const cardNumber = ref("");
const expiry = ref("");
const cvv = ref("");

const form = useForm({
  subscription: props.subscription,
  price: props.price,
  paymentMethod: "",
  mpesaNumber: "",
  cardDetails: {
    cardNumber: "",
    expiry: "",
    cvv: "",
  },
});

const submitForm = () => {
  form.paymentMethod = paymentMethod.value;
  form.mpesaNumber = mpesaNumber.value;
  form.cardDetails = {
    cardNumber: cardNumber.value,
    expiry: expiry.value,
    cvv: cvv.value,
  };

  form.post("/checkout-confirmation", { forceFormData: true });
};
</script>

<style>
.dpo-logo {
  width: 120px;
  height: auto;
}

.form-check-label {
  font-weight: 700;
  font-size: 1.1rem;
}

.payment-option {
  padding: 0.5rem 0;
}

.btn-primary {
  font-size: 1.1rem;
  font-weight: 600;
}

.form-check-input:checked {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.form-label {
  font-weight: 500;
}

input::placeholder {
  font-size: 0.9rem;
  color: #adb5bd;
}
</style>
