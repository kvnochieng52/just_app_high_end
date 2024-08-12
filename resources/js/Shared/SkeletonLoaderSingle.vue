<template>
  <div class="row">
    <div class="col-md-12">
      <div class="skeleton skeleton-text" style="height: 350px"></div>

      <div style="padding: 7px">
        <div class="skeleton skeleton-text"></div>

        <div class="skeleton skeleton-text skeleton-text__body"></div>

        <div
          class="skeleton skeleton-text skeleton-footer"
          style="height: 15px"
        ></div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.skeleton {
  animation: skeleton-loading 1s linear infinite alternate;
}

@keyframes skeleton-loading {
  0% {
    background-color: hsl(200, 20%, 80%);
  }
  100% {
    background-color: hsl(200, 20%, 95%);
  }
}

.skeleton-text {
  width: 100%;
  height: 0.7rem;
  margin-bottom: 0.5rem;
  border-radius: 0.25rem;
}

.skeleton-text__body {
  width: 75%;
}

.skeleton-footer {
  width: 30%;
}
</style>

<script setup>
</script>
