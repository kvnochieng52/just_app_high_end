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
import GoogleHeatMap from "./GoogleHeatMap.vue"; // Adjust the import path as necessary

// Sample data for heat map (latitude, longitude, intensity)
// Example coordinates for some towns in Kenya with higher intensity for Nairobi
const heatMapData = [
  [-1.286389, 36.817223, 1], // Nairobi with highest intensity
  [-1.286383, 36.817223, 1],
  [-1.286359, 36.817253, 1],
  [-1.28639, 36.817523, 1],
  [-0.091702, 34.767956, 1], // Kisumu
  [0.516667, 35.283333, 1], // Eldoret
  [-3.226667, 40.127778, 1], // Mombasa
  [0.059167, 37.645833, 1], // Meru
  [-0.4625, 39.646111, 1], // Malindi
  [-1.67889, 37.23333, 1], // Machakos
  [-0.2833, 36.0667, 1], // Nakuru
  [-0.516667, 35.283333, 1], // Kericho
  [-2.284, 40.912, 1], // Lamu
  [0.483333, 37.55, 1], // Nanyuki
];
</script>
 