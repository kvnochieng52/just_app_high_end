<template>
  <div class="col-xl-3 col-lg-12 col-md-12">
    <div class="card overflow-hidden">
      <div class="card-body text-center item-user">
        <div class="profile-pic">
          <div class="profile-pic-img">
            <img
              :src="
                $page.props.auth.user.avatar
                  ? $page.props.auth.user.avatar
                  : '/images/no_user.png'
              "
              class="brround"
              alt="user"
            />
          </div>

          <h4 class="mt-3 mb-0 font-weight-semibold">
            {{ $page.props.auth.user.name }}
          </h4>
          <div class="row mt-5">
            <div class="col-md-6">
              <Link href="/dashboard/edit-photo" class="btn btn-info">
                <i class="fa fa-image"></i> Edit Photo</Link
              >
            </div>

            <div class="col-md-6">
              <Link href="/dashboard/settings" class="btn btn-info">
                <i class="fa fa-pencil"></i> Edit Profile</Link
              >
            </div>
          </div>
        </div>
      </div>
      <aside class="doc-sidebar my-dash">
        <div class="app-sidebar__user clearfix">
          <ul class="side-menu">
            <li>
              <Link href="/dashboard" class="side-menu__item"
                ><i class="icon icon-diamond"></i
                ><span class="side-menu__label ms-2">Dashboard</span></Link
              >
            </li>

            <li>
              <Link href="/dashboard/leads" class="side-menu__item"
                ><i class="fa fa-object-group"></i
                ><span class="side-menu__label ms-2"
                  >Lead Management</span
                ></Link
              >
            </li>

            <li>
              <Link href="/calendar" class="side-menu__item"
                ><i class="fa fa-calendar"></i
                ><span class="side-menu__label ms-2">Calendar</span></Link
              >
            </li>
            <li>
              <Link href="/dashboard/listing" class="side-menu__item"
                ><i class="fa fa-home"></i>
                <span class="side-menu__label ms-2">My Listing</span></Link
              >
            </li>

            <li>
              <Link href="/post" class="side-menu__item"
                ><i class="icon icon-plus"></i
                ><span class="side-menu__label ms-2">New Listing</span></Link
              >
            </li>

            <li>
              <Link class="side-menu__item" href="/dashboard/settings"
                ><i class="icon icon-settings"></i
                ><span class="side-menu__label ms-2"
                  >Account Settings
                </span></Link
              >
            </li>

            <li v-if="$page.props.auth.user.user_role == 1">
              <Link class="side-menu__item" href="/dashboard/users"
                ><i class="icon icon-user"></i
                ><span class="side-menu__label ms-2"
                  >Users Management
                </span></Link
              >
            </li>
            <li>
              <a class="side-menu__item" href="/login/logout"
                ><i class="icon icon-power"></i
                ><span class="side-menu__label ms-2">Logout</span></a
              >
            </li>
          </ul>
        </div>
      </aside>
    </div>
  </div>
</template>



<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>