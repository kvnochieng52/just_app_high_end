<template>
  <!--Topbar-->
  <div class="header-main">
    <div class="sticky">
      <div class="horizontal-header clearfix" style="background-color: #252742">
        <div class="container">
          <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
          <span class="smllogo">
            <a href="index.html">
              <img
                src="/images/brand/logo_trans.png"
                class="mobile-light-logo"
                alt=""
                style="width: 140px"
              />
              <img
                src="/images/brand/logo_trans.png"
                class="mobile-dark-logo"
                alt=""
                style="width: 140px"
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
            ><img
              src="/images/brand/logo_trans.png"
              alt=""
              style="width: 220px"
          /></a>
        </div>
        <div class="desktoplogo-1">
          <a href="/"
            ><img
              src="/images/brand/logo_trans.png"
              alt=""
              style="width: 220px"
          /></a>
        </div>

        <nav
          class="horizontalMenu clearfix"
          style="background-color: #252742 !important"
        >
          <ul
            class="horizontalMenu-list"
            style="background-color: #252742 !important"
          >
            <li aria-haspopup="true">
              <a href="/" class="active">Home </a>
            </li>

            <li aria-haspopup="true">
              <a href="/search"> Search</a>

              <!-- <Link href="/search"> Search</Link> -->
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

            <!-- <li class="d-lg-none mt-5 pb-5 mt-lg-0">
              <span
                ><Link class="btn btn-secondary" href="/post"
                  >POST PROPERTY 3</Link
                ></span
              >
            </li> -->

            <li>
              <ul class="custom">
                <template v-if="!$page.props.auth">
                  <li>
                    <Link
                      href="/login"
                      class="btn btn-primary btn-block green_b"
                    >
                      <i class="fa fa-sign-in me-1"></i>
                      <span>Register / Login</span>
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
