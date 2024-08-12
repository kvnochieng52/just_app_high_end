<template>
  <section>
    <div
      class="banner-1 cover-image sptb-2 sptb-tab bg-background2"
      data-bs-image-src="/images/banners/banner1.jpg"
    >
      <div class="header-text mb-0">
        <div class="container">
          <div class="text-center text-white mb-7">
            <h1 class="mb-1">Find Your Best Property</h1>
            <p>
              It is a long established fact that a reader will be distracted by
              the readable.
            </p>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-12 col-md-12 d-block mx-auto">
              <div class="search-background bg-transparent">
                <div class="form row no-gutters">
                  <div class="form-group col-xl-3 col-lg-3 col-md-12 mb-0">
                    <input
                      type="text"
                      class="form-control input-lg br-tr-md-0 br-br-md-0"
                      id="text4"
                      placeholder="Enter Location, Town or Province"
                    />
                    <span
                      ><i class="fa fa-map-marker location-gps me-1"></i
                    ></span>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
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
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
                      data-placeholder="Min Price"
                    >
                      <option value="1" selected>Min Price</option>
                      <option value="2">KSH 5,000</option>
                      <option value="2">KSH 10,000</option>
                      <option value="2">KSH 20,000</option>
                      <option value="3">KSH 30,000</option>
                      <option value="3">KSH 40,000</option>
                      <option value="3">KSH 50,000</option>
                      <option value="3">KSH 60,000</option>
                      <option value="3">KSH 100,000</option>
                    </select>
                  </div>
                  <div
                    class="form-group col-xl-2 col-lg-2 col-md-12 select2-lg mb-0"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
                      data-placeholder="Max Price"
                    >
                      <option value="1" selected>Max Price</option>
                      <option value="2">KSH 5,000</option>
                      <option value="2">KSH 10,000</option>
                      <option value="2">KSH 20,000</option>
                      <option value="3">KSH 30,000</option>
                      <option value="3">KSH 40,000</option>
                      <option value="3">KSH 50,000</option>
                      <option value="3">KSH 60,000</option>
                      <option value="3">KSH 100,000</option>
                    </select>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-12 mb-0">
                    <button
                      type="button"
                      id="more-filters"
                      class="btn btn-outline-light btn-lg br-tl-md-0 br-bl-md-0 btn-flat"
                    >
                      <i class="fa fa-plus"></i>
                      More Filters
                    </button>
                    <a
                      href="javascript:void(0);"
                      class="btn btn-lg btn-primary br-tl-md-0 br-bl-md-0"
                      ><strong>Search</strong></a
                    >
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
                class="search-background bg-transparent"
                id="more-filters-div"
              >
                <div class="form row no-gutters">
                  <div
                    class="form-group col-xl-3 col-lg-3 col-md-12 mb-0 select2-lg"
                  >
                    <select
                      class="form-control select2-show-search border-bottom-0"
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
                  <div class="col-xl-3 col-lg-3 col-md-12 mb-0"></div>
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