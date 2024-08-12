<template>
  <ul class="pagination mb-0" v-if="links.length > 0">
    <template v-for="(link, p) in links" :key="p">
      <!-- <li class="page-item">
        <Link class="page-link" href="javascript:void(0);" tabindex="-1">
          <template v-html="link.label"></template>
        </Link>
      </li> -->

      <template v-if="link.url === null" />
      <li class="page-item">
        <Link class="page-link active" :href="link.url" v-html="link.label" />
      </li>
    </template>
    <!-- <li class="page-item active">
      <a class="page-link" href="javascript:void(0);">1</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0);">2</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0);">3</a>
    </li>
    <li class="page-item page-next">
      <a class="page-link" href="javascript:void(0);">Next</a>
    </li> -->
  </ul>

  <!-- <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, p) in links" :key="p">
        <div
          v-if="link.url === null"
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
          v-html="link.label"
        />
        <Link
          v-else
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
          :class="{ 'bg-blue-700 text-white': link.active }"
          :href="link.url"
          v-html="link.label"
        />
      </template>
    </div>
  </div> -->
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  components: { Link },
  props: {
    links: Array,
  },
};
</script>