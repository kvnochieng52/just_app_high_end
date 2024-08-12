<template>
  <Head title="Dashboard" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <UserNav />
        <div class="col-xl-9 col-lg-12 col-md-12">
          <div class="card mb-0">
            <div class="card-header">
              <h3 class="card-title">Calendar</h3>
            </div>
            <div class="card-body">
              <div id="calendar"></div>
              <CalendarModal
                ref="calendarModal"
                :eventDate="eventDate"
                :eventData="eventData"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import UserNav from "./UserNav.vue";
import { ref, onMounted } from "vue";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import CalendarModal from "./CalendarModal.vue";
import axios from "axios";

export default {
  name: "Calendar",
  props: {
    calendarEvents: {
      type: Array,
      default: () => [],
    },
    userID: Number,
  },
  components: {
    CalendarModal,
    UserNav,
  },
  data() {
    return {
      calendar: null,
      eventDate: null,
      eventData: null,
    };
  },
  mounted() {
    this.calendar = new Calendar(document.getElementById("calendar"), {
      plugins: [dayGridPlugin, interactionPlugin],
      initialView: "dayGridMonth",
      events: this.calendarEvents,
      dateClick: this.handleDateClick,
      eventClick: this.handleEventClick,
    });
    this.calendar.render();
  },
  methods: {
    formatDate(date) {
      const d = new Date(date);
      const day = String(d.getDate()).padStart(2, "0");
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const year = d.getFullYear();
      return `${year}-${month}-${day}`;
    },
    async handleDateClick(info) {
      this.eventDate = this.formatDate(info.date);
      this.fetchEventData(this.eventDate);
      this.openModal();
    },
    async handleEventClick(clickedInfo) {
      this.eventDate = this.formatDate(clickedInfo.event.start);
      this.fetchEventData(this.eventDate);
      this.openModal();
    },
    async fetchEventData(date) {
      try {
        const response = await axios.get("/calendar/get-events", {
          params: {
            date: date,
            userID: this.userID,
          },
        });
        this.eventData = response.data;
        this.openModal(); // Open modal after fetching data
      } catch (error) {
        console.error("Error fetching event data:", error);
        this.eventData = null; // Handle error state as needed
      }
    },
    openModal() {
      this.$refs.calendarModal.showModal();
    },
    closeModal() {
      this.$refs.calendarModal.hideModal();
    },
  },
};
</script>
