import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

class VillaCalendar {
  constructor() {
    this.calendarWrapper = document.querySelector("#calendar");
    if (!this.calendarWrapper) return;

    this.apiKey = this.calendarWrapper.getAttribute("data-api-key");
    this.produkId = this.calendarWrapper.getAttribute("data-product-id");
    this.eventModal = document.getElementById("eventModal");
    this.elements = {
      title: document.querySelector("#event-title"),
      startDate: document.querySelector("#event-start-date"),
      endDate: document.querySelector("#event-end-date"),
      addBtn: document.querySelector(".btn-add-event"),
      updateBtn: document.querySelector(".btn-update-event"),
      deleteBtn: document.querySelector(".btn-delete-event"),
      closeBtns: document.querySelectorAll(".modal-close-btn"),
    };

    this.eventColors = { Danger: "danger", Success: "success" };
    this.calendarEvents = [];
    this.calendar = null;

    this.initialize();
  }

  initialize() {
    this.setupEventListeners();
    this.initializeCalendar();
    this.fetchEvents();
  }

  setupEventListeners() {
    this.elements.closeBtns.forEach(btn => btn.addEventListener("click", () => this.closeModal()));
    this.eventModal.addEventListener("click", e => {
      if (e.target === this.eventModal) this.closeModal();
    });
    this.elements.addBtn.addEventListener("click", () => this.addEvent());
    this.elements.updateBtn.addEventListener("click", () => this.updateEvent());
    this.elements.deleteBtn.addEventListener("click", () => this.deleteEvent());
  }

