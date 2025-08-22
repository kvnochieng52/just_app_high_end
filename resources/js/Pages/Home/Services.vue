<template>
  <Head title="Our Services - Just Homes" />
  <section class="sptb">
    <div class="container">
      <div class="section-title center-block text-center">
        <h2>Our Services</h2>
        <p>
          Discover the comprehensive range of real estate services we offer to
          meet your needs
        </p>
      </div>

      <div class="row">
        <!-- Property Listing Service -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-primary-transparent rounded-circle text-primary mb-4"
                >
                  <i class="fa fa-home fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Property Listing</h4>
                <p>
                  List your property for sale or rent with our easy-to-use
                  platform. Reach thousands of potential buyers and tenants.
                </p>
                <Link href="/post" class="btn btn-success mt-2"
                  >List Your Property</Link
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Property Search Service -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-secondary-transparent rounded-circle text-secondary mb-4"
                >
                  <i class="fa fa-search fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Property Search</h4>
                <p>
                  Find your dream home with our advanced search tools. Filter by
                  location, price, amenities, and more.
                </p>
                <Link href="/" class="btn btn-secondary mt-2"
                  >Search Properties</Link
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Property Valuation Service -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-info-transparent rounded-circle text-info mb-4"
                >
                  <i class="fa fa-calculator fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Property Valuation</h4>
                <p>
                  Get an accurate valuation of your property based on current
                  market trends and comparable properties.
                </p>
                <Link href="/contact-us" class="btn btn-info mt-2"
                  >Request Valuation</Link
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Real Estate Consultation -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-success-transparent rounded-circle text-success mb-4"
                >
                  <i class="fa fa-comments fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Real Estate Consultation</h4>
                <p>
                  Get expert advice from our real estate professionals to make
                  informed decisions about buying, selling, or investing.
                </p>
                <Link href="/contact-us" class="btn btn-success mt-2"
                  >Book Consultation</Link
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Property Management -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-warning-transparent rounded-circle text-warning mb-4"
                >
                  <i class="fa fa-building fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Property Management</h4>
                <p>
                  Let us handle the day-to-day management of your rental
                  properties, from tenant screening to maintenance.
                </p>
                <Link href="/contact-us" class="btn btn-warning mt-2"
                  >Learn More</Link
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Investment Advisory -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="item-card9 text-center">
                <div
                  class="icon-service bg-danger-transparent rounded-circle text-danger mb-4"
                >
                  <i class="fa fa-chart-line fa-2x"></i>
                </div>
                <h4 class="font-weight-bold">Investment Advisory</h4>
                <p>
                  Get strategic advice on real estate investments to maximize
                  returns and build a profitable property portfolio.
                </p>
                <Link href="/contact-us" class="btn btn-danger mt-2"
                  >Get Advice</Link
                >
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Call to Action -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="card bg-primary">
            <div class="card-body text-center text-white p-5">
              <h3 class="mb-3">Need a Custom Service?</h3>
              <p class="mb-4">
                Contact our team to discuss your specific real estate needs and
                how we can help you.
              </p>
              <Link href="/contact-us" class="btn btn-white"
                >Contact Us Today</Link
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
</script>

<style scoped>
.icon-service {
  display: inline-flex;
  width: 80px;
  height: 80px;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.bg-primary-transparent {
  background-color: rgba(51, 102, 255, 0.1);
}

.bg-secondary-transparent {
  background-color: rgba(91, 71, 251, 0.1);
}

.bg-success-transparent {
  background-color: rgba(40, 167, 69, 0.1);
}

.bg-info-transparent {
  background-color: rgba(23, 162, 184, 0.1);
}

.bg-warning-transparent {
  background-color: rgba(255, 193, 7, 0.1);
}

.bg-danger-transparent {
  background-color: rgba(220, 53, 69, 0.1);
}
</style>
