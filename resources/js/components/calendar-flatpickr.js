import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";

class VillaCalendar {
    /**
     * Inisialisasi instance VillaCalendar
     * @param {Object} [options={}] Opsi-opsi untuk instance VillaCalendar
     * @param {string} [options.apiKey] API key untuk reservasi
     * @param {string} [options.produkId] ID produk yang akan direservasi
     * @param {HTMLElement} [options.calendarWrapper] Element yang akan digunakan sebagai wrapper untuk calendar
     * @param {Object} [options.elements] Element-element yang akan digunakan dalam VillaCalendar
     * @param {HTMLElement} [options.elements.startDateInput] Element yang akan digunakan sebagai input tanggal start
     * @param {HTMLElement} [options.elements.endDateInput] Element yang akan digunakan sebagai input tanggal end
     */
    constructor() {
        this.calendarWrapper = document.querySelector(".flatpickr");
        if (!this.calendarWrapper) {
            console.error("Calendar wrapper (.flatpickr) not found in DOM");
            return;
        }

        this.apiKey = this.calendarWrapper
            .closest("[data-api-key]")
            ?.getAttribute("data-api-key");
        this.produkId = this.calendarWrapper
            .closest("[data-product-id]")
            ?.getAttribute("data-product-id");
        this.owner = this.calendarWrapper.closest("[data-owner]")
            ?.getAttribute("data-owner");
        this.isPartner = this.calendarWrapper.closest("[data-ispartner]")
            ?.getAttribute("data-ispartner") === "1";
        if (!this.apiKey || !this.produkId) {
            console.error("Missing API key or product ID", {
                apiKey: this.apiKey,
                produkId: this.produkId,
            });
            return;
        }

        this.elements = {
            /**
             * Element yang akan digunakan sebagai input tanggal start
             * @type {HTMLElement}
             */
            startDateInput: document.querySelector("#datepicker-range-start"),
            /**
             * Element yang akan digunakan sebagai input tanggal end
             * @type {HTMLElement}
             */
            endDateInput: document.querySelector("#datepicker-range-end"),
        };

        /**
         * Data-data events yang akan ditampilkan dalam calendar
         * @type {Object[]}
         */
        this.events = [];

        /**
         * Data-data total unit yang tersedia per tanggal
         * @type {Object<string, { unit: number }>}
         */
        this.totalUnitPerDate = JSON.parse(
            document.querySelector("#totalUnitPerDate")?.value || "[]"
        );

        /**
         * Instance Flatpickr yang akan digunakan dalam VillaCalendar
         * @type {flatpickr.Instance}
         */
        this.flatpickrInstance = null;

        /**
         * Status-status yang akan digunakan dalam VillaCalendar
         * @type {Object<string, { color: string, label: string }>}
         */
        this.statusMap = {
            full: { color: "!bg-red-200", label: "🔴 Full Booking" },
            some: { color: "!bg-green-200", label: "🟢 Some Booking" },
            none: { color: "", label: "" },
        };

        this.initialize();
    }

    initialize() {
        if (!this.calendarWrapper || !this.apiKey || !this.produkId) return;
        this.initializeFlatpickr();
        this.fetchEvents();
        this.renderEventsForDate(new Date().toISOString().split("T")[0]);
    }

