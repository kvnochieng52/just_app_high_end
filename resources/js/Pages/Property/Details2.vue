<template>
  <Head :title="propertyDetails.property_title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-12">
          <FsLightbox
            :toggler="toggler"
            :slide="slide"
            :sources="sources"
            :thumbs="thumbs"
          />

          <div class="arrow-ribbon2 bg-secondary">
            KSH {{ propertyDetails.amount }}
          </div>
          <Carousel
            :images="images"
            :auto-slide-interval="20000"
            :show-progress-bar="true"
            @click="openLightboxOnSlide(1)"
          ></Carousel>

          <div style="clear: both"></div>
          <div class="card overflow-hidden mt-5">
            <div class="card-body">
              <div class="item-det mb-4">
                <a href="" class="text-dark">
                  <h3 class="">{{ propertyDetails.property_title }}</h3>
                </a>
                <ul class="d-flex">
                  <li class="me-5">
                    <a href="" class="icons"
                      ><i class="icon icon-home text-muted me-1"></i>
                      {{ propertyDetails.property_type_name }}</a
                    >
                  </li>
                  <li class="me-5">
                    <a href="" class="icons"
                      ><i class="icon icon-location-pin text-muted me-1"></i>
                      {{ propertyDetails.town_name }},
                      {{ propertyDetails.sub_region_name }}</a
                    >
                  </li>

                  <li class="me-5">
                    <a href="" class="icons"
                      ><i class="icon icon-calendar text-muted me-1"></i> 30 Min
                      ago</a
                    >
                  </li>
                </ul>

                <div class="mt-5">
                  <div
                    class=""
                    style="
                      background-color: #f6f6f6;
                      padding-top: 10px;
                      padding-bottom: 8px;
                      border-radius: 8px;
                      border: 1px solid #e3e3e3;
                    "
                  >
                    <div class="row">
                      <div class="col-md-3 text-center">
                        <div class="counter-status md-mb-0">
                          <div
                            class="counter-icon"
                            style="border-color: #cbbe07"
                          >
                            <i class="fa fa-star text-muted me-1 text-gold"></i>
                          </div>
                          <h6>
                            <strong
                              >Condition:
                              {{ propertyDetails.condition_name }}</strong
                            >
                          </h6>
                          <!-- <h2 class="counter mb-0 font-weight-bold">2</h2> -->
                        </div>
                      </div>

                      <div class="col-md-3 text-center">
                        <div class="counter-status md-mb-0">
                          <div
                            class="counter-icon"
                            style="border-color: #cbbe07"
                          >
                            <i class="fa fa-bed text-muted me-1 text-gold"></i>
                          </div>
                          <h6>
                            <strong
                              >{{ propertyDetails.bedrooms }} Bedrooms</strong
                            >
                          </h6>
                          <!-- <h2 class="counter mb-0 font-weight-bold">2</h2> -->
                        </div>
                      </div>

                      <div class="col-md-3 text-center">
                        <div class="counter-status md-mb-0">
                          <div
                            class="counter-icon"
                            style="border-color: #cbbe07"
                          >
                            <i class="fa fa-car text-muted me-1 text-gold"></i>
                          </div>
                          <h6>
                            <strong
                              >{{ propertyDetails.parking_spaces }} Parking
                              Spaces</strong
                            >
                          </h6>
                        </div>
                      </div>

                      <div class="col-md-3 text-center">
                        <div class="counter-status md-mb-0">
                          <div
                            class="counter-icon"
                            style="border-color: #cbbe07"
                          >
                            <i
                              class="fa fa-briefcase text-muted me-1 text-gold"
                            ></i>
                          </div>
                          <h6>
                            <strong>{{ propertyDetails.furnish_name }}</strong>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <p style="white-space: pre-line">
                  {{ propertyDetails.property_description }}
                </p>
              </div>

              <hr />

              <h4 class="mb-4">Specifications</h4>
              <template
                v-for="(feature, featureKey) in propertySelectedFeatures"
                :key="featureKey"
              >
                <h5>{{ feature.feature_group_name }}</h5>

                <div
                  class="row"
                  style="padding-left: 20px; padding-bottom: 15px"
                >
                  <div
                    class="col-xl-4 col-md-12"
                    v-for="(
                      selectedFeature, selectedFeatureKey
                    ) in feature.features"
                    :key="selectedFeatureKey"
                  >
                    <i class="fa fa-check w-5"></i
                    >{{ selectedFeature.feature_name }}
                  </div>
                </div>
              </template>

              <div class="row">
                <div
                  class="d-flex justify-content-evenly item-user-icons"
                  style="
                    margin-bottom: 20px;
                    background-color: #f5f5f5;
                    border: 1px solid #e3e3e3;
                    padding: 10px;
                    border-radius: 5px;
                  "
                >
                  <span><strong>Agent/Owner Links: </strong></span>

                  <a
                    :href="propertyDetails.website"
                    v-if="propertyDetails.website"
                    target="_blank"
                  >
                    <span> <i class="fa fa-globe"></i> Website</span>
                  </a>
                  <a
                    :href="propertyDetails.facebook"
                    v-if="propertyDetails.facebook"
                    target="_blank"
                    class=""
                  >
                    <span
                      ><i class="fa fa-facebook facebook-bg"></i> Facebook</span
                    >
                  </a>

                  <a
                    :href="propertyDetails.tiktok"
                    v-if="propertyDetails.tiktok"
                    target="_blank"
                  >
                    <span><i class="fa fa-tiktok"></i>Tiktok</span>
                  </a>
                  <a
                    :href="propertyDetails.instagram"
                    v-if="propertyDetails.instagram"
                    target="_blank"
                  >
                    <span><i class="fa fa-instagram"></i> Instagram</span>
                  </a>
                  <a
                    :href="propertyDetails.twitter"
                    v-if="propertyDetails.twitter"
                    target="_blank"
                  >
                    <span><i class="fa fa-twitter twitter-bg"></i>Twitter</span>
                  </a>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="icons">
                <a href="javascript:void(0);" class="btn btn-info icons btn-sm"
                  ><i class="icon icon-share me-1"></i> Share Ad</a
                >
                <a
                  href="javascript:void(0);"
                  class="btn btn-danger icons btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#report"
                  ><i class="icon icon-exclamation me-1"></i> Report Abuse</a
                >
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-12">
          <div class="card">
            <div class="card-body item-user">
              <div class="profile-pic mb-0">
                <img
                  :src="
                    propertyDetails.created_by_avatar
                      ? propertyDetails.created_by_avatar
                      : '/images/no_user.png'
                  "
                  class="brround avatar-xxl"
                  alt="user"
                />

                <div class="">
                  <a href="" class="text-dark">
                    <h4 class="mt-3 mb-1 font-weight-semibold">
                      {{ propertyDetails.created_by_name }}
                    </h4>
                  </a>
                  <p class="mb-0">{{ propertyDetails.company_name }}</p>
                  <span class="text-muted"
                    >Member since
                    {{ dateFormat(propertyDetails.user_registered_date) }}</span
                  >
                </div>
              </div>
            </div>
            <div class="card-body item-user">
              <div>
                <button class="btn btn-primary btn-block" @click="contactAgent">
                  <i class="fa fa-envelope"></i
                  ><strong> CONTACT THE AGENT/ OWNER</strong>
                </button>

                <div class="contacts_show mt-5" v-if="contactToggle">
                  <h6>
                    <span class="font-weight-semibold"
                      ><i class="fa fa-phone me-2 mb-2"></i></span
                    ><a href="" class="text-body">
                      <strong>
                        {{ propertyDetails.created_by_telephone }}</strong
                      >
                    </a>
                  </h6>

                  <div class="form">
                    <p>OR Leave a Message</p>

                    <form @submit.prevent="sendMessage">
                      <div class="contact-form">
                        <div class="form-group">
                          <input
                            type="text"
                            name="txtName"
                            v-model="txtName"
                            class="form-control"
                            placeholder="Full Names*"
                          />
                        </div>
                        <div class="form-group">
                          <input
                            type="text"
                            name="txtPhone"
                            v-model="txtphone"
                            class="form-control"
                            placeholder="Phone Number*"
                          />
                        </div>
                        <div class="form-group">
                          <input
                            type="text"
                            name="txtEmail"
                            v-model="txtEmail"
                            class="form-control"
                            placeholder="Email*"
                          />
                        </div>

                        <div class="form-group">
                          <textarea
                            name="txtMsg"
                            v-model="txtMsg"
                            class="form-control"
                            placeholder="Message *"
                            style="width: 100%; height: 100px"
                          >
                          </textarea>
                        </div>
                        <div class="form-group">
                          <input
                            type="submit"
                            name="btnSubmit"
                            class="btn btn-primary btn-sm"
                            value="Send Message"
                          />
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- <div class="item-user-icons mt-4">
                            <a
                              href=""
                              class="facebook-bg mt-0"
                              ><i class="fa fa-facebook"></i
                            ></a>
                            <a href="" class="twitter-bg"
                              ><i class="fa fa-twitter"></i
                            ></a>
                            <a href="" class="google-bg"
                              ><i class="fa fa-google"></i
                            ></a>
                            <a href="" class="dribbble-bg"
                              ><i class="fa fa-dribbble"></i
                            ></a>
                          </div> -->
                </div>

                <div class="mt-3">
                  <button
                    type="button"
                    class="btn btn-danger btn-block"
                    @click="showModal"
                  >
                    <i class="fa fa-envelope"></i> SCHEDULE A TOUR
                  </button>

                  <!-- Include the modal component -->
                  <ScheduleTourModal
                    ref="scheduleTourModal"
                    :propertyDetails="propertyDetails"
                  />
                </div>
              </div>

              <div
                v-if="propertyDetails.video_thumb"
                class="video_view"
                style="
                  border-top: 1px solid #ccc;
                  padding-top: 15px;
                  margin-top: 10px;
                "
              >
                <div
                  class="mainDiv"
                  @click="openLightboxOnSlide(lightShowImageCount)"
                >
                  <img :src="propertyDetails.video_thumb" />
                  <div class="subdiv">
                    <h1><i class="fa fa-play-circle"></i></h1>
                    <p><strong>Watch property Video</strong></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-header">
              <a
                @click="showLoanDiv"
                href=""
                class="btn btn-primary btn-block btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#contact"
                ><i class="fa fa-money"></i> Morgage Calculator</a
              >
            </div>

            <template v-if="showLoanCalc">
              <div class="card-body pt-0">
                <div class="form wrapper wrapper2">
                  <form @submit.prevent="calculateLoan">
                    <div class="contact-form">
                      <Slider
                        v-model="example4.value"
                        v-bind="example4"
                        :min="100000"
                        :max="50000000"
                        :step="100000"
                        class="mb-5"
                      />
                      <div class="form-group">
                        <label for="profile">Amount (KSH)</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model="example4.value"
                          required="true"
                          style="font-size: 16px"
                        />
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="profile">Interest (%)</label>
                            <input
                              required="true"
                              type="number"
                              class="form-control"
                              v-model="interest"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="profile">Length of loan (years)</label>
                            <input
                              type="number"
                              class="form-control"
                              v-model="loanYears"
                              required="true"
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <input
                          type="submit"
                          name="btnSubmit"
                          class="btn btn-sm btn-primary"
                          value="Calculate Loan"
                        />
                      </div>

                      <div
                        class="alert alert-success"
                        v-if="showLoanResult"
                        style="padding: 10px"
                      >
                        <p style="font-size: 14px; margin-bottom: 5px">
                          Monthly Payment Will Be:
                        </p>
                        <h4>KSH {{ monthlyPaymentResult }}</h4>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </template>
          </div>
          <!-- <div class="card overflow-hidden">
            <div class="card-body"></div>
          </div> -->
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import FsLightbox from "fslightbox-vue/v3";
import Carousel from "../Carousel/Carousel.vue";
import { Head } from "@inertiajs/inertia-vue3";
import "@vueform/slider/themes/default.css";
import Slider from "@vueform/slider";
import SkeletonLoaderSingle from "../../Shared/SkeletonLoaderSingle.vue";
import axios from "axios";
import ScheduleTourModal from "./ScheduleTourModal.vue";

