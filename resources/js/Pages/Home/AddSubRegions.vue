<template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <!-- Form for adding new subregion -->
        <div class="col-md-12">
          <form @submit.prevent="submitContactForm">
            <div class="form-group">
              <label for="town">Select Town</label>
              <select
                v-model="form.town"
                id="town"
                class="form-control"
                required
              >
                <option v-for="town in towns" :key="town.id" :value="town.id">
                  {{ town.town_name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="regionName">Subregion Name</label>
              <input
                type="text"
                v-model="form.regionName"
                id="regionName"
                class="form-control"
                placeholder="Enter Subregion Name"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary" :disabled="loading">
              <span
                v-if="loading"
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
              ></span>
              <span v-if="loading">Loading...</span>
              <span v-else>Add Subregion</span>
            </button>
          </form>
        </div>

        <!-- Table to display subregions -->
        <div class="col-md-12 mt-5">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Subregion Name</th>
                <th>Town</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="subregion in subregions.data" :key="subregion.id">
                <td>{{ subregion.id }}</td>
                <td>{{ subregion.sub_region_name }}</td>
                <td>{{ getTownName(subregion.town_id) }}</td>
                <td>
                  <button
                    class="btn btn-secondary"
                    @click="
                      toggleSubregionStatus(subregion.id, subregion.is_active)
                    "
                  >
                    {{ subregion.is_active ? "Deactivate" : "Activate" }}
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <Paginator :links="subregions.links" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
import { usePage } from "@inertiajs/inertia-vue3";
import Paginator from "../../Shared/Paginator.vue";

const { props } = usePage();
const title = "Add Subregions";

const form = reactive({
  town: "",
  regionName: "",
});

const loading = ref(false);

const towns = computed(() => props.value.towns);
const subregions = computed(() => props.value.subregions);

const submitContactForm = () => {
  loading.value = true;
  Inertia.post("/home/save-sub-region", form, {
    onFinish: () => {
      loading.value = false;
      form.town = "";
      form.regionName = "";
    },
  });
};

const getTownName = (townId) => {
  const town = towns.value.find((town) => town.id === townId);
  return town ? town.town_name : "Unknown";
};

const toggleSubregionStatus = (subregionId, currentStatus) => {
  Inertia.post("/home/toggle-sub-region-status", {
    subregionId,
    is_active: !currentStatus,
  });
};
</script>
