<template>
  <div class="container mx-auto">
    <div
      v-if="$page.props.flash.success"
      class="alert alert-success text-center"
    >
      {{ $page.props.flash.success }}
    </div>

    <div v-if="$page.props.flash.error" class="alert alert-warning text-center">
      {{ $page.props.flash.error }}
    </div>
  </div>
</template>

<script setup></script>
