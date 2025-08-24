@extends('layouts.dashboard-app')

@section('content')
    <div class="p-3 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Produk', 'url' => route('calendar.index')],
            ['label' => 'Ketersediaan', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="m-0 px-4 py-4 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Nama Unit : {{ $product['name'] ?? 'Nama Villa' }}
                </h3>
                @if (auth()->check() && auth()->user()->isDeveloper())
                    <div class="flex justify-start space-x-2">
                        <button type="button"
                            class="btn-modal-add-event bg-blue-500 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-600 dark:hover:bg-blue-400 transition"
                            data-modal-target="update-modal-0" data-modal-toggle="update-modal-0">Kelola Unit</button>
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] sm:col-span-1 max-w-4xl mx-auto"
                        data-api-key="{{ env('SANCTUM_TOKEN_PREFIX') }}" data-product-id="{{ $product['id'] }}"
                        data-owner="{{ auth()->check() ? GetUser()->email : '' }}"
                        data-isPartner="{{ GetUser()->isPartner() }}" data-isDeveloper="{{ GetUser()->isDeveloper() }}" data-isCollab="{{ GetUser()->isCollab() }}"
                        data-isAdmin="{{ GetUser()->isAdmin() }}">
                        <div class="flatpickr"></div>

                        <div class="flex items-center justify-start px-4 py-2 pb-4 gap-4">
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                🔴 Full Booking
                            </p>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                🟢 Some Booking
                            </p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] {{ (auth()->check() && auth()->user()->isCollab()) ? 'hidden' : '' }}">
                    <div class="border-t border-gray-100 dark:border-gray-800">

                        <div
                            class="rounded-2xl p-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            @if ($errors->any())
                                <div class="mb-4">
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                        role="alert">
                                        <ul class="list-disc pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('calendar.store') }}" method="post">
                                @csrf

                                <input type="hidden" id="product_id" name="product_id" value="{{ $product['id'] }}" />
                                <!-- Untuk pengurangan Unit yang tersedia -->
                                <input type="hidden" id="totalUnitPerDate" name="totalUnitPerDate"
                                    value="{{ json_encode($totalUnitPerDate ?? []) }}" />
                                <span class="block text-gray-500 text-sm dark:text-gray-400">Reservation Manual</span>
                                <div class="mt-4">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Jumlah Unit Tersedia
                                        </label>
                                        <div class="relative">
                                            <input type="number" id="unit" name="unit"
                                                value="{{ $product['unit'] ?? 0 }}"
                                                default-value="{{ $product['unit'] ?? 0 }}" readonly
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Nama Pemesan
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="name" name="name"
                                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                                placeholder="Nama Pemesan" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Masukkan Tanggal
                                        </label>
                                        <div class="relative">
                                            <div id="date-range-picker" date-rangepicker class="flex items-center">
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                        </svg>
                                                    </div>
                                                    <input id="datepicker-range-start" name="start_date" type="text"
                                                        inputmode="none" readonly
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="Select date start">
                                                </div>
                                                <span class="mx-4 text-gray-500">to</span>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                        </svg>
                                                    </div>
                                                    <input id="datepicker-range-end" name="end_date" type="text"
                                                        inputmode="none" readonly
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="Select date end">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Jumlah Unit
                                        </label>
                                        <div class="relative">
                                            <div class="relative flex items-center max-w-[11rem]">
                                                <button type="button" id="decrement-button"
                                                    data-input-counter-decrement="unit-count"
                                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>
                                                <input type="text" id="unit-count" name="unit_count"
                                                    data-input-counter data-input-counter-min="1"
                                                    data-input-counter-max="{{ $product['unit'] ?? 1 }}"
                                                    aria-describedby="helper-text-explanation"
                                                    class="bg-gray-50 border-x-0 border-gray-300 h-11 font-medium text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pb-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="" value="1" required />
                                                <div
                                                    class="absolute bottom-1 start-1/2 -translate-x-1/2 rtl:translate-x-1/2 flex items-center text-xs text-gray-400 space-x-1 rtl:space-x-reverse">
                                                    <svg class="w-2.5 h-2.5 text-gray-400" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9" />
                                                    </svg>
                                                    <span>Units</span>
                                                </div>
                                                <button type="button" id="increment-button"
                                                    data-input-counter-increment="unit-count"
                                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="mt-7 ms-auto block text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl p-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between mb-4">
                    <span class="block mb-4 text-gray-500 text-sm dark:text-gray-400">Daftar Reservation</span>
                    <div id="helper-all-approve" class="flex items-center justify-end gap-1"></div>
                </div>
                <div class="overflow-x-auto w-full">
                    <table id="table-events"></table>
                </div>
            </div>
        </div>
    </div>

    <x-modals.modal-form type="update" key="0" textButton="Simpan" :data="[
        'title' => 'Manage Unit Produk',
        'form' => [
            [
                'type' => 'number',
                'name' => 'unit',
                'label' => 'Jumlah Unit',
                'value' => $product['unit'] ?? 0,
            ],
        ],
        'action' => route('calendar.updateProductUnit', ['product' => $product['id'] ?? '']),
    ]" />
@endsection

@push('scripts')
    @if (session()->has('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                window.showSuccessSwal(
                    "Success",
                    `{{ session()->get('success') }}`
                );
            });
        </script>
    @endif

    <script>
        function approveAllReservation(productId, date) {
            fetch(`https://villahoteldieng.com/api/v1/reservations/${productId}/${date}/acceptAll`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ env('SANCTUM_TOKEN_PREFIX', '') }}', // Ganti {API_KEY} dengan kunci API Anda
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
                    showSuccessSwal('Berhasil', data.message);
                    console.log('Success:', data.message);
                })
                .catch(error => {
                    showSuccessSwal('Gagal', error);
                    console.error('Error:', error);
                });
        }

        function rejectAllReservation(productId, date) {
            fetch(`https://villahoteldieng.com/api/v1/reservations/${productId}/${date}/rejectAll`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ env('SANCTUM_TOKEN_PREFIX', '') }}', // Ganti {API_KEY} dengan kunci API Anda
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
                    showSuccessSwal('Berhasil', data.message);
                    console.log('Success:', data.message);
                })
                .catch(error => {
                    showSuccessSwal('Gagal', error);
                    console.error('Error:', error);
                });
        }

        function approveReservation(id) {
            fetch(`https://villahoteldieng.com/api/v1/reservations/${id}/accept`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ env('SANCTUM_TOKEN_PREFIX', '') }}', // Ganti {API_KEY} dengan kunci API Anda
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
                    showSuccessSwal('Berhasil', data.message);
                    console.log('Success:', data.message);
                })
                .catch(error => {
                    showSuccessSwal('Gagal', error);
                    console.error('Error:', error);
                });
        }

        function rejectReservation(id) {
            fetch(`https://villahoteldieng.com/api/v1/reservations/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ env('SANCTUM_TOKEN_PREFIX', '') }}', // Ganti {API_KEY} dengan kunci API Anda
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
                    showSuccessSwal('Berhasil', data.message);
                    console.log('Success:', data.message);
                })
                .catch(error => {
                    showSuccessSwal('Gagal', error.message);
                    console.error('Error:', error.message);
                });
        }
    </script>
@endpush
