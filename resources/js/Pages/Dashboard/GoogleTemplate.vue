<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-8 col-lg-8 col-md-8">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Heat Map</h3>
            </div>
            <div class="card-body">
              <GoogleHeatMap :heatMapData="heatMapData" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import UserNav from "./UserNav.vue";
import GoogleHeatMap from "./GoogleHeatMap.vue";
import { ref } from "vue";

// Props
const props = defineProps({
  heatMapData: Array,
});

// Data
const heatMapData = ref(props.heatMapData);
</script>
