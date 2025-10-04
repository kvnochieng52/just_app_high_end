<template>
  <!--Topbar-->
  <div class="header-main">
    <div class="sticky">
      <div class="horizontal-header clearfix">
        <div class="container">
          <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
          <span class="smllogo">
            <a href="/">
              <img
                src="/images/brand/logo445.png"
                class="mobile-light-logo"
                alt=""
                style="width: 150px"
              />
              <img
                src="/images/brand/logo445.png"
                class="mobile-dark-logo"
                alt=""
                style="width: 150px"
              />
            </a>
          </span>
          <a href="tel:245-6325-3256" class="callusbtn"
            ><i class="fa fa-phone" aria-hidden="true"></i
          ></a>
        </div>
      </div>
    </div>

    <div class="horizontal-main clearfix nav-light-gray">
      <div class="horizontal-mainwrapper container clearfix">
        <div class="desktoplogo">
          <a href="/"
            ><img src="/images/brand/logo445.png" alt="" style="width: 180px"
          /></a>
        </div>
        <div class="desktoplogo-1">
          <a href="/"
            ><img src="/images/brand/logo445.png" alt="" style="width: 180px"
          /></a>
        </div>

        <nav class="horizontalMenu clearfix">
          <ul class="horizontalMenu-list">
            <li aria-haspopup="true">
              <Link href="/" class="active">Home </Link>
            </li>

            <!-- <li aria-haspopup="true">
              <a href="/find?search=1&leaseType=1&propertyType[]=1/">Find</a>
            </li> -->

            <!-- <li aria-haspopup="true">
              <a
                href="https://government-housing.justhomes.co.ke/"
                class="active"
                >Govt Housing Guide
              </a>
            </li> -->

            <li>
              <a href="javascript:void(0);"
                >Rent <span class="fa fa-caret-down m-0"></span
              ></a>
              <ul class="sub-menu">
                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=1"
                    >Apartment</Link
                  >
                </li>
                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=2"
                    >House
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=4"
                    >Villa
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=5"
                    >Townhouse
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=3"
                    >Office
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=1&propertyType[]=6"
                    >Shop
                  </Link>
                </li>
              </ul>
            </li>

            <li>
              <a href="javascript:void(0);"
                >Buy <span class="fa fa-caret-down m-0"></span
              ></a>
              <ul class="sub-menu">
                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=1"
                    >Apartment</Link
                  >
                </li>
                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=2"
                    >House
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=4"
                    >Villa
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=5"
                    >Townhouse
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=7"
                    >Land
                  </Link>
                </li>
                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=3"
                    >Office
                  </Link>
                </li>

                <li aria-haspopup="true">
                  <Link href="/search?search=1&leaseType=2&propertyType[]=6"
                    >Shop
                  </Link>
                </li>
              </ul>
            </li>

            <li aria-haspopup="true">
              <Link href="/search?search=1&propertyType[]=7" class="active"
                >Land
              </Link>
            </li>

            <li aria-haspopup="true">
              <Link href="/search?search=1&offplan=1" class="active"
                >OffPlan
              </Link>
            </li>

            <li aria-haspopup="true">
              <Link href="/search?search=1&onauction=1" class="active"
                >Auction
              </Link>
            </li>

            <li aria-haspopup="true">
              <Link href="/services" class="active">Services </Link>
            </li>

            <!-- <li aria-haspopup="true">
              <a href="/search"> Search</a>

           
            </li>
            <li aria-haspopup="true">
              <a href="/properties/type/appartment">Apartments</a>
            </li>
            <li aria-haspopup="true">
              <a href="/properties/type/office-space">Office Space</a>
            </li>
            <li aria-haspopup="true">
              <a href="/properties/type/shop">Shops</a>
            </li>
            <li aria-haspopup="true">
              <a href="/properties/type/warehouse">Warehouse</a>
            </li>

            <li aria-haspopup="true">
              <a href="/blog/">Blog</a>
            </li> -->

            <!-- <li aria-haspopup="true">
              <a href="/en/blog/">Blog</a>
            </li> -->
            <li>
              <ul class="custom">
                <template v-if="!$page.props.auth">
                  <li>
                    <Link href="/login" class="btn">
                      <!-- <i class="fa fa-sign-in me-1"></i> -->
                      <span><b>REGISTER/LOGIN</b></span>
                    </Link>
                  </li>
                </template>
                <template v-else>
                  <li class="dropdown" style="margin-top: 6px">
                    <a href="#" class="text-dark" data-bs-toggle="dropdown">
                      <img
                        :src="
                          $page.props.auth.user.avatar
                            ? $page.props.auth.user.avatar
                            : '/images/no_user.png'
                        "
                        class="brround"
                        alt="user"
                        style="width: 20px"
                      />
                      <span> &nbsp;{{ $page.props.auth.user.name }}</span></a
                    >
                    <div
                      class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                    >
                      <a
                        href="/dashboard"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon icon icon-diamond"></i>Dashboard
                      </a>
                      <a
                        href="/dashboard/leads"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon fa fa-object-group"></i>
                        Lead Management
                      </a>

                      <a
                        href="/dashboard/listing"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon icon icon-home"></i> My Listings
                      </a>

                      <a
                        href="/post"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon icon icon-plus"></i> New Listing
                      </a>
                      <a
                        href="/dashboard/settings"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon icon icon-settings"></i> Account
                        Settings
                      </a>
                      <a
                        href="/login/logout"
                        class="dropdown-item"
                        style="color: black !important"
                      >
                        <i class="dropdown-icon icon icon-power"></i> Log out
                      </a>
                    </div>
                  </li>
                </template>
              </ul>
              <!-- <a href="/login" class="custom-button">
                <i class="fa fa-user" style="color: #fff"></i> Log In
              </a> -->
              <!-- <Link class="btn btn-success green_b" href="/post"
                >POST PROPERTY FOR FREE</Link
              > -->
            </li>

            <li class="mt-5 pb-5 mt-lg-0" style="margin-left: 15px">
              <span>
                <a class="btn btn-success post-btn-green" href="/post">
                  <b
                    ><i class="fa fa-plus me-1"></i>POST
                  </b></a>
                >
              </span>
            </li>
          </ul>
          <ul class="mb-0"></ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>


