@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Admin', 'url' => route('admin.index')],
            ['label' => 'Buat Admin', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Buat Admin
                    </h3>
                </div>
                <!-- Alert -->
                @if ($errors->any())
                    <x-alert.alert-1 :error="$errors->first()" />
                @elseif (session()->has('success') || session()->has('error'))
                    <x-alert.alert-1 :success="session('success')" :error="session('error')" />
                @endif
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.admins.form :action="route('admin.store')" :method="'post'" :inputs="[
                        'name' => ['label' => 'Nama Admin', 'type' => 'text', 'value' => old('name'), 'required' => true],
                        'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email'), 'required' => true],
                        'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password'), 'required' => true],
                        'password_confirmation' => [
                            'label' => 'Konfirmasi Password',
                            'type' => 'text',
                            'value' => old('password_confirmation'),
                            'required' => true,
                        ],
                    ]" :btn-cancel="['label' => 'Batal']"
                        :btn-submit="['label' => 'Simpan']" />
                </div>
            </div>
        </div>
    </div>
@endsection
