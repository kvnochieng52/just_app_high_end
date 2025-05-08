<template>
  <ul class="pagination mb-0 flex-wrap" v-if="links.length > 0">
    <template v-for="(link, p) in links" :key="p">
      <li
        class="page-item"
        :class="{
          disabled: link.url === null,
          active: link.active,
          'd-none d-sm-block': shouldHidePageNumber(link.label, p),
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
    // Simplify page numbers on mobile
    shouldHidePageNumber(label, index) {
      if (["Previous", "Next", "..."].includes(label)) return false;
      if (index === 0 || index === this.links.length - 1) return false; // Keep first and last
      return !this.links[index].active; // Hide non-active middle pages on mobile
    },
    // Clean up labels for mobile
    getLinkLabel(label) {
      if (label === "Previous") return "&laquo;";
      if (label === "Next") return "&raquo;";
      if (label === "...") return "...";
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
}

/* Mobile specific styles */
@media (max-width: 576px) {
  .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
}
</style>