@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Partner', 'url' => route('partner.index')],
            ['label' => 'Detail Partner', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Detail Partner
                    </h3>
                </div>
                <!-- Alert -->
                @if ($errors->any())
                    <x-alert.alert-1 :error="$errors->first()" />
                @elseif (session()->has('success') || session()->has('error'))
                    <x-alert.alert-1 :success="session('success')" :error="session('error')" />
                @endif
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.partners.form
                        :action="route('partner.update', $partner['id'])"
                        :method="'put'"
                        :inputs="[
                            'name' => ['label' => 'Nama Partner', 'type' => 'text', 'value' => old('name', $partner['name']), 'required' => true],
                            'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email', $partner['email']), 'required' => true],
                            'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password')],
                            'password_confirmation' => [
                                'label' => 'Konfirmasi Password',
                                'type' => 'text',
                                'value' => old('password_confirmation'),
                            ],
                        ]"
                        :btn-cancel="['label' => 'Batal']"
                        :btn-submit="['label' => 'Ubah']"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
