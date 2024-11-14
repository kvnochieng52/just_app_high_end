<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Heat Map</h3>
            </div>
            <div class="card-body">
              <HeatMap :heatMapData="heatMapData" />
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
import HeatMap from "./HeatMap.vue"; // Adjust the import path as necessary

// Sample data for heat map (latitude, longitude, intensity)
// Example coordinates for some towns in Kenya with higher intensity for Nairobi
const heatMapData = [
  [-1.286389, 36.817223, 1.0], // Nairobi with highest intensity
  [-0.091702, 34.767956, 0.7], // Kisumu
  [0.516667, 35.283333, 0.6], // Eldoret
  [-3.226667, 40.127778, 0.5], // Mombasa
  [0.059167, 37.645833, 0.6], // Meru
  [-0.4625, 39.646111, 0.4], // Malindi
  [-1.67889, 37.23333, 0.5], // Machakos
  [-0.2833, 36.0667, 0.3], // Nakuru
  [-0.516667, 35.283333, 0.4], // Kericho
  [-2.284, 40.912, 0.6], // Lamu
  [0.483333, 37.55, 0.4], // Nanyuki
];
</script>
