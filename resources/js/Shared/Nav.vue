<template>
  <!-- Bootstrap Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <!-- Brand/Logo -->
      <Link href="/" class="navbar-brand">
        <img
          src="/images/brand/logo445.png"
          alt="Just Homes"
          style="width: 180px"
        />
      </Link>

      <!-- Mobile toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fa fa-bars"></i>
      </button>

      <!-- Navigation items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <Link href="/" class="nav-link fw-bold">HOME</Link>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle fw-bold"
              href="#"
              id="rentDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              RENT
            </a>
            <ul class="dropdown-menu" aria-labelledby="rentDropdown">
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=1"
                  class="dropdown-item"
                  >Apartment</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=2"
                  class="dropdown-item"
                  >House</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=4"
                  class="dropdown-item"
                  >Villa</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=5"
                  class="dropdown-item"
                  >Townhouse</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=3"
                  class="dropdown-item"
                  >Office</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=1&propertyType[]=6"
                  class="dropdown-item"
                  >Shop</Link
                >
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle fw-bold"
              href="#"
              id="buyDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              BUY
            </a>
            <ul class="dropdown-menu" aria-labelledby="buyDropdown">
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=1"
                  class="dropdown-item"
                  >Apartment</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=2"
                  class="dropdown-item"
                  >House</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=4"
                  class="dropdown-item"
                  >Villa</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=5"
                  class="dropdown-item"
                  >Townhouse</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=7"
                  class="dropdown-item"
                  >Land</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=3"
                  class="dropdown-item"
                  >Office</Link
                >
              </li>
              <li>
                <Link
                  href="/search?search=1&leaseType=2&propertyType[]=6"
                  class="dropdown-item"
                  >Shop</Link
                >
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <Link
              href="/search?search=1&propertyType[]=7"
              class="nav-link fw-bold"
              >LAND</Link
            >
          </li>

          <li class="nav-item">
            <Link href="/search?search=1&offplan=1" class="nav-link fw-bold"
              >OFFPLAN</Link
            >
          </li>

          <li class="nav-item">
            <Link href="/search?search=1&onauction=1" class="nav-link fw-bold"
              >AUCTION</Link
            >
          </li>

          <li class="nav-item">
            <Link href="/services" class="nav-link fw-bold">SERVICES</Link>
          </li>
        </ul>

        <!-- Right side buttons -->
        <div class="d-flex align-items-center gap-3">
          <template v-if="!$page.props.auth">
            <Link href="/login" class="btn btn-outline-primary">
              <strong>REGISTER/LOGIN</strong>
            </Link>
          </template>
          <template v-else>
            <div class="dropdown">
              <a
                href="#"
                class="nav-link dropdown-toggle d-flex align-items-center text-dark"
                id="userDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img
                  :src="
                    $page.props.auth.user.avatar
                      ? $page.props.auth.user.avatar
                      : '/images/no_user.png'
                  "
                  class="rounded-circle me-2"
                  alt="user"
                  style="width: 30px; height: 30px; object-fit: cover"
                />
                {{ $page.props.auth.user.name }}
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="userDropdown"
              >
                <li>
                  <a href="/dashboard" class="dropdown-item">
                    <i class="icon icon-diamond me-2"></i>Dashboard
                  </a>
                </li>
                <li>
                  <a href="/dashboard/leads" class="dropdown-item">
                    <i class="fa fa-object-group me-2"></i>Lead Management
                  </a>
                </li>
                <li>
                  <a href="/dashboard/listing" class="dropdown-item">
                    <i class="icon icon-home me-2"></i>My Listings
                  </a>
                </li>
                <li>
                  <a href="/post" class="dropdown-item">
                    <i class="icon icon-plus me-2"></i>New Listing
                  </a>
                </li>
                <li>
                  <a href="/dashboard/settings" class="dropdown-item">
                    <i class="icon icon-settings me-2"></i>Account Settings
                  </a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a href="/login/logout" class="dropdown-item">
                    <i class="icon icon-power me-2"></i>Log out
                  </a>
                </li>
              </ul>
            </div>
          </template>

          <a href="/post" class="btn btn-success">
            <i class="fa fa-plus me-1"></i><strong>POST</strong>
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>

<style scoped>
/* Custom navigation styles */
.navbar {
  padding: 0.75rem 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.navbar-brand img {
  /* height: 32px; */
  width: auto;
}

.nav-link {
  color: #2c3e50 !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  padding: 0.5rem 1rem !important;
  transition: color 0.3s ease !important;
}

.nav-link:hover {
  color: #28a745 !important;
}

.nav-link.fw-bold {
  font-weight: 700 !important;
}

/* Dropdown menu styling with z-index fix and hover functionality */
.dropdown-menu {
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  padding: 0.5rem 0;
  z-index: 9999 !important;
  position: absolute !important;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s ease;
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
  display: block !important;
}

/* Also keep click functionality for mobile */
.dropdown-menu.show {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
  display: block !important;
}

.dropdown-item {
  padding: 0.5rem 1rem;
  font-size: 14px;
  font-weight: 500;
  color: #495057;
  transition: all 0.3s ease;
}

.dropdown-item:hover {
  background-color: rgba(40, 167, 69, 0.1);
  color: #28a745;
}

/* Button styling */
.btn {
  border-radius: 6px;
  font-weight: 600;
  font-size: 13px;
  padding: 0.5rem 1rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}

.btn-outline-primary {
  border-color: #007bff;
  color: #007bff;
}

.btn-outline-primary:hover {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
  transform: translateY(-1px);
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
  color: white;
}

.btn-success:hover {
  background-color: #218838;
  border-color: #1e7e34;
  color: white;
  transform: translateY(-1px);
}

/* User dropdown styling */
#userDropdown {
  text-decoration: none;
  font-weight: 500;
}

#userDropdown:hover {
  color: #28a745 !important;
}

/* Mobile responsiveness */
@media (max-width: 991.98px) {
  .navbar-nav .nav-link {
    padding: 0.75rem 1rem !important;
  }

  .d-flex.gap-3 {
    flex-direction: column;
    gap: 0.5rem !important;
    width: 100%;
    margin-top: 1rem;
  }

  .btn {
    width: 100%;
    text-align: center;
  }
}

/* Ensure dropdown menus appear above other content */
.navbar .dropdown-menu {
  z-index: 9999 !important;
}

/* Mobile toggle button styling */
.navbar-toggler {
  border: none !important;
  background: transparent !important;
  padding: 0.5rem !important;
}

.navbar-toggler:focus {
  box-shadow: none !important;
}

.navbar-toggler i {
  font-size: 1.2rem;
  color: #2c3e50;
  transition: color 0.3s ease;
}

.navbar-toggler:hover i {
  color: #28a745;
}

/* Override any conflicting styles */
.navbar * {
  box-sizing: border-box;
}
</style>