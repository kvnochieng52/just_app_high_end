<template>
  <Head title="Payment Error" />
  <section class="sptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="w-100 p-0">
                <div class="wrapper bg-white p-4 p-md-5 shadow rounded-3">
                  <div class="text-center mb-4">
                    <!-- Error icon -->
                    <div class="mb-3">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="64"
                        height="64"
                        fill="#dc3545"
                        class="bi bi-x-circle-fill"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"
                        />
                      </svg>
                    </div>
                    <h4 class="text-danger">Payment Failed</h4>
                    <div class="divider-center bg-danger"></div>
                  </div>

                  <!-- Error message display -->
                  <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">Oops! Something went wrong</h5>
                    <p>{{ error }}</p>
                    <hr />
                    <p class="mb-0">
                      Please try again later or contact support if the problem
                      persists.
                    </p>
                  </div>

                  <!-- Action buttons -->
                  <div
                    class="d-grid gap-2 d-md-flex justify-content-md-center mt-4"
                  >
                    <button @click="goBack" class="btn btn-success me-md-2">
                      <i class="fa fa-arrow-left me-2"></i>Go Back
                    </button>
                    <a href="/" class="btn btn-outline-secondary">
                      <i class="fa fa-home me-2"></i>Go Home
                    </a>
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

<script>
export default {
  props: {
    error: String,
  },
  methods: {
    goBack() {
      window.history.back();
    },
  },
};
</script>

<style scoped>
.divider-center {
  height: 3px;
  width: 70px;
  margin: 15px auto;
  background: #0d6efd;
}

.alert {
  border-left: 4px solid #dc3545;
}

.pricing-card {
  border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>