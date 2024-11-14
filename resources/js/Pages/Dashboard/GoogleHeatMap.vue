<template>
  <div id="google-heatmap" style="height: 500px"></div>
</template>

<script>
export default {
  name: "GoogleHeatMap",
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
      console.log("Initializing Google Map...");

      // Initialize the map centered on Kenya
      const map = new google.maps.Map(
        document.getElementById("google-heatmap"),
        {
          center: { lat: -1.286389, lng: 36.817223 },
          zoom: 6,
        }
      );

      // Transform heatMapData to google.maps.LatLng objects
      const googleHeatMapData = this.heatMapData.map((location) => ({
        location: new google.maps.LatLng(location[0], location[1]),
        weight: location[2],
      }));

      // Create a heatmap layer
      const heatmap = new google.maps.visualization.HeatmapLayer({
        data: googleHeatMapData,
        map: map,
        radius: 30, // Adjust radius to increase visibility
      });

      console.log("Heatmap data:", googleHeatMapData);

      // Customize the gradient
      const gradient = [
        "rgba(0, 255, 255, 0)",
        "rgba(0, 255, 255, 1)",
        "rgba(0, 191, 255, 1)",
        "rgba(0, 127, 255, 1)",
        "rgba(0, 63, 255, 1)",
        "rgba(0, 0, 255, 1)",
        "rgba(0, 0, 223, 1)",
        "rgba(0, 0, 191, 1)",
        "rgba(0, 0, 159, 1)",
        "rgba(0, 0, 127, 1)",
        "rgba(63, 0, 91, 1)",
        "rgba(127, 0, 63, 1)",
        "rgba(191, 0, 31, 1)",
        "rgba(255, 0, 0, 1)",
      ];
      heatmap.set("gradient", gradient);
    },
  },
};
</script>

<style scoped>
#google-heatmap {
  width: 100%;
  height: 100%;
}
</style>
