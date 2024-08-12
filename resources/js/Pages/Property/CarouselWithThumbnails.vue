<template>
  <div class="carousel-with-thumbnails">
    <div id="carouselExample" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div
          v-for="(item, index) in carouselItems"
          :key="index"
          :class="['carousel-item', { active: index === 0 }]"
        >
          <img :src="item.image" class="d-block w-100" alt="Carousel Slide" />
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselExample"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselExample"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div class="thumbnail-container">
      <div
        v-for="(item, index) in carouselItems"
        :key="index"
        class="thumbnail"
        :class="{ active: index === activeIndex }"
        @click="setActiveIndex(index)"
      >
        <img :src="item.thumbnail" alt="Thumbnail" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      carouselItems: [
        {
          image: "https://source.unsplash.com/Pn6iimgM-wo/1600x900/",
          thumbnail: "https://source.unsplash.com/Pn6iimgM-wo/1600x900/",
        },
        {
          image: "https://source.unsplash.com/Pn6iimgM-wo/1600x900/",
          thumbnail: "https://source.unsplash.com/Pn6iimgM-wo/1600x900/",
        },
        // Add more items as needed
      ],
      activeIndex: 0,
    };
  },
  methods: {
    setActiveIndex(index) {
      this.activeIndex = index;
    },
  },
};
</script>

<style scoped>
.thumbnail-container {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.thumbnail {
  cursor: pointer;
  margin: 0 5px;
  opacity: 0.6;
  transition: opacity 0.2s;
}

.thumbnail.active {
  opacity: 1;
}
</style>
