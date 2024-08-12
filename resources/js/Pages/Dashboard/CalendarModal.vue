<template>
  <div
    class="modal fade"
    ref="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog custom-modal-width">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Schedule a tour</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="hideModal"
          ></button>
        </div>
        <div class="modal-body">
          <p>Selected Date: {{ formattedEventDate }}</p>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Property Title</th>
              </tr>
            </thead>
            <tbody v-if="eventData && eventData.events.length > 0">
              <tr v-for="(event, index) in eventData.events" :key="event.id">
                <td>{{ index + 1 }}</td>
                <td>{{ formatDate(event.date_time_start) }}</td>
                <td>{{ formatTime(event.date_time_start) }}</td>
                <td>{{ formatTime(event.date_time_end) }}</td>
                <td>{{ event.name }}</td>
                <td>{{ event.telephone }}</td>
                <td>{{ event.email }}</td>
                <td>{{ event.property_title }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CalendarModal",
  props: {
    eventDate: {
      type: String,
      required: true,
    },
    eventData: {
      type: Object,
      required: true,
      default: () => ({ events: [] }), // Default empty events array
    },
  },
  data() {
    return {
      modalInstance: null,
    };
  },
  mounted() {
    this.modalInstance = new bootstrap.Modal(this.$refs.exampleModal);
  },
  methods: {
    showModal() {
      this.modalInstance.show();
    },
    hideModal() {
      this.modalInstance.hide();
    },
    formatDate(datetime) {
      const date = new Date(datetime);
      const formattedDate = `${date.getDate().toString().padStart(2, "0")}-${(
        date.getMonth() + 1
      )
        .toString()
        .padStart(2, "0")}-${date.getFullYear()}`;
      return formattedDate;
    },
    formatTime(datetime) {
      const time = new Date(datetime);
      const formattedTime = time.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });
      return formattedTime;
    },
  },
  computed: {
    formattedEventDate() {
      return this.formatDate(this.eventDate);
    },
  },
};
</script>

<style scoped>
.custom-modal-width {
  max-width: 80%;
  width: 80%;
}
</style>
