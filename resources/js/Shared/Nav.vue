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

    <div class="horizontal-main clearfix">
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

            <li aria-haspopup="true">
              <a href="/en/blog/">Blog</a>
            </li>
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
                <a class="btn btn-outline-success" href="/post">
                  <b
                    ><i class="fa fa-plus me-1" style="color: #24894a"></i>POST
                  </b></a
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


<style  >
.header-main li .sub-menu {
  /* margin-top: 20px !important; */
}

.header-main li .sub-menu a {
  color: #24894a !important;
}

.horizontalMenu > .horizontalMenu-list > li > a > .fa,
.horizontalMenu > .horizontalMenu-list > li > a.active .fa {
  color: white !important;
}
</style>
