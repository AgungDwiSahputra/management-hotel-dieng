@extends('layouts.dashboard-app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Collab', 'url' => route('collab.index')],
            ['label' => 'Detail Collab', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Detail Collab
                    </h3>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.collabs.form
                        :action="request()->routeIs('collab.show') ? null : route('collab.update', $collab['id'])"
                        :method="request()->routeIs('collab.show') ? null : 'put'"
                        :inputs="[
                            'name' => ['label' => 'Nama Collab', 'type' => 'text', 'value' => old('name', $collab['name']), 'required' => true],
                            'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email', $collab['email']), 'required' => true],
                            'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password')],
                            'password_confirmation' => [
                                'label' => 'Konfirmasi Password',
                                'type' => 'text',
                                'value' => old('password_confirmation'),
                            ],
                        ]"
                        :selects="[
                            'label' => 'Izin Produk',
                            'name' => 'permission_product',
                            'options' => collect($products)->map(fn($product) => [
                                'value' => $product['id'],
                                'label' => $product['name'],
                            ])->toArray(),
                            'value' => is_array(old('permission_product', $collab_permissions)) ? old('permission_product', $collab_permissions) : [],
                        ]"
                        :btn-cancel="[
                            'label' => 'Batal',
                            'class' => request()->routeIs('collab.show') ? 'hidden' : 'from-red-400 via-red-500 to-red-600 focus:ring-red-300 dark:focus:ring-red-800'
                        ]"
                        :btn-submit="[
                            'label' => 'Ubah',
                            'class' => request()->routeIs('collab.show') ? 'hidden' : 'from-blue-500 via-blue-600 to-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800'
                        ]"
                    />
                </div>
            </div>

            {{-- @if((isset($products) && count($products) > 0) || (request()->routeIs('collab.show')))
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Products Collab
                        </h3>
                    </div>
                    <!-- Alert -->
                    @if ($errors->any())
                        <x-alert.alert-1 :error="$errors->first()" />
                    @elseif (session()->has('success') || session()->has('error'))
                        <x-alert.alert-1 :success="session('success')" :error="session('error')" />
                    @endif
                    <div class="border-t border-gray-100 dark:border-gray-800">
                        <!-- ====== Table Six Start -->
                        <x-tables.table-products 
                            :headers="['ID', 'Nama', 'Unit', 'Harga Weekday', 'Harga Weekend', 'Aksi']" 
                            :rows="$products" 
                            :btnAction="[
                                [
                                    'label' => 'Hapus',
                                    'route' => 'product.destroy',
                                    'method' => 'delete',
                                ],
                            ]" 
                        />
                        <!-- ====== Table Six End -->
                    </div>
                </div>
            @endif --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script>
@endsection
