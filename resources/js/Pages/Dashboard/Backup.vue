<template>
  <div id="calendar"></div>

  <!-- Modal component -->
  <div v-if="showModal" class="modal">
    <div class="modal-content">
      <span class="close" @click="closeModal">&times;</span>
      <h2>{{ modalEvent.title }}</h2>
      <p>Starts: {{ modalEvent.start }}</p>
      <p v-if="modalEvent.end">Ends: {{ modalEvent.end }}</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export default {
  name: "Backup",
  data() {
    return {
      calendar: null,
      calendarEvents: [
        {
          title: "Event 1",
          start: "2024-07-05",
        },
        {
          title: "Event 2",
          start: "2024-07-10",
          end: "2024-07-12",
        },
      ],
      showModal: false,
      modalEvent: null,
    };
  },
  mounted() {
    this.calendar = new Calendar(document.getElementById("calendar"), {
      plugins: [dayGridPlugin, interactionPlugin],
      initialView: "dayGridMonth",
      events: this.calendarEvents,
      dateClick: this.handleDateClick,
      eventClick: this.handleEventClick, // Listen for event click
    });
    this.calendar.render();
  },
  methods: {
    handleDateClick(info) {
      alert("Date clicked: " + info.dateStr);
    },
    handleEventClick(clickedInfo) {
      this.modalEvent = clickedInfo.event.toPlainObject(); // Store event data
      this.showModal = true; // Show the modal
    },
    closeModal() {
      this.showModal = false; // Close the modal
    },
  },
};
</script>

<style scoped>
#calendar {
  max-width: 800px;
  margin: 0 auto;
}

/* Modal styles */
.modal {
  display: block;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
