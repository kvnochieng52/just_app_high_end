<template>
  <div class="card-carousel" @mouseover="stopTimer" @mouseleave="restartTimer">
    <div class="progressbar" v-if="autoSlideInterval && showProgressBar">
      <div :style="{ width: progressBar + '%' }"></div>
    </div>
    <div class="card-img">
      <img :src="currentImage" alt="" />
      <div class="actions">
        <span @click="prevImage" class="prev"> &#8249; </span>
        <span @click="nextImage" class="next"> &#8250; </span>
      </div>
    </div>
    <div class="thumbnails">
      <div
        v-for="(image, index) in images"
        :key="image.id"
        :class="['thumbnail-image', activeImage == index ? 'active' : '']"
        @click="activateImage(index)"
      >
        <img :src="image.thumb" :alt="'Thumbnail ' + (index + 1)" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Carousel",
  data() {
    return {
      activeImage: 0,
      autoSlideTimeout: null,
      stopSlider: false,
      timeLeft: 0,
      timerInterval: null,
      countdownInterval: 10,
    };
  },
  computed: {
    currentImage() {
      this.timeLeft = this.autoSlideInterval;
      return this.images[this.activeImage].big;
    },
    progressBar() {
      return 100 - (this.timeLeft / this.autoSlideInterval) * 100;
    },
  },
  methods: {
    nextImage() {
      var active = this.activeImage + 1;
      if (active >= this.images.length) {
        active = 0;
      }
      this.activateImage(active);
    },
    prevImage() {
      var active = this.activeImage - 1;
      if (active < 0) {
        active = this.images.length - 1;
      }
      this.activateImage(active);
    },
    activateImage(imageIndex) {
      this.activeImage = imageIndex;
    },
    startTimer(interval) {
      if (interval && interval > 0 && !this.stopSlider) {
        var self = this;
        clearTimeout(this.autoSlideTimeout);
        this.autoSlideTimeout = setTimeout(function () {
          self.nextImage();
          self.startTimer(self.autoSlideInterval);
        }, interval);
      }
    },
    stopTimer() {
      clearTimeout(this.autoSlideTimeout);
      this.stopSlider = true;
      clearInterval(this.timerInterval);
    },
    restartTimer() {
      this.stopSlider = false;
      clearInterval(this.timerInterval);
      this.startCountdown();
      this.startTimer(this.timeLeft);
    },
    startCountdown() {
      if (!this.showProgressBar) return;
      var self = this;
      this.timerInterval = setInterval(function () {
        self.timeLeft -= self.countdownInterval;
        if (self.timeLeft <= 0) {
          self.timeLeft = self.autoSlideInterval;
        }
      }, this.countdownInterval);
    },
  },
  created() {
    if (
      this.startingImage &&
      this.startingImage >= 0 &&
      this.startingImage < this.images.length
    ) {
      this.activeImage = this.startingImage;
    }

    if (
      this.autoSlideInterval &&
      this.autoSlideInterval > this.countdownInterval
    ) {
      this.startTimer(this.autoSlideInterval);
      this.timeLeft = this.autoSlideInterval;
      this.startCountdown();
    }
  },
  props: {
    startingImage: {
      type: Number,
      default: 0,
    },
    images: {
      type: Array,
      required: true,
      validator: (value) => {
        return value.every(
          (img) =>
            img.hasOwnProperty("id") &&
            img.hasOwnProperty("big") &&
            img.hasOwnProperty("thumb")
        );
      },
    },
    autoSlideInterval: {
      type: Number,
      default: 0,
    },
    showProgressBar: {
      type: Boolean,
      default: true,
    },
  },
};
</script>

<style scoped>
.card-carousel {
  user-select: none;
  position: relative;
  max-width: 800px;
  margin: 0 auto;
}

.card-img {
  position: relative;
  margin-bottom: 15px;
  overflow: hidden;
  max-height: 500px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
}

.card-img img {
  max-width: 100%;
  max-height: 500px;
  object-fit: contain;
}

.progressbar {
  display: block;
  width: 100%;
  height: 5px;
  position: absolute;
  background-color: rgba(221, 221, 221, 0.25);
  z-index: 1;
  top: 0;
}

.progressbar > div {
  background-color: rgba(255, 255, 255, 0.52);
  height: 100%;
  transition: width 0.1s linear;
}

.thumbnails {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
  padding: 5px;
}

.thumbnail-image {
  width: 80px;
  height: 60px;
  cursor: pointer;
  border: 2px solid transparent;
  overflow: hidden;
  transition: all 0.3s ease;
  flex-shrink: 0;
  background-color: #f5f5f5;
}

.thumbnail-image.active {
  border-color: #6200ee;
}

.thumbnail-image > img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.thumbnail-image:hover > img {
  transform: scale(1.05);
}

.actions {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  pointer-events: none;
}

.actions > span {
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 45px;
  color: rgba(255, 255, 255, 0.7);
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  pointer-events: auto;
  padding: 0 15px;
}

.actions > span:hover {
  color: white;
  transform: scale(1.2);
}

.actions > span.prev {
  margin-left: 5px;
}

.actions > span.next {
  margin-right: 5px;
}

@media (max-width: 600px) {
  .thumbnail-image {
    width: 60px;
    height: 45px;
  }

  .actions > span {
    font-size: 35px;
  }
}
</style>