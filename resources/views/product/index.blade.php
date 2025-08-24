@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[['label' => 'Beranda', 'url' => route('dashboard')], ['label' => 'Products', 'url' => null]]" />
        <!-- Breadcrumb End -->

        <!-- Alert -->
        <x-alert.alert-1 :success="session('success')" :error="session('error')" />

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Produk List
                    </h3>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('product.create') }}"
                            class="btn-primary bg-blue-500 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-600 dark:hover:bg-blue-400 transition">
                            Tambah Produk
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-800">
                    <!-- ====== Table Six Start -->
                    <x-tables.table-products 
                        :headers="(GetUser()->isPartner() || GetUser()->isCollab() ? ['ID', 'Nama', 'Unit', 'Aksi'] : ['ID', 'Nama', 'Unit', 'Harga Weekday', 'Harga Weekend', 'Aksi'])" 
                        :rows="$products" 
                        :btnAction="(GetUser()->isPartner() ? [[ 'label' => 'Hapus', 'route' => 'product.destroy', 'method' => 'delete' ]] : [[ 'label' => 'Edit', 'route' => 'product.edit', 'method' => null ], [ 'label' => 'Hapus', 'route' => 'product.destroy', 'method' => 'delete' ]])" 
                    />
                    <!-- ====== Table Six End -->
                </div>
            </div>
        </div>
    </div>

    <x-js.flowbite-datatable />
@endsection
