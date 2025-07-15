@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Reservation', 'url' => route('reservation.index')],
            ['label' => 'Detail Reservation', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Detail Pemesanan List
                    </h3>
                    <button
                        onclick="showConfirmationSwal('Menyetujui Semua Pemesanan ?', 'Anda yakin ingin menyetujui semua pemesanan ini ?', 'warning', () => approveAllReservation('{{ $reservation_details[0]['transaksi_id'] }}'))"
                        class="flex items-center gap-1 ms-auto rounded-full px-3 py-1.5 border border-blue-500 bg-blue-500 dark:bg-blue-700 text-theme-sm font-medium text-white hover:bg-blue-600 dark:hover:bg-blue-800 transition duration-300 shadow-sm">
                        <span>Approve All</span>
                    </button>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <!-- ====== Table Six Start -->
                    <x-tables.table-detail-reservation :rows="$reservation_details" />
                    <!-- ====== Table Six End -->
                </div>
            </div>
        </div>
    </div>

    <x-js.flowbite-datatable />

    <script>
        function approveAllReservation(transaksi_id) {
            fetch(`https://website-hotel-dieng.test/api/v1/reservations/${transaksi_id}/acceptAll`, {
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
            fetch(`https://website-hotel-dieng.test/api/v1/reservations/${id}/accept`, {
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
            fetch(`https://website-hotel-dieng.test/api/v1/reservations/${id}/reject`, {
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
@endsection