    /**
     * Membuat instance Flatpickr pada elemen wrapper kalender
     * @returns {void}
     */
    initializeFlatpickr() {
        this.flatpickrInstance = flatpickr(this.calendarWrapper, {
            // menampilkan kalender secara inline
            inline: true,
            // mode single untuk memilih tanggal tunggal
            mode: "single",
            // format tanggal yang diinginkan
            dateFormat: "Y-m-d",
            // fungsi yang akan dijalankan saat membuat elemen hari dalam kalender
            onDayCreate: (dObj, dStr, fp, dayElem) => {
                // mengambil tanggal yang dipilih dalam format YYYY-MM-DD
                let dateStr = dayElem.dateObj.toISOString().split("T")[0];
                // menghitung tanggal sebelumnya
                const previousDate = new Date(dayElem.dateObj);
                previousDate.setDate(previousDate.getDate());
                // mengubah tanggal ke format YYYY-MM-DD
                dateStr = previousDate.toISOString().split("T")[0];
                // mencari event yang sesuai dengan tanggal yang dipilih
                const event = this.events.find((e) => e.date === dateStr);

                if (event && event.booking_status && this.statusMap[event.booking_status]) {
                    // menambahkan class css yang sesuai dengan status booking
                    const classes = [
                        this.statusMap[event.booking_status].color,
                        "cursor-pointer",
                        "rounded",
                        "p-1",
                        "text-center",
                    ].filter((cls) => cls);
                    dayElem.classList.add(...classes);
                    // menambahkan tooltip yang sesuai dengan status booking
                    dayElem.title = event.booking_status === "full" ? "Fully Booked" : "Partially Booked";
                }
            },
            // fungsi yang akan dijalankan saat tanggal diubah
            onChange: (selectedDates) => {
                if (selectedDates.length === 1) {
                    // mengambil tanggal yang dipilih
                    const selectedDate = new Date(selectedDates[0]);
                    // menghitung tanggal sebelumnya
                    selectedDate.setDate(selectedDate.getDate() + 1);
                    // mengubah tanggal ke format YYYY-MM-DD
                    const formattedDate = selectedDate
                        .toISOString()
                        .split("T")[0];

                    // mengambil input unit
                    const unitInput = document.querySelector("#unit");
                    // mengambil nilai default dari input unit
                    const defaultValue = Number(
                        unitInput.getAttribute("default-value") || 0
                    );
                    // mengambil nilai unit per tanggal yang sesuai
                    const unitPerDate =
                        this.totalUnitPerDate[formattedDate] || 0;
                    // mengatur nilai input unit menjadi nilai default dikurangi nilai unit per tanggal
                    unitInput.value = defaultValue - unitPerDate;
                    unitInput.setAttribute("value", unitInput.value);

                    // menggambar tabel events untuk tanggal yang dipilih
                    selectedDate.setDate(selectedDate.getDate() - 1); // mengurangi 1 hari untuk menyesuaikan dengan tanggal yang dipilih

                    this.renderEventsForDate(selectedDate
                        .toISOString()
                        .split("T")[0]);
                }
            },
        });
    }