<style>
/* Import professional Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap');

/* Enhanced navigation styling */
.nav-light-gray {
  background: rgba(255, 255, 255, 0.98) !important;
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.horizontal-main {
  padding: 8px 0 !important;
}

/* Professional navigation font */
.horizontalMenu > .horizontalMenu-list > li > a {
  font-family: 'Roboto', 'Open Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  color: #2c3e50 !important;
  transition: all 0.3s ease !important;
  padding: 12px 18px !important;
  border-radius: 0 !important;
  margin: 0 4px !important;
  position: relative;
  text-decoration: none !important;
  letter-spacing: 0.02em !important;
  text-transform: uppercase;
  background: transparent;
  box-shadow: none;
  border: none;
}

/* Hover and active states */
.horizontalMenu > .horizontalMenu-list > li > a:hover {
  color: #2c3e50 !important;
  background: transparent !important;
  transform: none;
  box-shadow: none;
  border-bottom: none;
}

.horizontalMenu > .horizontalMenu-list > li > a.active {
  color: #2c3e50 !important;
  font-weight: 700 !important;
  background: transparent !important;
  box-shadow: none;
  border-bottom: none;
}

/* Dropdown arrow styling */
.horizontalMenu > .horizontalMenu-list > li > a > .fa {
  color: inherit !important;
  font-size: 12px !important;
  margin-left: 6px !important;
  transition: transform 0.3s ease !important;
}

.horizontalMenu > .horizontalMenu-list > li:hover > a > .fa {
  transform: rotate(180deg);
}

/* Improved dropdown menu */
.header-main .sub-menu {
  background: white !important;
  border: 1px solid rgba(0, 0, 0, 0.05) !important;
  border-radius: 12px !important;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
  padding: 8px !important;
  margin-top: 8px !important;
  backdrop-filter: blur(10px);
}

.header-main li .sub-menu a {
  font-family: 'Roboto', 'Open Sans', sans-serif !important;
  color: #4a5568 !important;
  font-weight: 500 !important;
  font-size: 14px !important;
  padding: 10px 16px !important;
  border-radius: 8px !important;
  transition: all 0.3s ease !important;
  display: block !important;
  text-decoration: none !important;
}

.header-main li .sub-menu a:hover {
  color: #24894a !important;
  background: rgba(36, 137, 74, 0.08) !important;
  transform: translateX(4px);
}

/* Enhanced POST button */
.btn.btn-success.post-btn-green,
.post-btn-green,
a.post-btn-green {
  background: #28a745 !important;
  background-color: #28a745 !important;
  border: none !important;
  border-color: #28a745 !important;
  border-radius: 8px !important;
  padding: 10px 20px !important;
  font-family: 'Roboto', 'Open Sans', sans-serif !important;
  font-weight: 600 !important;
  font-size: 13px !important;
  color: white !important;
  transition: all 0.3s ease !important;
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3) !important;
  letter-spacing: 0.01em !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  text-decoration: none !important;
}

