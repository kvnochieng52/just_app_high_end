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
    this.loadGoogleMaps();
  },
  methods: {
    loadGoogleMaps() {
      if (typeof google === "undefined") {
        const script = document.createElement("script");
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBP_0fcfVMUL_4vQmkOa1dKjJJslcVUJ44&libraries=visualization`;
        script.async = true;
        script.defer = true;
        script.onload = () => this.initMap(); // Initialize map after script loads
        document.head.appendChild(script);
      } else {
        this.initMap();
      }
    },

    initMap() {
      console.log("Initializing Google Map...");

      const map = new google.maps.Map(
        document.getElementById("google-heatmap"),
        {
          center: { lat: -1.286389, lng: 36.817223 },
          zoom: 6,
        }
      );

      const googleHeatMapData = this.heatMapData.map((location) => ({
        location: new google.maps.LatLng(location[0], location[1]),
        weight: location[2],
      }));

      const heatmap = new google.maps.visualization.HeatmapLayer({
        data: googleHeatMapData,
        map: map,
        radius: 30,
      });

      console.log("Heatmap data:", googleHeatMapData);
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
