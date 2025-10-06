<template>
  <section>
    <div
      class="banner-1 cover-image sptb-2 sptb-tab bg-background2 mobile-optimized"
      data-bs-image-src="/images/banners/banner1.jpg"
    >
      <div class="header-text mb-0">
        <div class="container">
          <div class="text-center text-white mb-4">
            <h1 class="mb-1">Find Your Best Property</h1>
            <p>
              It is a long established fact that a reader will be distracted by
              the readable.
            </p>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-12 col-md-12 d-block mx-auto">
              <div class="search-background bg-transparent mobile-search-form">
                <div class="form row g-2">
                  <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2 mb-md-0">
                    <input
                      type="text"
                      class="form-control input-lg br-tr-md-0 br-br-md-0 mobile-form-input"
                      id="text4"
                      placeholder="Enter Location, Town or Province"
                    />
                    <span
                      ><i class="fa fa-map-marker location-gps me-1"></i
                    ></span>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-6 col-sm-12 select2-lg mb-2 mb-md-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0 mobile-form-select"
                      data-placeholder="Property Type"
                    >
                      <option value="" selected>Property Type</option>

                      <option value="3">Apartments</option>
                      <option value="1">Villa House</option>
                      <option value="10">Town Houses</option>
                      <optgroup label="Commercial Property">
                        <option value="10">Offices</option>
                        <option value="10">Shops</option>
                        <option value="10">Warehouses</option>
                      </optgroup>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-6 col-sm-12 select2-lg mb-2 mb-md-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0 mobile-form-select"
                      data-placeholder="Min Price"
                    >
                      <option value="1" selected>Min Price</option>
                      <option value="2">
                        {{ $page.props.currency }} 5,000
                      </option>
                      <option value="2">
                        {{ $page.props.currency }} 10,000
                      </option>
                      <option value="2">
                        {{ $page.props.currency }} 20,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 30,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 40,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 50,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 60,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 100,000
                      </option>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-6 col-sm-12 select2-lg mb-2 mb-md-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0 mobile-form-select"
                      data-placeholder="Max Price"
                    >
                      <option value="1" selected>Max Price</option>
                      <option value="2">
                        {{ $page.props.currency }} 5,000
                      </option>
                      <option value="2">
                        {{ $page.props.currency }} 10,000
                      </option>
                      <option value="2">
                        {{ $page.props.currency }} 20,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 30,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 40,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 50,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 60,000
                      </option>
                      <option value="3">
                        {{ $page.props.currency }} 100,000
                      </option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 mb-md-0">
                    <div class="d-flex flex-column flex-md-row gap-2">
                      <button
                        type="button"
                        id="more-filters"
                        class="btn btn-outline-light btn-lg br-tl-md-0 br-bl-md-0 btn-flat mobile-btn flex-fill"
                      >
                        <i class="fa fa-plus"></i>
                        More Filters
                      </button>
                      <a
                        href="javascript:void(0);"
                        class="btn btn-lg btn-primary br-tl-md-0 br-bl-md-0 mobile-btn flex-fill"
                        ><strong>Search</strong></a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-10 col-lg-12 col-md-12 d-block mx-auto">
              <div style="margin-top: 8px"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-11 col-lg-12 col-md-12 d-block mx-auto">
              <div
                class="search-background bg-transparent mobile-search-form"
                id="more-filters-div"
              >
                <div class="form row g-2">
                  <div
                    class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2 mb-md-0 select2-lg"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0 mobile-form-select"
                      data-placeholder="Bedrooms"
                    >
                      <option value="" selected>Bedrooms</option>
                      <option value="3">1 Bedroom</option>
                      <option value="1">2 Bedrooms</option>
                      <option value="10">3 Bedrooms</option>
                      <option value="10">4 Bedrooms</option>
                      <option value="10">5+ Bedrooms</option>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
                      data-placeholder="Bathrooms"
                    >
                      <option value="" selected>Bathrooms</option>
                      <option value="3">1</option>
                      <option value="1">2</option>
                      <option value="10">3+</option>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
                      data-placeholder="Parking"
                    >
                      <option value="" selected>Parking</option>
                      <option value="3">1</option>
                      <option value="1">2</option>
                      <option value="10">3+</option>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
                      data-placeholder="Listing Type"
                    >
                      <option value="" selected>Listing Type</option>
                      <option value="3">Any</option>
                      <option value="1">Rent</option>
                      <option value="10">Buy</option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 mb-md-0"></div>
                </div>
              </div>
            </div>
            <div class="col-xl-10 col-lg-12 col-md-12 d-block mx-auto">
              <div style="margin-top: 8px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>

