@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Produk', 'url' => route('product.index')],
            ['label' => 'Buat Produk', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Buat Produk
                    </h3>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.products.form
                        :action="route('product.store')"
                        :method="'post'"
                        :inputs="[
                            'name' => ['label' => 'Nama Produk', 'type' => 'text', 'value' => old('name'), 'required' => true],
                            'unit' => ['label' => 'Jumlah Unit', 'type' => 'number', 'value' => old('unit'), 'required' => true],
                            'harga_weekday' => ['label' => 'Harga Weekday', 'type' => 'number', 'value' => old('harga_weekday'), 'required' => true],
                            'harga_weekend' => ['label' => 'Harga Weekend', 'type' => 'number', 'value' => old('harga_weekend'), 'required' => true],
                        ]"
                        :btn-cancel="['label' => 'Batal']"
                        :btn-submit="['label' => 'Simpan']"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