  initializeCalendar() {
    this.calendar = new Calendar(this.calendarWrapper, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      selectable: true,
      initialView: "dayGridMonth",
      initialDate: `${new Date().getFullYear()}-${String(new Date().getMonth() + 1).padStart(2, "0")}-07`,
      headerToolbar: {
        left: "addEventButton",
        center: "title",
        right: "prev,next today",
      },
      events: this.calendarEvents,
      select: info => this.handleSelect(info),
      eventClick: info => this.handleEventClick(info),
      dateClick: () => this.openAddModal(),
      customButtons: {
        addEventButton: { text: "Tambah Ketersediaan +", click: () => this.openAddModal() },
      },
      eventClassNames: ({ event }) => [
        "event-fc-color",
        `fc-bg-${this.eventColors[event._def.extendedProps.calendar]}`,
      ],
    });
    this.calendar.render();
  }

  async fetchEvents() {
    try {
      const response = await fetch(`https://villahoteldieng.com/api/v1/availability/${this.produkId}`, {
        headers: { Authorization: `Bearer ${this.apiKey}`, "Content-Type": "application/json" },
      });
      if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
      const data = await response.json();
      this.calendarEvents = data.map(event => ({
        id: event.id,
        title: event.is_available === 0 ? "❌ Tidak Tersedia" : "✔️ Tersedia",
        start: event.date,
        extendedProps: {
          calendar: event.is_available === 0 ? "Danger" : "Success",
          produk_id: event.produk_id,
          is_available: event.is_available,
        },
      }));
      this.calendar.removeAllEvents();
      this.calendar.addEventSource(this.calendarEvents);
    } catch (error) {
      console.error("Fetch events error:", error);
    }
  }

  openModal(mode = "add", event = null) {
    this.resetModalFields();
    this.elements.addBtn.style.display = mode === "add" ? "flex" : "none";
    this.elements.updateBtn.style.display = mode === "edit" ? "block" : "none";
    this.elements.deleteBtn.style.display = mode === "edit" ? "block" : "none";
    
    if (mode === "edit" && event) {
      this.elements.title.value = event.title;
      this.elements.startDate.value = event.startStr.slice(0, 10);
      this.elements.endDate.value = event.endStr ? event.endStr.slice(0, 10) : "";
      const radio = document.querySelector(`input[value="${event.extendedProps.calendar}"]`);
      if (radio) radio.checked = true;
      this.elements.updateBtn.dataset.fcEventPublicId = event.id;
      this.elements.deleteBtn.dataset.fcEventPublicId = event.id;
    }
    this.eventModal.style.display = "flex";
  }

  closeModal() {
    this.eventModal.style.display = "none";
    this.resetModalFields();
  }

  resetModalFields() {
    this.elements.title.value = "";
    this.elements.startDate.value = "";
    this.elements.endDate.value = "";
    const checkedRadio = document.querySelector('input[name="event-level"]:checked');
    if (checkedRadio) checkedRadio.checked = false;
  }

  openAddModal() {
    const today = new Date().toISOString().slice(0, 10) + "T00:00:00";
    this.openModal("add");
    this.elements.startDate.value = today;
  }

  handleSelect(info) {
    this.openModal("add");
    this.elements.startDate.value = info.startStr;
    this.elements.endDate.value = info.endStr || info.startStr;
  }

  handleEventClick(info) {
    if (info.event.url) {
      window.open(info.event.url);
      info.jsEvent.preventDefault();
      return;
    }
    this.openModal("edit", info.event);
  }

  async addEvent() {
    const eventData = this.prepareEventData();
    try {
      await this.saveEventToServer(eventData);
      this.calendar.addEvent({
        id: Date.now(),
        title: this.elements.title.value,
        start: this.elements.startDate.value,
        end: this.elements.endDate.value,
        allDay: true,
        extendedProps: { calendar: eventData.dates[0].is_available === 0 ? "Danger" : "Success" },
      });
      this.closeModal();
    } catch (error) {
      console.error("Add event error:", error);
      showSuccessSwal("Gagal", error.message || "Failed to add event");
    }
  }

  async updateEvent() {
    const eventId = this.elements.updateBtn.dataset.fcEventPublicId;
    const eventData = this.prepareEventData();
    try {
      await this.updateEventOnServer(eventId, eventData);
      const event = this.calendar.getEventById(eventId);
      event.setProp("title", this.elements.title.value);
      event.setDates(this.elements.startDate.value, this.elements.endDate.value);
      event.setExtendedProp("calendar", eventData.dates[0].is_available === 0 ? "Danger" : "Success");
      this.closeModal();
    } catch (error) {
      console.error("Update event error:", error);
      showSuccessSwal("Gagal", error.message || "Failed to update event");
    }
  }

  async deleteEvent() {
    const eventId = this.elements.deleteBtn.dataset.fcEventPublicId;
    try {
      await this.deleteEventFromServer(eventId);
      this.calendar.getEventById(eventId)?.remove();
      this.closeModal();
    } catch (error) {
      console.error("Delete event error:", error);
      showSuccessSwal("Gagal", error.message || "Failed to delete event");
    }
  }

  prepareEventData() {
    const radio = document.querySelector('input[name="event-level"]:checked');
    const eventData = { dates: [] };
    const startDate = new Date(this.elements.startDate.value);
    const endDate = new Date(this.elements.endDate.value);

    while (startDate <= endDate) {
      eventData.dates.push({
        id_calendar: Date.now(),
        date: startDate.toISOString().split("T")[0],
        is_available: radio?.value === "Danger" ? 0 : 1,
      });
      startDate.setDate(startDate.getDate() + 1);
    }
    return eventData;
  }

  async saveEventToServer(eventData) {
    const response = await fetch(`https://villahoteldieng.com/api/v1/availability/${this.produkId}`, {
      method: "POST",
      headers: { Authorization: `Bearer ${this.apiKey}`, "Content-Type": "application/json" },
      body: JSON.stringify({ dates: eventData.dates }),
    });
    if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
    const data = await response.json();
    showSuccessSwal("Berhasil", data.message || "Event added successfully");
    await this.fetchEvents();
  }

  async updateEventOnServer(eventId, eventData) {
    const response = await fetch(`https://villahoteldieng.com/api/v1/availability/${this.produkId}/${eventId}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${this.apiKey}`, "Content-Type": "application/json" },
      body: JSON.stringify(eventData),
    });
    if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
    const data = await response.json();
    showSuccessSwal("Berhasil", data.message || "Event updated successfully");
    await this.fetchEvents();
  }

  async deleteEventFromServer(eventId) {
    const response = await fetch(`https://villahoteldieng.com/api/v1/availability/${this.produkId}/${eventId}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${this.apiKey}`, "Content-Type": "application/json" },
    });
    if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
    const data = await response.json();
    showSuccessSwal("Berhasil", data.message || "Event deleted successfully");
    await this.fetchEvents();
  }
}

document.addEventListener("DOMContentLoaded", () => new VillaCalendar());