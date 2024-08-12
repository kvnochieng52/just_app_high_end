<template>
  <Nav />
  <Flash />

  <slot />
  <Footer />
</template>

<script setup>
import Nav from "./Nav.vue";
import Footer from "./Footer.vue";
import Flash from "./Flash.vue";
</script>