export default {
  props: {
    propertyDetails: Object,
    propertyImages: Object,
    lightShowImages: Object,
    propertySelectedFeatures: Object,
    lightShowImageCount: Number,
    appUrl: String,
    metaDetails: Array,
  },
  components: {
    FsLightbox,
    Carousel,
    Head,
    Slider,
    SkeletonLoaderSingle,
    ScheduleTourModal,
  },
  data() {
    return {
      example4: {
        value: 100000,
        format: {
          prefix: "KSH ",
          thousand: ",",
          decimals: 0,
        },
      },
      contactToggle: false,
      toggler: false,
      slide: 1,
      sliderValue: 1000000,
      sources: this.lightShowImages,
      thumbs: this.lightShowImages,
      images: this.propertyImages,
      txtMsg: "I am interested in " + this.propertyDetails.property_title,
      txtName: "",
      txtphone: "",
      txtEmail: "",
      loanAmount: this.sliderValue,
      interest: 16,
      loanYears: 1,
      monthlyPaymentResult: 0,
      showLoanCalc: false,
      showLoanResult: false,
      showImagesCaraousel: false,
    };
  },

  methods: {
    showModal() {
      this.$refs.scheduleTourModal.showModal();
    },
    openLightboxOnSlide(number) {
      this.slide = number;
      this.toggler = !this.toggler;
    },
    showLoanDiv() {
      this.showLoanCalc = !this.showLoanCalc;
    },
    monthlyPayment(p, n, i) {
      return (p * i * Math.pow(1 + i, n)) / (Math.pow(1 + i, n) - 1);
    },
    dateFormat(date) {
      let objectDate = new Date(date);
      let day = objectDate.getDate();
      const month = objectDate.toLocaleString("default", { month: "long" });
      let year = objectDate.getFullYear();

      return month + " " + year;
    },
    contactAgent() {
      this.contactToggle = !this.contactToggle;
      if (this.contactToggle) {
        const pdata = {
          propertyID: this.propertyDetails.id,
          userID: this.propertyDetails.created_by,
        };

        axios
          .post("/store-lead", pdata)
          .then((response) => {
            console.log("Response data:", response.data.data);
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }
    },
    calculateLoan() {
      var M; // monthly mortgage payment
      var P = this.example4.value; // principle / initial amount borrowed
      var I = this.interest / 100 / 12; // monthly interest rate
      var N = this.loanYears * 12; // number of payments months

      // monthly mortgage payment
      M = this.monthlyPayment(P, N, I);
      this.monthlyPaymentResult = Math.trunc(M).toLocaleString();
      this.showLoanResult = true;
    },
    sendMessage() {
      const pdata = {
        name: this.txtName,
        telephone: this.txtphone,
        email: this.txtEmail,
        message: this.txtMsg,
        propertyID: this.propertyDetails.id,
        userID: this.propertyDetails.created_by,
      };

      axios
        .post("/send-message", pdata)
        .then((response) => {
          console.log("Response data:", response.data.data);
          alert("message sent successfully");
          this.txtName = "";
          this.txtphone = "";
          this.txtEmail = "";
          this.txtMsg = "";
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
  mounted() {
    // this.fetchImages();
  },
};
</script>



<style scoped>
.card-carousel .card-img > img {
  /* width: 100% !important;
  height: 100px !important; */
}

.item-card .item-card-desc .item-card-text span {
  position: relative;
  top: 90%;
  text-align: left;
  color: #fff;
  z-index: 2;
  margin-left: 8px;
  background-color: rgba(23, 23, 24, 0.7);
  width: 55px;
  padding: 3px;
  border-radius: 5px;
}

.item-card {
  cursor: pointer;
}

.contact-form {
  background: #fff;
  margin-top: 10%;
  margin-bottom: 5%;
  width: 100%;
}
.contact-form .form-control {
  border-radius: 1rem;
}
.contact-image {
  text-align: center;
}
.contact-image img {
  border-radius: 6rem;
  width: 11%;
  margin-top: -3%;
  transform: rotate(29deg);
}
.contact-form form {
  padding: 14%;
}
.contact-form form .row {
  margin-bottom: -7%;
}
.contact-form h3 {
  margin-bottom: 8%;
  margin-top: -10%;
  text-align: center;
  color: #0062cc;
}
.contact-form .btnContact {
  width: 50%;
  border: none;
  border-radius: 1rem;
  padding: 1.5%;
  background: #0dcaf0;
  font-weight: 600;
  color: #fff;
  cursor: pointer;
}
.btnContactSubmit {
  width: 50%;
  border-radius: 1rem;
  padding: 1.5%;
  color: #fff;
  background-color: #0062cc;
  border: none;
  cursor: pointer;
}

.mainDiv {
  position: relative;
  border-radius: 5px;
  cursor: pointer;
}
.subdiv {
  position: absolute;
  width: 100%;
  background: rgba(0, 0, 0, 0.5);
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  color: #fff;
  border-radius: 5px;
}

.subdiv h1 {
  position: relative;
  top: 20%;
  font-size: 80px;
}

.subdiv p {
  position: relative;
  top: 10%;
}
</style>

