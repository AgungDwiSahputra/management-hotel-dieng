<div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-99999">
    <div
        class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-full max-w-md border border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Manage Booking
        </h2>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input id="event-title" type="text"
                class="w-full p-2 border rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                placeholder="Booking Status">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date
                Range</label>
            <input id="event-date-range" type="text"
                class="w-full p-2 border rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                placeholder="Select date range">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking
                Status</label>
            <div class="flex flex-col space-y-2">
                <label class="flex items-center text-gray-800 dark:text-gray-200">
                    <input type="radio" name="booking-status" value="full"
                        class="mr-2 text-blue-500 focus:ring-blue-500">
                    <span class="text-red-600 dark:text-red-400">🔴 Full Booking</span>
                </label>
                <label class="flex items-center text-gray-800 dark:text-gray-200">
                    <input type="radio" name="booking-status" value="some"
                        class="mr-2 text-blue-500 focus:ring-blue-500">
                    <span class="text-green-600 dark:text-green-400">🟢 Some Booking</span>
                </label>
                <label class="flex items-center text-gray-800 dark:text-gray-200">
                    <input type="radio" name="booking-status" value="none"
                        class="mr-2 text-blue-500 focus:ring-blue-500">
                    <span>No Booking</span>
                </label>
            </div>
        </div>
        <div class="flex justify-end space-x-2">
            <button
                class="btn-add-event hidden bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:hover:bg-blue-400 transition">Add</button>
            <button
                class="btn-update-event hidden bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 dark:hover:bg-green-400 transition">Update</button>
            <button
                class="btn-delete-event hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 dark:hover:bg-red-400 transition">Delete</button>
            <button
                class="modal-close-btn bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 dark:hover:bg-gray-400 transition">Close</button>
        </div>
    </div>
</div>
