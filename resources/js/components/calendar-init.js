import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

/*========Calender Js=========*/
/*==========================*/

document.addEventListener("DOMContentLoaded", function () {
  const calendarWrapper = document.querySelector("#calendar");

  if (calendarWrapper) {
    /*=================*/
    //  Calender Date variable
    /*=================*/
    const newDate = new Date();
    const getDynamicMonth = () => {
      const month = newDate.getMonth() + 1;
      return month < 10 ? `0${month}` : `${month}`;
    };

    /*=================*/
    // Calender Modal Elements
    /*=================*/
    const getModalTitleEl = document.querySelector("#event-title");
    const getModalStartDateEl = document.querySelector("#event-start-date");
    const getModalEndDateEl = document.querySelector("#event-end-date");
    const getModalAddBtnEl = document.querySelector(".btn-add-event");
    const getModalUpdateBtnEl = document.querySelector(".btn-update-event");
    const getModalDeleteBtnEl = document.querySelector(".btn-delete-event");
    const calendarsEvents = {
      Danger: "danger",
      // Success: "success",
      // Primary: "primary",
      // Warning: "warning",
    };

    /*=====================*/
    // Calendar Elements and options
    /*=====================*/
    const calendarEl = document.querySelector("#calendar");

    const calendarHeaderToolbar = {
      left: "addEventButton",
      center: "title",
      right: "prev,next today",
    };

    
    /*=====================*/
    // Calendar Functions
    /*=====================*/
    
    const API_KEY = document.querySelector("#calendar").getAttribute("data-api-key");
    let fetchEvents = null;
    let produk_id = document.querySelector("#calendar").getAttribute("data-product-id");
    getEventByProdukId(produk_id);

    // Calendar Events
    let calendarEventsList = [];
    function updateCalendarEventsList() {
      if (Array.isArray(fetchEvents)) {
      calendarEventsList = fetchEvents.map(event => ({
        id: event.id,
        title: event.is_available === 0 ? "❌ Tidak Tersedia" : "✔️ Tersedia",
        start: event.date,
        extendedProps: {
          calendar: event.is_available === 0 ? "Danger" : "Success",
          produk_id: event.produk_id,
          is_available: event.is_available,
        },
      }));
      }
    }

    /*=====================*/
    // Modal Functions
    /*=====================*/
    const openModal = () => {
      document.getElementById("eventModal").style.display = "flex";
    };

    const closeModal = () => {
      document.getElementById("eventModal").style.display = "none";
      resetModalFields();
    };

    // Close modal when clicking outside of it
    window.onclick = function (event) {
      const modal = document.getElementById("eventModal");
      if (event.target === modal) {
        closeModal();
      }
    };

    /*=====================*/
    // Calendar Select fn.
    /*=====================*/
    const calendarSelect = (info) => {
      resetModalFields();

      getModalAddBtnEl.style.display = "flex";
      getModalUpdateBtnEl.style.display = "none";
      getModalDeleteBtnEl.style.display = "none";
      openModal();
      getModalStartDateEl.value = info.startStr;
      getModalEndDateEl.value = info.endStr || info.startStr;
      getModalTitleEl.value = "";      
    };

    /*=====================*/
    // Calendar AddEvent fn.
    /*=====================*/
    const calendarAddEvent = () => {
      const currentDate = new Date();
      const dd = String(currentDate.getDate()).padStart(2, "0");
      const mm = String(currentDate.getMonth() + 1).padStart(2, "0");
      const yyyy = currentDate.getFullYear();
      const combineDate = `${yyyy}-${mm}-${dd}T00:00:00`;

      getModalAddBtnEl.style.display = "flex";
      getModalUpdateBtnEl.style.display = "none";
      getModalDeleteBtnEl.style.display = "none";
      openModal();
      getModalStartDateEl.value = combineDate;
    };

    /*=====================*/
    // Calender Event Function
    /*=====================*/
    const calendarEventClick = (info) => {
      const eventObj = info.event;

      if (eventObj.url) {
        window.open(eventObj.url);
        info.jsEvent.preventDefault();
      } else {
        const getModalEventId = eventObj._def.publicId;
        const getModalEventLevel = eventObj._def.extendedProps.calendar;
        const getModalCheckedRadioBtnEl = document.querySelector(
          `input[value="${getModalEventLevel}"]`,
        );

        getModalTitleEl.value = eventObj.title;
        getModalStartDateEl.value = eventObj.startStr.slice(0, 10);
        getModalEndDateEl.value = eventObj.endStr
          ? eventObj.endStr.slice(0, 10)
          : "";
        if (getModalCheckedRadioBtnEl) {
          getModalCheckedRadioBtnEl.checked = true;
        }
        getModalUpdateBtnEl.dataset.fcEventPublicId = getModalEventId;
        getModalDeleteBtnEl.dataset.fcEventPublicId = getModalEventId;
        getModalAddBtnEl.style.display = "none";
        getModalUpdateBtnEl.style.display = "block";
        getModalDeleteBtnEl.style.display = "block";
        openModal();

      }
    };

    /*=====================*/
    // Active Calender
    /*=====================*/
    const calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      selectable: true,
      initialView: "dayGridMonth",
      initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
      headerToolbar: calendarHeaderToolbar,
      events: calendarEventsList,
      select: calendarSelect,
      eventClick: calendarEventClick,
      dateClick: calendarAddEvent,
      customButtons: {
        addEventButton: {
          text: "Tambah Ketersediaan +",
          click: calendarAddEvent,
        },
      },
      eventClassNames({ event: calendarEvent }) {
        const getColorValue =
          calendarsEvents[calendarEvent._def.extendedProps.calendar];
        return [`event-fc-color`, `fc-bg-${getColorValue}`];
      },
    });
    
    /*=====================*/
    // Delete Calender Event
    /*=====================*/
    getModalDeleteBtnEl.addEventListener("click", () => {
      const getPublicID = getModalDeleteBtnEl.dataset.fcEventPublicId;

      // Ambil event berdasarkan publicId
      const getEvent = calendar.getEventById(getPublicID);
      
      if (getEvent) {
        // Hapus event dari kalender lokal
        getEvent.remove();

        // Panggil fungsi untuk menghapus event dari server
        deleteEventFromServer(getPublicID, produk_id);

        closeModal();
      } else {
        console.warn("Event not found with ID:", getPublicID);
        closeModal();
      }
    });

    /*=====================*/
    // Update Calender Event
    /*=====================*/
    getModalUpdateBtnEl.addEventListener("click", () => {
      const getPublicID = getModalUpdateBtnEl.dataset.fcEventPublicId;
      const getTitleUpdatedValue = getModalTitleEl.value;
      const setModalStartDateValue = getModalStartDateEl.value;
      const setModalEndDateValue = getModalEndDateEl.value;
      const getEvent = calendar.getEventById(getPublicID);
      const getModalUpdatedCheckedRadioBtnEl = document.querySelector(
        'input[name="event-level"]:checked',
      );

      const getModalUpdatedCheckedRadioBtnValue =
        getModalUpdatedCheckedRadioBtnEl
          ? getModalUpdatedCheckedRadioBtnEl.value
          : "";

      // Buat objek data untuk dikirim ke API dalam format array 'dates'
      const eventData = {
        dates: []
      };

      const startDate = new Date(setModalStartDateValue);
      const endDate = new Date(setModalEndDateValue);

      while (startDate <= endDate) {
        eventData.dates.push({
          id_calendar: Date.now(), // Assuming you want a unique ID
          date: startDate.toISOString().split("T")[0],
          is_available: getModalUpdatedCheckedRadioBtnValue === "Danger" ? 0 : 1
        });

        startDate.setDate(startDate.getDate() + 1);
      }

      // Panggil fungsi untuk memperbarui event di server
      updateEventOnServer(getPublicID, produk_id, eventData);

      // Perbarui event lokal (opsional, setelah konfirmasi dari server)
      getEvent.setProp("title", getTitleUpdatedValue); // Catatan: title mungkin tidak relevan di server
      getEvent.setDates(setModalStartDateValue, setModalEndDateValue);
      getEvent.setExtendedProp("calendar", getModalUpdatedCheckedRadioBtnValue);

      closeModal();
    });

    /*=====================*/
    // Add Calender Event
    /*=====================*/
    getModalAddBtnEl.addEventListener("click", () => {
      const getModalCheckedRadioBtnEl = document.querySelector(
        'input[name="event-level"]:checked',
      );

      const getTitleValue = getModalTitleEl.value;
      const setModalStartDateValue = getModalStartDateEl.value;
      const setModalEndDateValue = getModalEndDateEl.value;
      const getModalCheckedRadioBtnValue = getModalCheckedRadioBtnEl
        ? getModalCheckedRadioBtnEl.value
        : "";

      let DateNow = Date.now();

      calendar.addEvent({
        id: DateNow, // Use unique ID based on timestamp
        title: getTitleValue,
        start: setModalStartDateValue,
        end: setModalEndDateValue,
        allDay: true,
        extendedProps: { calendar: getModalCheckedRadioBtnValue },
      });
      
      // Buat objek data untuk dikirim ke API dalam format array 'dates'
      const eventData = {
        dates: []
      };

      const startDate = new Date(setModalStartDateValue);
      const endDate = new Date(setModalEndDateValue);

      while (startDate < endDate) {
        eventData.dates.push({
          id_calendar: DateNow,
          date: startDate.toISOString().split("T")[0],
          is_available: getModalCheckedRadioBtnValue === "Danger" ? 0 : 1
        });

        startDate.setDate(startDate.getDate() + 1);
      }

      // Panggil fungsi saveEventByProdukId dengan produk_id dan eventData
      saveEventByProdukId(produk_id, eventData);

      closeModal();
    });

    /*=====================*/
    // Calendar Init
    /*=====================*/
    calendar.render();

    // Reset modal fields when hidden
    document.getElementById("eventModal").addEventListener("click", (event) => {
      if (event.target.classList.contains("modal-close-btn")) {
        closeModal();
      }
    });

    function resetModalFields() {
      getModalTitleEl.value = "";
      getModalStartDateEl.value = "";
      getModalEndDateEl.value = "";
      const getModalIfCheckedRadioBtnEl = document.querySelector(
        'input[name="event-level"]:checked',
      );
      if (getModalIfCheckedRadioBtnEl) {
        getModalIfCheckedRadioBtnEl.checked = false;
      }
    }

    document
      .getElementById("eventModal")
      .addEventListener("hidden.bs.modal", () => {
        resetModalFields();
      });

    // Close modal when clicking on close button or outside modal
    document.querySelectorAll(".modal-close-btn").forEach((btn) => {
      btn.addEventListener("click", closeModal);
    });

    window.addEventListener("click", (event) => {
      if (event.target === document.getElementById("eventModal")) {
        closeModal();
      }
    });


    // FETXH API EVENT
    // Fetch events and update calendarEventsList
    function getEventByProdukId(produk_id) {
      fetch(`https://villahoteldieng.com/api/v1/availability/${produk_id}`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`,
        'Content-Type': 'application/json'
      }
      })
      .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
      }
      return response.json();
      })
      .then(data => {
      fetchEvents = data;
      updateCalendarEventsList();
      calendar.removeAllEvents();
      calendar.addEventSource(calendarEventsList);
      })
      .catch(error => {
      console.error('Error:', error);
      });
    }

    function saveEventByProdukId(produk_id, eventData) {
      const url = `https://villahoteldieng.com/api/v1/availability/${produk_id}`;
      const method = 'POST';

      // Pastikan eventData adalah array dates yang sesuai dengan validasi controller
      const requestData = {
        dates: Array.isArray(eventData.dates) ? eventData.dates : [eventData]
      };

      fetch(url, {
        method: method,
        headers: {
          'Authorization': `Bearer ${API_KEY}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          showSuccessSwal('Berhasil', data.message);
          // Refresh calendar events
          // getEventByProdukId(produk_id);
        })
        .catch(error => {
          showSuccessSwal('Gagal', error.message || error);
          console.error('Error:', error);
        });
    }

    // Fungsi untuk memperbarui event di server
    function updateEventOnServer(eventId, produk_id, eventData) {
      const url = `https://villahoteldieng.com/api/v1/availability/${produk_id}/${eventId}`;
      const method = 'PUT'; // Gunakan PUT untuk update

      fetch(url, {
        method: method,
        headers: {
          'Authorization': `Bearer ${API_KEY}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          showSuccessSwal('Berhasil', data.message || 'Event updated successfully.');
          // Refresh calendar events dari server untuk memastikan sinkronisasi
          getEventByProdukId(produk_id);
        })
        .catch(error => {
          showSuccessSwal('Gagal', error.message || error);
          console.error('Error:', error);
        });
    }

    // Fungsi untuk menghapus event dari server
    function deleteEventFromServer(eventId, produk_id) {
      const url = `https://villahoteldieng.com/api/v1/availability/${produk_id}/${eventId}`;
      const method = 'DELETE';

      fetch(url, {
        method: method,
        headers: {
          'Authorization': `Bearer ${API_KEY}`,
          'Content-Type': 'application/json'
        }
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          showSuccessSwal('Berhasil', data.message || 'Event deleted successfully.');
          // Refresh calendar events
          getEventByProdukId(produk_id);
        })
        .catch(error => {
          showSuccessSwal('Gagal', error.message || error);
          console.error('Error:', error);
        });
    }
  }
});
