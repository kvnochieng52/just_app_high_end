<template>
  <ul class="pagination mb-0" v-if="links.length > 0">
    <template v-for="(link, p) in links" :key="p">
      <li
        class="page-item"
        :class="{
          disabled: link.url === null,
          active: link.active,
        }"
      >
        <Link
          class="page-link"
          :class="{ active: link.active }"
          :href="link.url"
          v-html="getLinkLabel(link.label)"
        />
      </li>
    </template>
  </ul>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: { Link },
  props: {
    links: Array,
  },
  methods: {
    // Clean up labels for better mobile display
    getLinkLabel(label) {
      if (label === "Previous") return "&lsaquo;";
      if (label === "Next") return "&rsaquo;";
      return label;
    },
  },
};
</script>

<style scoped>
.pagination {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
}

.page-item {
  margin-bottom: 0.25rem;
  flex-shrink: 0; /* Prevent buttons from shrinking */
}

.page-link {
  white-space: nowrap; /* Prevent text wrapping within buttons */
}

/* Mobile specific styles */
@media (max-width: 576px) {
  .page-link {
    padding: 0.35rem 0.5rem;
    min-width: 2rem;
    text-align: center;
  }

  /* Make active page more visible */
  .page-item.active .page-link {
    font-weight: bold;
  }

  /* Style for Previous/Next buttons */
  .page-link[aria-label="Previous"],
  .page-link[aria-label="Next"] {
    padding: 0.35rem 0.65rem;
  }
}
</style>