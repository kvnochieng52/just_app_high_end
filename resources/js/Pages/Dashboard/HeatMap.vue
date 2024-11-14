<template>
  <div id="heatmap" style="height: 500px"></div>
</template>

<script>
import L from "leaflet";
import "leaflet.heat";
import "leaflet/dist/leaflet.css";

export default {
  name: "HeatMap",
  props: {
    heatMapData: {
      type: Array,
      required: true,
    },
  },
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {
      console.log("Initializing map...");

      // Initialize the map centered on Kenya
      const map = L.map("heatmap").setView([-1.286389, 36.817223], 6);

      // Add a tile layer to the map
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
      }).addTo(map);

      // Log heat map data for debugging
      console.log("Heat map data:", this.heatMapData);

      // Create a heat layer with a custom gradient and add it to the map
      L.heatLayer(this.heatMapData, {
        radius: 25,
        blur: 15,
        maxZoom: 17,
        gradient: {
          0.1: "blue",
          0.4: "lime",
          0.7: "yellow",
          1.0: "red",
        },
      }).addTo(map);
    },
  },
};
</script>

<style scoped>
#heatmap {
  width: 100%;
  height: 100%;
}
</style>
