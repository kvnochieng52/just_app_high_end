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
              style="height: 80px"
            />
          </div>

          <h4 class="mt-3 mb-0 font-weight-semibold">
            {{ $page.props.auth.user.name }}
          </h4>
          <div class="row mt-5">
            <div class="col-md-6">
              <Link href="/dashboard/edit-photo" class="btn btn-info mt-3">
                <i class="fa fa-image"></i> Edit Photo
              </Link>
            </div>

            <div class="col-md-6">
              <Link href="/dashboard/settings" class="btn btn-info mt-3">
                <i class="fa fa-pencil"></i> Edit Profile
              </Link>
            </div>
          </div>
        </div>
      </div>
      <aside class="doc-sidebar my-dash">
        <button class="toggle-btn" @click="toggleSidebar">
          <i class="fa fa-bars"></i>
        </button>
        <div
          class="app-sidebar__user clearfix"
          :class="{ 'is-active': isSidebarVisible }"
        >
          <ul class="side-menu">
            <li>
              <Link href="/dashboard" class="side-menu__item">
                <i class="icon icon-diamond"></i>
                <span class="side-menu__label ms-2">Dashboard</span>
              </Link>
            </li>

            <li>
              <Link href="/dashboard/leads" class="side-menu__item">
                <i class="fa fa-object-group"></i>
                <span class="side-menu__label ms-2">Lead Management</span>
              </Link>
            </li>

            <li>
              <Link href="/calendar" class="side-menu__item">
                <i class="fa fa-calendar"></i>
                <span class="side-menu__label ms-2">Calendar</span>
              </Link>
            </li>
            <li>
              <Link href="/dashboard/listing" class="side-menu__item">
                <i class="fa fa-home"></i>
                <span class="side-menu__label ms-2">My Listing</span>
              </Link>
            </li>

            <li>
              <Link href="/post" class="side-menu__item">
                <i class="icon icon-plus"></i>
                <span class="side-menu__label ms-2">New Listing</span>
              </Link>
            </li>

            <li>
              <Link class="side-menu__item" href="/dashboard/settings">
                <i class="icon icon-settings"></i>
                <span class="side-menu__label ms-2">Account Settings</span>
              </Link>
            </li>

            <li>
              <a href="/dashboard/heat-map" class="side-menu__item">
                <i class="fa fa-map"></i>
                <span class="side-menu__label ms-2"
                  >Heat Map(Properties Concentration)</span
                >
              </a>
            </li>

            <li>
              <a class="side-menu__item" href="/login/logout">
                <i class="icon icon-power"></i>
                <span class="side-menu__label ms-2">Logout</span>
              </a>
            </li>

            <li v-if="$page.props.auth.user.user_role == 1">
              <Link class="side-menu__item"
                ><strong>ADMINISTRATION</strong></Link
              >
            </li>

            <li v-if="$page.props.auth.user.user_role == 1">
              <Link class="side-menu__item" href="/admin/pending-approval">
                <i class="icon icon-user"></i>
                <span class="side-menu__label ms-2">Pending Approval</span>
              </Link>
            </li>

            <li v-if="$page.props.auth.user.user_role == 1">
              <Link class="side-menu__item" href="/dashboard/users">
                <i class="icon icon-user"></i>
                <span class="side-menu__label ms-2">Users Management</span>
              </Link>
            </li>
          </ul>
        </div>
      </aside>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const isSidebarVisible = ref(false);

const toggleSidebar = () => {
  isSidebarVisible.value = !isSidebarVisible.value;
};
</script>

<style scoped>
/* Add your custom styles here */
.toggle-btn {
  display: none;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  margin: 1rem;
}

@media (max-width: 991px) {
  .toggle-btn {
    display: block;
  }

  .app-sidebar__user {
    display: none;
  }

  .app-sidebar__user.is-active {
    display: block;
  }
}
</style>