.btn.btn-success.post-btn-green:hover,
.post-btn-green:hover,
a.post-btn-green:hover {
  background: #218838 !important;
  background-color: #218838 !important;
  color: white !important;
  border-color: #218838 !important;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4) !important;
}

.btn.btn-success.post-btn-green i,
.post-btn-green i,
a.post-btn-green i {
  color: white !important;
  font-size: 12px !important;
}

.btn.btn-success.post-btn-green b,
.post-btn-green b,
a.post-btn-green b {
  color: white !important;
  font-weight: 600 !important;
}

/* User dropdown styling */
.dropdown-menu {
  border: 1px solid rgba(0, 0, 0, 0.05) !important;
  border-radius: 12px !important;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
  padding: 8px !important;
  backdrop-filter: blur(10px);
}

.dropdown-item {
  font-family: 'Roboto', 'Open Sans', sans-serif !important;
  font-weight: 500 !important;
  font-size: 14px !important;
  color: #4a5568 !important;
  border-radius: 8px !important;
  padding: 10px 16px !important;
  transition: all 0.3s ease !important;
}

.dropdown-item:hover {
  background: rgba(36, 137, 74, 0.08) !important;
  color: #24894a !important;
}

/* Login/Register button */
.horizontalMenu .btn {
  font-family: 'Roboto', 'Open Sans', sans-serif !important;
  font-weight: 600 !important;
  font-size: 13px !important;
  color: #4a5568 !important;
  border: 2px solid #e2e8f0 !important;
  border-radius: 10px !important;
  padding: 8px 16px !important;
  transition: all 0.3s ease !important;
  background: transparent !important;
}

.horizontalMenu .btn:hover {
  color: #24894a !important;
  border-color: #24894a !important;
  background: rgba(36, 137, 74, 0.05) !important;
}

/* Logo styling */
.desktoplogo img,
.desktoplogo-1 img {
  transition: transform 0.3s ease;
}

.desktoplogo:hover img,
.desktoplogo-1:hover img {
  transform: scale(1.05);
}

/* Mobile menu improvements */
.smllogo img {
  transition: transform 0.3s ease;
}

.callusbtn {
  background: #24894a !important;
  color: white !important;
  border-radius: 50% !important;
  width: 45px !important;
  height: 45px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  transition: all 0.3s ease !important;
  box-shadow: 0 4px 12px rgba(36, 137, 74, 0.3);
}

.callusbtn:hover {
  background: #1e7a3e !important;
  color: white !important;
  transform: scale(1.1);
  box-shadow: 0 6px 16px rgba(36, 137, 74, 0.4);
}

/* Responsive adjustments */
@media (max-width: 991px) {
  .horizontalMenu > .horizontalMenu-list > li > a {
    font-size: 16px !important;
    padding: 15px 20px !important;
  }

  .post-btn-green {
    padding: 10px 20px !important;
    font-size: 13px !important;
  }
}

/* Sticky navigation enhancement */
.sticky-wrapper.is-sticky .nav-light-gray {
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(15px);
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
}

.sticky-wrapper.is-sticky .horizontalMenu > .horizontalMenu-list > li > a {
  color: #2c3e50 !important;
}

.sticky-wrapper.is-sticky .horizontalMenu > .horizontalMenu-list > li > a:hover {
  color: #24894a !important;
}

.sticky-wrapper.is-sticky .horizontalMenu > .horizontalMenu-list > li > a.active {
  color: #2c3e50 !important;
}

/* Force green background for POST button - Override any Bootstrap styles */
.horizontalMenu .btn-success.post-btn-green,
.horizontalMenu a.btn-success.post-btn-green,
.horizontalMenu .post-btn-green {
  background: #28a745 !important;
  background-color: #28a745 !important;
  border-color: #28a745 !important;
}

.horizontalMenu .btn-success.post-btn-green:hover,
.horizontalMenu a.btn-success.post-btn-green:hover,
.horizontalMenu .post-btn-green:hover {
  background: #218838 !important;
  background-color: #218838 !important;
  border-color: #218838 !important;
}
</style>
