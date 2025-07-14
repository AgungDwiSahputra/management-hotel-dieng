@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Reservation', 'url' => null]
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Pemesanan List
                    </h3>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <!-- ====== Table Six Start -->
                    <x-tables.table-reservation :rows="$reservations"/>
                    <!-- ====== Table Six End -->
                </div>
            </div>
        </div>

        <x-js.flowbite-datatable />
    @endsection
