@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Admin', 'url' => route('admin.index')],
            ['label' => 'Detail Admin', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Detail Admin
                    </h3>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.admins.form
                        :action="request()->routeIs('admin.show') ? null : route('admin.update', $admin['id'])"
                        :method="request()->routeIs('admin.show') ? null : 'put'"
                        :inputs="[
                            'name' => ['label' => 'Nama Admin', 'type' => 'text', 'value' => old('name', $admin['name']), 'required' => true],
                            'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email', $admin['email']), 'required' => true],
                            'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password')],
                            'password_confirmation' => [
                                'label' => 'Konfirmasi Password',
                                'type' => 'text',
                                'value' => old('password_confirmation'),
                            ],
                        ]"
                        :btn-cancel="[
                            'label' => 'Batal',
                            'class' => request()->routeIs('admin.show') ? 'hidden' : 'from-red-400 via-red-500 to-red-600 focus:ring-red-300 dark:focus:ring-red-800'
                        ]"
                        :btn-submit="[
                            'label' => 'Ubah',
                            'class' => request()->routeIs('admin.show') ? 'hidden' : 'from-blue-500 via-blue-600 to-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800'
                        ]"
                    />
                </div>
            </div>

            @if((isset($products) && count($products) > 0) || (request()->routeIs('admin.show')))
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Products Admin
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
            @endif
        </div>
    </div>
@endsection
