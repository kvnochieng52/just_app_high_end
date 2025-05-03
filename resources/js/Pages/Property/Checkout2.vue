<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="w-100 p-0">
                <div class="wrapper bg-white p-4 p-md-5 shadow rounded-3">
                  <div class="text-center mb-4">
                    <h4>COMPLETE PAYMENT</h4>
                    <div class="divider-center"></div>
                  </div>

                  <!-- Subscription and Price Display -->
                  <div
                    class="pricing-card mb-4 text-center p-4 bg-light rounded-3"
                  >
                    <h5 class="fw-bold mb-2">
                      Selected Plan:
                      <span class="text-purple text-uppercase">{{
                        subscriptionDetails.sbscription_title
                      }}</span>
                    </h5>
                    <h3 class="fw-bold text-purple mb-0">
                      {{ $page.props.currency }}
                      {{ subscriptionDetails.amount }}
                    </h3>
                  </div>

                  <!-- Payment Form -->
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <div class="mb-4">
                      <h5 class="fw-semibold mb-3 border-bottom pb-2">
                        Select Payment Method
                      </h5>

                      <div
                        v-if="errors.paymentMethod"
                        class="alert alert-danger mb-3"
                      >
                        {{ errors.paymentMethod }}
                      </div>

                      <div class="payment-methods">
                        <!-- M-Pesa Option -->
                        <div class="form-check mb-3">
                          <input
                            class="form-check-input d-none"
                            type="radio"
                            id="mobileMoney"
                            value="mobile_money"
                            v-model="form.paymentMethod"
                          />
                          <label
                            class="form-check-label w-100 m-0"
                            for="mobileMoney"
                          >
                            <div
                              class="payment-method-card d-flex align-items-center"
                              :class="{
                                active: form.paymentMethod === 'mobile_money',
                              }"
                            >
                              <img
                                src="/images/payments/mpesa.png"
                                alt="M-Pesa"
                                class="payment-icon me-3"
                              />
                              <span class="flex-grow-1 text-start"
                                >M-Pesa Mobile Money</span
                              >
                              <div class="radio-indicator">
                                <div class="radio-circle"></div>
                              </div>
                            </div>
                          </label>
                        </div>

                        <!-- M-Pesa Input -->
                        <div
                          v-if="form.paymentMethod === 'mobile_money'"
                          class="mb-3 ps-4"
                        >
                          <label for="mpesaNumber" class="form-label fw-medium"
                            >M-Pesa Mobile Number</label
                          >
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="fa fa-mobile"></i>
                            </span>
                            <input
                              type="tel"
                              id="mpesaNumber"
                              v-model="form.mpesaNumber"
                              class="form-control form-control-lg"
                              :class="{ 'is-invalid': errors.mpesaNumber }"
                              placeholder="e.g. 0712345678"
                            />
                          </div>
                          <small class="text-muted"
                            >You'll receive a payment request on your
                            phone</small
                          >
                          <div
                            v-if="errors.mpesaNumber"
                            class="invalid-feedback d-block"
                          >
                            {{ errors.mpesaNumber }}
                          </div>
                        </div>

                        <!-- Airtel Money Option -->
                        <!-- <div class="form-check mb-3">
                          <input
                            class="form-check-input d-none"
                            type="radio"
                            id="airtelMoney"
                            value="airtel_money"
                            v-model="form.paymentMethod"
                          />
                          <label
                            class="form-check-label w-100 m-0"
                            for="airtelMoney"
                          >
                            <div
                              class="payment-method-card d-flex align-items-center"
                              :class="{
                                active: form.paymentMethod === 'airtel_money',
                              }"
                            >
                              <img
                                src="/images/payments/airtel.png"
                                alt="Airtel Money"
                                class="payment-icon me-3"
                              />
                              <span class="flex-grow-1 text-start"
                                >Airtel Money</span
                              >
                              <div class="radio-indicator">
                                <div class="radio-circle"></div>
                              </div>
                            </div>
                          </label>
                        </div> -->

                        <!-- Airtel Money Input -->
                        <!-- <div
                          v-if="form.paymentMethod === 'airtel_money'"
                          class="mb-3 ps-4"
                        >
                          <label for="airtelNumber" class="form-label fw-medium"
                            >Airtel Money Number</label
                          >
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="fa fa-mobile"></i>
                            </span>
                            <input
                              type="tel"
                              id="airtelNumber"
                              v-model="form.airtelNumber"
                              class="form-control form-control-lg"
                              :class="{ 'is-invalid': errors.airtelNumber }"
                              placeholder="e.g. 0712345678"
                            />
                          </div>
                          <small class="text-muted"
                            >You'll receive a payment request on your
                            phone</small
                          >
                          <div
                            v-if="errors.airtelNumber"
                            class="invalid-feedback d-block"
                          >
                            {{ errors.airtelNumber }}
                          </div>
                        </div> -->

                        <!-- Card Payment Option -->
                        <div class="form-check mb-3">
                          <input
                            class="form-check-input d-none"
                            type="radio"
                            id="cardPayment"
                            value="card"
                            v-model="form.paymentMethod"
                          />
                          <label
                            class="form-check-label w-100 m-0"
                            for="cardPayment"
                          >
                            <div
                              class="payment-method-card d-flex align-items-center"
                              :class="{ active: form.paymentMethod === 'card' }"
                            >
                              <img
                                src="/images/payments/card.png"
                                alt="Credit Card"
                                class="payment-icon me-3"
                              />
                              <span class="flex-grow-1 text-start"
                                >Credit/Debit Card</span
                              >
                              <div class="radio-indicator">
                                <div class="radio-circle"></div>
                              </div>
                            </div>
                          </label>
                        </div>

                        <!-- Card Payment Inputs -->
                        <div
                          v-if="form.paymentMethod === 'card'"
                          class="mb-3 ps-4"
                        >
                          <div class="row g-3">
                            <div class="col-md-6 mb-3">
                              <label for="expiry" class="form-label fw-medium"
                                >First Name</label
                              >
                              <div class="input-group">
                                <span class="input-group-text bg-light">
                                  <i class="fa fa-user"></i>
                                </span>
                                <input
                                  type="text"
                                  id="firstName"
                                  v-model="form.cardDetails.firstName"
                                  class="form-control form-control-lg"
                                  :class="{ 'is-invalid': errors.firstName }"
                                  placeholder="First Name"
                                />
                              </div>
                              <div
                                v-if="errors.firstName"
                                class="invalid-feedback d-block"
                              >
                                {{ errors.firstName }}
                              </div>
                            </div>

                            <div class="col-md-6 mb-3">
                              <label for="expiry" class="form-label fw-medium"
                                >Last Name</label
                              >
                              <div class="input-group">
                                <span class="input-group-text bg-light">
                                  <i class="fa fa-user"></i>
                                </span>
                                <input
                                  type="text"
                                  id="lastName"
                                  v-model="form.cardDetails.lastName"
                                  class="form-control form-control-lg"
                                  :class="{ 'is-invalid': errors.lastName }"
                                  placeholder="Last Name"
                                />
                              </div>
                              <div
                                v-if="errors.lastName"
                                class="invalid-feedback d-block"
                              >
                                {{ errors.lastName }}
                              </div>
                            </div>
                          </div>

                          <div class="mb-3">
                            <label for="cardNumber" class="form-label fw-medium"
                              >Card Number</label
                            >
                            <div class="input-group">
                              <span class="input-group-text bg-light">
                                <i class="fa fa-credit-card"></i>
                              </span>
                              <input
                                type="text"
                                id="cardNumber"
                                v-model="form.cardDetails.cardNumber"
                                class="form-control form-control-lg"
                                :class="{ 'is-invalid': errors.cardNumber }"
                                placeholder="1234 5678 9012 3456"
                              />
                            </div>
                            <div
                              v-if="errors.cardNumber"
                              class="invalid-feedback d-block"
                            >
                              {{ errors.cardNumber }}
                            </div>
                          </div>

                          <div class="row g-3">
                            <div class="col-md-6 mb-3">
                              <label for="expiry" class="form-label fw-medium"
                                >Expiry Date</label
                              >
                              <div class="input-group">
                                <span class="input-group-text bg-light">
                                  <i class="fa fa-calendar"></i>
                                </span>
                                <input
                                  type="text"
                                  id="expiry"
                                  v-model="form.cardDetails.expiry"
                                  class="form-control form-control-lg"
                                  :class="{ 'is-invalid': errors.expiry }"
                                  placeholder="MM/YY"
                                />
                              </div>
                              <div
                                v-if="errors.expiry"
                                class="invalid-feedback d-block"
                              >
                                {{ errors.expiry }}
                              </div>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label for="cvv" class="form-label fw-medium"
                                >Security Code</label
                              >
                              <div class="input-group">
                                <span class="input-group-text bg-light">
                                  <i class="fa fa-lock"></i>
                                </span>
                                <input
                                  type="text"
                                  id="cvv"
                                  v-model="form.cardDetails.cvv"
                                  class="form-control form-control-lg"
                                  :class="{ 'is-invalid': errors.cvv }"
                                  placeholder="CVV"
                                />
                              </div>
                              <div
                                v-if="errors.cvv"
                                class="invalid-feedback d-block"
                              >
                                {{ errors.cvv }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="total-amount p-4 mb-4 bg-light rounded-3">
                      <div
                        class="d-flex justify-content-between align-items-center"
                      >
                        <h5 class="fw-bold mb-0">Total Amount:</h5>
                        <h4 class="fw-bold text-purple mb-0">
                          {{ $page.props.currency }}
                          {{ subscriptionDetails.amount }}
                        </h4>
                      </div>
                    </div>

                    <div class="text-center">
                      <button
                        type="submit"
                        class="btn btn-purple btn-lg w-100 py-3 fw-bold"
                        :disabled="isProcessing"
                      >
                        <template v-if="isProcessing">
                          <span
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                          ></span>
                          Processing Payment...
                        </template>
                        <template v-else-if="isCheckingStatus">
                          <span
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                          ></span>
                          Verifying Payment ({{ statusCheckCountdown }}s)...
                        </template>
                        <template v-else>
                          <i class="fa fa-lock me-2"></i>Pay Securely Now
                        </template>
                      </button>
                    </div>
                  </form>

                  <!-- Secure Payment Info -->
                  <div class="secure-payment text-center mt-4 pt-3 border-top">
                    <div
                      class="d-flex align-items-center justify-content-center mb-3"
                    >
                      <i class="fa fa-shield text-success me-2"></i>
                      <p class="mb-0 fw-medium">
                        Your payment is securely processed by
                      </p>
                    </div>
                    <img
                      src="https://s3-eu-west-1.amazonaws.com/tpd/logos/5e33f602878b550001034ad8/0x0.png"
                      alt="DPO Group Logo"
                      class="dpo-logo img-fluid"
                    />
                    <div class="payment-badges mt-3">
                      <img
                        src="/images/payments/card.png"
                        alt="Visa"
                        class="payment-badge"
                      />
                      <img
                        src="/images/payments/mpesa.png"
                        alt="M-Pesa"
                        class="payment-badge"
                      />
                      <img
                        src="/images/payments/airtel.png"
                        alt="Airtel Money"
                        class="payment-badge"
                      />
                    </div>
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
import { ref, computed, onUnmounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

const props = defineProps({
  subscription: String,
  price: Number,
  subscriptionDetails: Object,
  propertyID: Number,
});

const form = useForm({
  subscription: props.subscriptionDetails.id,
  propertyID: props.propertyID,
  paymentMethod: "",
  mpesaNumber: "",
  airtelNumber: "",
  cardDetails: {
    firstName: "",
    lastName: "",
    cardNumber: "",
    expiry: "",
    cvv: "",
  },
});

const errors = ref({
  paymentMethod: null,
  mpesaNumber: null,
  airtelNumber: null,
  cardNumber: null,
  expiry: null,
  cvv: null,
});

const isProcessing = ref(false);
const isCheckingStatus = ref(false);
const statusCheckCountdown = ref(0);
const statusCheckInterval = ref(null);
const transactionReference = ref(null);

const validateMpesaNumber = (number) => {
  const regex = /^07\d{8}$/;
  return regex.test(number);
};

const validateAirtelNumber = (number) => {
  const regex = /^0(7|1)\d{8}$/;
  return regex.test(number);
};

const validateCardNumber = (number) => {
  const cleaned = number.replace(/\s+/g, "");
  return /^\d{16}$/.test(cleaned);
};

const validateExpiry = (expiry) => {
  if (!/^\d{2}\/\d{2}$/.test(expiry)) return false;
  const [month, year] = expiry.split("/");
  const now = new Date();
  const currentYear = now.getFullYear() % 100;
  const currentMonth = now.getMonth() + 1;
  if (year < currentYear) return false;
  if (year == currentYear && month < currentMonth) return false;
  if (month < 1 || month > 12) return false;
  return true;
};

const validateCVV = (cvv) => {
  return /^\d{3,4}$/.test(cvv);
};

const validateForm = () => {
  errors.value = {
    paymentMethod: null,
    mpesaNumber: null,
    airtelNumber: null,
    cardNumber: null,
    expiry: null,
    cvv: null,
  };

  let isValid = true;

  if (!form.paymentMethod) {
    errors.value.paymentMethod = "Please select a payment method";
    isValid = false;
  }

  if (form.paymentMethod === "mobile_money") {
    if (!form.mpesaNumber) {
      errors.value.mpesaNumber = "M-Pesa number is required";
      isValid = false;
    } else if (!validateMpesaNumber(form.mpesaNumber)) {
      errors.value.mpesaNumber =
        "Please enter a valid M-Pesa number (format: 2547XXXXXXXX)";
      isValid = false;
    }
  } else if (form.paymentMethod === "airtel_money") {
    if (!form.airtelNumber) {
      errors.value.airtelNumber = "Airtel Money number is required";
      isValid = false;
    } else if (!validateAirtelNumber(form.airtelNumber)) {
      errors.value.airtelNumber =
        "Please enter a valid Airtel Money number (format: 2547XXXXXXXX or 2541XXXXXXXX)";
      isValid = false;
    }
  } else if (form.paymentMethod === "card") {
    if (!form.cardDetails.cardNumber) {
      errors.value.cardNumber = "Card number is required";
      isValid = false;
    } else if (!validateCardNumber(form.cardDetails.cardNumber)) {
      errors.value.cardNumber = "Please enter a valid 16-digit card number";
      isValid = false;
    }

    if (!form.cardDetails.expiry) {
      errors.value.expiry = "Expiry date is required";
      isValid = false;
    } else if (!validateExpiry(form.cardDetails.expiry)) {
      errors.value.expiry = "Please enter a valid expiry date (MM/YY)";
      isValid = false;
    }

    if (!form.cardDetails.cvv) {
      errors.value.cvv = "CVV is required";
      isValid = false;
    } else if (!validateCVV(form.cardDetails.cvv)) {
      errors.value.cvv = "Please enter a valid 3 or 4 digit CVV";
      isValid = false;
    }

    if (!form.cardDetails.firstName) {
      errors.value.firstName = "First Name is required";
      isValid = false;
    }

    if (!form.cardDetails.lastName) {
      errors.value.lastName = "Last Name is required";
      isValid = false;
    }
  }

  return isValid;
};

const checkTransactionStatus = async (reference) => {
  isCheckingStatus.value = true;
  statusCheckCountdown.value = 5; // Start countdown from 5 seconds

  // Start countdown timer
  statusCheckInterval.value = setInterval(() => {
    if (statusCheckCountdown.value > 0) {
      statusCheckCountdown.value--;
    }
  }, 1000);

  try {
    // Wait for 5 seconds before making the first check
    await new Promise((resolve) => setTimeout(resolve, 5000));

    const response = await axios.post("/check-payment-status", {
      reference: reference,
    });

    if (response.data.status === "success") {
      clearInterval(statusCheckInterval.value);
      // Handle successful payment
      window.location.href = "/payment/success?reference=" + reference;
    } else {
      // If not successful, check again after 10 seconds
      setTimeout(() => checkTransactionStatus(reference), 10000);
    }
  } catch (error) {
    console.error("Error checking payment status:", error);
    // Retry after 10 seconds if there's an error
    setTimeout(() => checkTransactionStatus(reference), 10000);
  }
};

const submitForm = () => {
  if (!validateForm()) {
    return;
  }

  isProcessing.value = true;

  form.post("/process-payment", {
    forceFormData: true,
    onError: (errors) => {
      isProcessing.value = false;
    },
  });
};

// const submitForm = () => {
//   if (!validateForm()) {
//     return;
//   }

//   isProcessing.value = true;

//   form.post("/process-payment", {
//     forceFormData: true,
//     onSuccess: (response) => {
//       if (response.props.transactionReference) {
//         transactionReference.value = response.props.transactionReference;
//         checkTransactionStatus(response.props.transactionReference);
//       }
//     },
//     onError: (errors) => {
//       isProcessing.value = false;
//     },
//     onFinish: () => {
//       // This will run after success or error
//       if (!transactionReference.value) {
//         isProcessing.value = false;
//       }
//     },
//   });
// };

// Clean up interval when component unmounts
onUnmounted(() => {
  if (statusCheckInterval.value) {
    clearInterval(statusCheckInterval.value);
  }
});
</script>

<style scoped>
.sptb {
  padding: 80px 0;
}

.wrapper {
  border: 1px solid rgba(0, 0, 0, 0.1);
  max-width: 800px;
  margin: 0 auto;
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

.pricing-card {
  border-left: 4px solid #6a0dad;
  background: linear-gradient(to right, #f8f9fa, #fff);
}

.payment-methods {
  border-radius: 10px;
}

.payment-method-card {
  padding: 15px 20px;
  border: 2px solid #dee2e6;
  border-radius: 8px;
  transition: all 0.3s ease;
  cursor: pointer;
  background-color: #fff;
  min-height: 70px;
}

.payment-method-card:hover {
  border-color: #6a0dad;
  background-color: rgba(106, 13, 173, 0.05);
}

.payment-method-card.active {
  border-color: #6a0dad;
  background-color: rgba(106, 13, 173, 0.1);
  box-shadow: 0 0 0 1px #6a0dad;
}

.payment-method-card.active .radio-circle {
  background-color: #6a0dad;
  border-color: #6a0dad;
}

.payment-icon {
  width: 40px;
  height: 30px;
  object-fit: contain;
}

.radio-indicator {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.radio-circle {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 2px solid #dee2e6;
  transition: all 0.3s ease;
}

.form-control-lg {
  padding: 12px 15px;
}

.input-group-text {
  min-width: 45px;
  justify-content: center;
  padding: 0 15px;
}

.btn-purple {
  background-color: #6a0dad;
  border: none;
  color: white;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}

.btn-purple:hover {
  background-color: #5a0b9d;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(106, 13, 173, 0.3);
}

.dpo-logo {
  width: 120px;
  height: auto;
  /* filter: grayscale(100%); */
  opacity: 0.8;
  transition: all 0.3s ease;
}

.dpo-logo:hover {
  filter: grayscale(0%);
  opacity: 1;
}

.payment-badges {
  display: flex;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}

.payment-badge {
  width: 50px;
  height: 30px;
  object-fit: contain;
  filter: grayscale(100%);
  opacity: 0.7;
  transition: all 0.3s ease;
}

.payment-badge:hover {
  filter: grayscale(0%);
  opacity: 1;
}

.total-amount {
  background: linear-gradient(to right, #f8f9fa, #fff);
  border-left: 4px solid #6a0dad;
}

.secure-payment {
  color: #6c757d;
}

/* Consistent input spacing */
.mb-3.ps-4 {
  padding-left: 1.5rem;
  margin-bottom: 1.5rem !important;
}

@media (max-width: 768px) {
  .sptb {
    padding: 50px 0;
  }

  .wrapper {
    padding: 1.5rem !important;
  }

  .payment-method-card {
    padding: 12px 15px;
    min-height: 60px;
  }

  .payment-icon {
    width: 35px;
  }

  .mb-3.ps-4 {
    padding-left: 1rem;
  }

  .btn-purple {
    padding: 12px;
  }
}
</style>