<style scoped>
/* Reduced whitespace and improved mobile responsiveness */
.mobile-optimized {
  padding-bottom: 8rem !important; /* Reduced from default 14rem */
}

.mobile-optimized .header-text {
  padding-bottom: 2rem !important; /* Reduced bottom padding */
}

.mobile-search-form {
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(10px);
  border-radius: 12px !important;
  padding: 20px !important;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
}

.mobile-form-input,
.mobile-form-select {
  border-radius: 8px !important;
  border: 1px solid #e2e8f0 !important;
  padding: 12px 16px !important;
  font-size: 14px !important;
  transition: all 0.3s ease !important;
}

.mobile-form-input:focus,
.mobile-form-select:focus {
  border-color: #28a745 !important;
  box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
}

.mobile-btn {
  border-radius: 8px !important;
  padding: 12px 20px !important;
  font-weight: 600 !important;
  transition: all 0.3s ease !important;
}

/* Enhanced mobile responsiveness */
@media (max-width: 991px) {
  .mobile-optimized {
    padding-bottom: 6rem !important;
  }

  .mobile-optimized .mb-4 {
    margin-bottom: 2rem !important;
  }

  .mobile-search-form {
    padding: 16px !important;
    margin: 0 10px !important;
  }

  .mobile-form-input,
  .mobile-form-select {
    margin-bottom: 12px !important;
    padding: 10px 14px !important;
  }

  .mobile-btn {
    width: 100% !important;
    margin-bottom: 8px !important;
    padding: 10px 16px !important;
    font-size: 14px !important;
  }
}

@media (max-width: 768px) {
  .mobile-optimized {
    padding-bottom: 4rem !important;
  }

  .mobile-optimized .header-text h1 {
    font-size: 1.8rem !important;
    margin-bottom: 0.5rem !important;
  }

  .mobile-optimized .header-text p {
    font-size: 14px !important;
    margin-bottom: 1rem !important;
  }

  .mobile-search-form {
    padding: 12px !important;
    margin: 0 5px !important;
  }

  .form-group {
    margin-bottom: 12px !important;
  }
}

@media (max-width: 576px) {
  .mobile-optimized {
    padding-bottom: 3rem !important;
  }

  .mobile-optimized .header-text h1 {
    font-size: 1.5rem !important;
  }

  .mobile-optimized .header-text p {
    font-size: 13px !important;
  }

  .mobile-search-form {
    padding: 10px !important;
    border-radius: 8px !important;
  }

  .mobile-form-input,
  .mobile-form-select {
    font-size: 13px !important;
    padding: 8px 12px !important;
  }

  .mobile-btn {
    font-size: 13px !important;
    padding: 8px 12px !important;
  }

  .gap-2 {
    gap: 0.5rem !important;
  }
}

/* Location icon positioning */
.form-group {
  position: relative;
}

.location-gps {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #28a745 !important;
  z-index: 2;
}

.mobile-form-input[id="text4"] {
  padding-left: 35px !important;
}

/* Button enhancements - Updated to match global gradient */
.btn-primary {
  background: linear-gradient(135deg, #28a745 0%, #cbbe07 100%) !important;
  border: none !important;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3) !important;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #20c997 0%, #ffc107 100%) !important;
  box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4) !important;
  transform: translateY(-1px);
}

.btn-outline-light {
  border-color: rgba(255, 255, 255, 0.8) !important;
  color: #fff !important;
}

.btn-outline-light:hover {
  background: rgba(255, 255, 255, 0.1) !important;
  border-color: #fff !important;
  color: #fff !important;
}

/* Hidden filters section enhancement */
#more-filters-div {
  display: none;
  margin-top: 16px !important;
}

#more-filters-div.show {
  display: block;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>