    /**
     * Menggambar tabel events untuk tanggal yang dipilih
     * @param {string} date - Tanggal yang dipilih dalam format YYYY-MM-DD
     * @returns {void}
     */
    async renderEventsForDate(date) {
        // menetapkan nilai atribut ke bidang input
        const [year, month, day] = date.split("-");
        this.elements.startDateInput.value = `${month}/${day}/${year}`;
        this.elements.endDateInput.value = `${month}/${day}/${year}`;

        // mengambil data reservasi berdasarkan tanggal yang dipilih
        const reservations = await this.getReservationByDate(date, this.produkId);
        const table = document.getElementById("table-events");
        if (!table) return;

        // mengatur class untuk tabel
        table.className =
            "w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400";

        const tbody =
            table.querySelector("tbody") || document.createElement("tbody");
        const thead =
            table.querySelector("thead") || document.createElement("thead");
        table.appendChild(tbody);
        table.appendChild(thead);
        tbody.innerHTML = "";
        thead.innerHTML = "";

        // membuat baris header
        const headerRow = document.createElement("tr");
        headerRow.className =
            "text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400";
        const headers = [
            "No",
            "Nama Pemesan",
            "Nama Unit",
            "Jumlah Unit",
            "Status",
        ];
        headers.forEach((header) => {
            const th = document.createElement("th");
            th.textContent = header;
            th.className = "px-6 py-3";
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);

        // jika tidak ada reservasi untuk tanggal yang dipilih
        if (!Array.isArray(reservations) || reservations.length === 0) {
            const row = document.createElement("tr");
            const cell = document.createElement("td");
            cell.colSpan = headers.length;
            cell.textContent = "Tidak ada reservasi untuk tanggal ini.";
            cell.className = "text-center px-6 py-4";
            row.appendChild(cell);
            tbody.appendChild(row);
            return;
        }

        // menggambar tabel berdasarkan data reservasi
        reservations.forEach((res, idx) => {
            const row = document.createElement("tr");
            row.className =
                "odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200";

            // const idShort = typeof res.id === "string" ? res.id.substring(0, 2).toUpperCase() : "";

            row.innerHTML = `
                <td class="px-6 py-4">
                    <a href="${
                        res.transaksi_id
                            ? `/reservation/${res.transaksi_id}`
                            : "#"
                    }" class="text-blue-600 dark:text-blue-500 hover:underline">
                        ${idx + 1}
                    </a>
                </td>
                <td class="px-6 py-4">${res.name}</td>
                <td class="px-6 py-4">${res.produk_name}</td>
                <td class="px-6 py-4">${res.unit}</td>
                <td class="px-6 py-4">
                    <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                        ${
                            res.status === "PENDING"
                                ? "bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500"
                                : res.status === "APPROVED"
                                ? "bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500"
                                : res.status === "REJECTED"
                                ? "bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500"
                                : ""
                        }">
                        ${res.status}
                    </span>
                </td>
            `;
            tbody.appendChild(row);
        });

        // mengatur wrapper untuk tabel
        const parent = table.parentElement;
        const wrapper = document.createElement("div");
        wrapper.className = "overflow-x-auto relative shadow-md sm:rounded-lg";
        parent.replaceChild(wrapper, table);
        wrapper.appendChild(table);
    }

    /**
     * Mengambil data ketersediaan produk untuk tanggal yang dipilih
     * @param {number} attempt - Jumlah percobaan yang dilakukan
     * @param {number} maxAttempts - Jumlah maksimal percobaan yang dilakukan
     * @returns {Promise<void>}
     */
    async fetchEvents(attempt = 1, maxAttempts = 3) {
        try {
            // Membuat request ke server untuk mengambil data ketersediaan produk
            const response = await fetch(
                `https://villahoteldieng.com/api/v1/availability/${this.produkId}`,
                {
                    // Header yang dikirimkan ke server
                    headers: {
                        Authorization: `Bearer ${this.apiKey}`,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                }
            );

            // Jika server mengembalikan kode error
            if (!response.ok) {
                // Mengambil pesan error dari server
                const errorText = await response.text();
                throw new Error(
                    `HTTP error: ${response.status} - ${errorText}`
                );
            }

            // Mengambil data dari server
            const data = await response.json();
            // Jika data tidak berupa array maka throw error
            if (!Array.isArray(data)) {
                throw new Error("Invalid response format: Expected an array");
            }

            // Membuat object yang berisi data ketersediaan produk untuk setiap tanggal
            const dateMap = {};
            data.forEach((event) => {
                if (!dateMap[event.date]) {
                    dateMap[event.date] = {
                        // Inisialisasi unit dan ids untuk setiap tanggal
                        ...event,
                        unit: 0,
                        ids: [],
                    };
                }
                // Menambahkan unit dan ids untuk setiap tanggal
                dateMap[event.date].unit += Number(event.unit);
                dateMap[event.date].ids.push(event.id);
            });

            // Mengatur status booking untuk setiap tanggal
            this.events = Object.values(dateMap).map((event) => {
                let bookingStatus = "none";
                if (event.unit >= event.product_unit) {
                    bookingStatus = "full";
                } else if (event.unit > 0 && event.unit < event.product_unit) {
                    bookingStatus = "some";
                }
                return { ...event, booking_status: bookingStatus };
            });

            // Jika flatpickr instance tidak null maka jump ke tanggal yang dipilih
            this.flatpickrInstance?.jumpToDate(new Date());
        } catch (error) {
            // Jika terjadi error maka print error
            console.error("Fetch events error:", {
                message: error.message,
                attempt,
                url: `https://villahoteldieng.com/api/v1/availability/${this.produkId}`,
                apiKey: this.apiKey ? "Provided" : "Missing",
            });

            // Jika jumlah percobaan kurang dari maxAttempts maka ulangi
            if (attempt < maxAttempts) {
                // Ulangi fetchEvents dengan menambahkan 1 ke attempt
                return setTimeout(
                    () => this.fetchEvents(attempt + 1, maxAttempts),
                    1000
                );
            }
        }
    }

    /**
     * Mengambil data reservasi berdasarkan tanggal
     * @param {string} date Format tanggal YYYY-MM-DD
     * @returns {Promise<Array<Object>>} Data reservasi
     */
    async getReservationByDate(date, productId = this.produkId) {
        try {
            // Fetch data reservasi berdasarkan tanggal
            const response = await fetch(
                // URL API untuk mengambil data reservasi berdasarkan tanggal
                `https://villahoteldieng.com/api/v1/reservations/by-date/${date}/${productId}`,
                {
                    // Method GET
                    method: "GET",
                    // Header dengan Authorization dan Content-Type
                    headers: {
                        Authorization: `Bearer ${this.apiKey}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            // Mendapatkan informasi pemilik dan status kemitraan
            const owner = this.owner
                ? { email: this.owner.toLowerCase() }
                : null;
            const isPartner = this.isPartner;
            const responseJson = await response.json();

            // Jika respons berhasil
            if (response.ok) {
                // Jika tidak ada informasi pemilik atau bukan partner, langsung kembalikan data
                if (owner == null || !isPartner) {
                    return responseJson;
                }

                // Jika data bukan array, kembalikan array kosong
                if (!Array.isArray(responseJson)) {
                    return [];
                }

                // Memfilter data berdasarkan pemilik untuk partner
                return responseJson.filter((data) => {
                    return (
                        data?.produk_owner &&
                        data.produk_owner.toLowerCase() ==
                            owner.email.toLowerCase()
                    );
                    return data;
                });
            }

            // Jika respons tidak berhasil, lemparkan error
            const errorMessage = `HTTP error: ${response.status}`;
            if (responseJson?.message) {
                throw new Error(`${errorMessage} : ${responseJson.message}`);
            }
            throw new Error(errorMessage);
        } catch (error) {
            // Jika terjadi error maka print error
            console.error("Get reservation error:", error.message);
            // Return array kosong jika terjadi error
            return [];
        }
    }

    closeModal() {
        // Implementation of closeModal (assumed to exist elsewhere)
    }

    async addEvent() {
        // Implementation of addEvent (assumed to use saveEventToServer)
    }

    /**
     * Menyimpan event ke server.
     * @param {Object} eventData - Data event yang akan disimpan.
     * @returns {Promise<Object>} - Data respons dari server.
     * @throws {Error} - Jika terjadi kesalahan saat menyimpan event.
     */
    async saveEventToServer(eventData) {
        try {
            // Melakukan request POST ke endpoint untuk menyimpan event
            const response = await fetch(
                `https://villahoteldieng.com/api/v1/availability/${this.produkId}`,
                {
                    method: "POST", // Menggunakan method HTTP POST
                    headers: {
                        Authorization: `Bearer ${this.apiKey}`, // Token otorisasi API
                        "Content-Type": "application/json", // Tipe konten JSON
                    },
                    body: JSON.stringify(eventData), // Mengubah eventData menjadi string JSON
                }
            );

            // Jika response tidak OK, lemparkan error
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

            // Mengembalikan data respons dalam format JSON
            return await response.json();
        } catch (error) {
            // Menangani error dan mencetak pesan error ke konsol
            console.error("Save event error:", error.message);
            // Lemparkan kembali error untuk ditangani oleh pemanggil
            throw error;
        }
    }
}

document.addEventListener("DOMContentLoaded", () => new VillaCalendar());