<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
    <!-- Total Pendapatan Pemesanan per-Bulan -->
    <x-box.metric-item title="Total Pemesanan (per-Bulan)" count="{{ 'Rp. ' . number_format($countTotalReservationPerMonth[date('m')], 0, ',', '.') }}" showPercent="true" percent="{{ $percentTotalReservationPerMonth }}" />

    <!-- Total Pendapatan Pemesanan Semua -->
    <x-box.metric-item title="Total Pemesanan (Semua)" count="{{ 'Rp. ' . number_format($countTotalReservation, 0, ',', '.') }}" />

    <!-- Total Produk -->
    <x-box.metric-item title="Total Produk" count="{{ $countProcuts ?? 0 }}" />

    <!-- Total Pemesanan -->
    <x-box.metric-item title="Total Pemesanan" count="{{ $countReservations ?? 0 }}" />
</div>
