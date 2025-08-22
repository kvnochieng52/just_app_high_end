<template>
  <div
    class="modal fade"
    ref="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Schedule a tour</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <!-- Progress Indicator -->
          <div v-if="isSubmitting" class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>

          <!-- Success Message -->
          <div v-if="isSubmitted" class="text-center">
            <div class="alert alert-success" role="alert">
              Form submitted successfully!
            </div>
            <button type="button" class="btn btn-success" @click="hideModal">
              Close
            </button>
          </div>

          <!-- Form Content -->
          <div v-if="!isSubmitting && !isSubmitted">
            <h5 class="card-title">
              Enter your Details Below to schedule a tour
            </h5>

            <div class="row pb-3">
              <div class="col-md-6">
                <div>
                  <label for="tourDate" class="form-label">Select a date</label>
                  <input
                    type="text"
                    class="form-control"
                    id="tourDate"
                    ref="tourDate"
                    required
                    v-model="tourDate"
                  />
                  <small class="text-danger">{{ errors.tourDate }}</small>
                </div>
              </div>

              <div class="col-md-6">
                <div>
                  <label for="tourTime" class="form-label">Select Time</label>
                  <select
                    id="tourTime"
                    ref="tourTime"
                    class="form-control"
                    required
                    v-model="tourTime"
                  >
                    <option v-for="slot in slots" :key="slot" :value="slot">
                      {{ slot }}
                    </option>
                  </select>
                  <small class="text-danger">{{ errors.tourTime }}</small>
                </div>
              </div>
            </div>

            <div class="row pb-3">
              <div class="col-md-12">
                <div>
                  <label for="fullNames" class="form-label">Full Names</label>
                  <input
                    type="text"
                    class="form-control"
                    id="fullNames"
                    required
                    v-model="fullNames"
                  />
                  <small class="text-danger">{{ errors.fullNames }}</small>
                </div>
              </div>
            </div>

            <div class="row pb-3">
              <div class="col-md-6">
                <div>
                  <label for="telephone" class="form-label">Telephone</label>
                  <input
                    type="text"
                    class="form-control"
                    id="telephone"
                    required
                    v-model="telephone"
                  />
                  <small class="text-danger">{{ errors.telephone }}</small>
                </div>
              </div>

              <div class="col-md-6">
                <div>
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    required
                    v-model="email"
                  />
                  <small class="text-danger">{{ errors.email }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!isSubmitting && !isSubmitted">
          <button
            type="button"
            class="btn btn-success btn-block"
            @click="saveChanges"
          >
            SCHEDULE TOUR
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ScheduleTourModal",
  props: {
    propertyDetails: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      tourDate: null,
      tourTime: null,
      fullNames: "",
      telephone: "",
      email: "",
      slots: [],
      errors: {
        tourDate: "",
        tourTime: "",
        fullNames: "",
        telephone: "",
        email: "",
      },
      isSubmitting: false,
      isSubmitted: false,
    };
  },
  mounted() {
    this.modalInstance = new bootstrap.Modal(this.$refs.exampleModal);
    this.initDatepicker();
  },
  methods: {
    showModal() {
      this.isSubmitting = false;
      this.isSubmitted = false;
      this.resetForm();
      this.modalInstance.show();
    },
    hideModal() {
      this.modalInstance.hide();
    },
    initDatepicker() {
      $(this.$refs.tourDate)
        .datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
        })
        .on("changeDate", (event) => {
          this.tourDate = event.format(0, "dd-mm-yyyy");
          this.slots = [];

          axios
            .post("/calendar/check-date", {
              date: this.tourDate,
              propertyId: this.propertyDetails.id,
              user_id: this.propertyDetails.created_by,
            })
            .then((response) => {
              this.slots = response.data.data.slots;
              this.$refs.tourTime.disabled = false;
            })
            .catch((error) => {
              console.error("Error sending data to server:", error);
            });
        });
    },
    validateForm() {
      this.errors = {
        tourDate: "",
        tourTime: "",
        fullNames: "",
        telephone: "",
        email: "",
      };

      let isValid = true;

      if (!this.tourDate) {
        this.errors.tourDate = "Date is required";
        isValid = false;
      }

      if (!this.tourTime) {
        this.errors.tourTime = "Time is required";
        isValid = false;
      }

      if (!this.fullNames) {
        this.errors.fullNames = "Full Names are required";
        isValid = false;
      }

      if (!this.telephone) {
        this.errors.telephone = "Telephone is required";
        isValid = false;
      }

      if (!this.email) {
        this.errors.email = "Email is required";
        isValid = false;
      }

      return isValid;
    },
    saveChanges() {
      if (this.validateForm()) {
        this.isSubmitting = true;

        axios
          .post("/calendar/submit", {
            date: this.tourDate,
            time: this.tourTime,
            fullNames: this.fullNames,
            telephone: this.telephone,
            email: this.email,
            propertyId: this.propertyDetails.id,
            userId: this.propertyDetails.created_by,
          })
          .then((response) => {
            console.log("Data successfully sent to server:", response.data);
            this.isSubmitting = false;
            this.isSubmitted = true;
            this.resetForm();
          })
          .catch((error) => {
            console.error("Error sending data to server:", error);
            this.isSubmitting = false;
          });
      } else {
        console.error(
          "Form validation failed. Please fill in all required fields."
        );
      }
    },
    resetForm() {
      this.tourDate = null;
      this.tourTime = null;
      this.fullNames = "";
      this.telephone = "";
      this.email = "";
      this.slots = [];
      this.errors = {
        tourDate: "",
        tourTime: "",
        fullNames: "",
        telephone: "",
        email: "",
      };
      this.$refs.tourTime.disabled = true;
    },
  },
};
</script>

<style scoped>
/* Add any additional styling if necessary */
</style>
