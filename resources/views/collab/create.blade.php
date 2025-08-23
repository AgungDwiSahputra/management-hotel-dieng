@extends('layouts.dashboard-app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <x-breadcrumb.type-1 :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Collab', 'url' => route('collab.index')],
            ['label' => 'Buat Collab', 'url' => null],
        ]" />
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Buat Collab
                    </h3>
                </div>
                <!-- Alert -->
                @if ($errors->any())
                    <x-alert.alert-1 :error="$errors->first()" />
                @elseif (session()->has('success') || session()->has('error'))
                    <x-alert.alert-1 :success="session('success')" :error="session('error')" />
                @endif
                <div class="border-t border-gray-100 dark:border-gray-800">
                    <x-form.collabs.form :action="route('collab.store')" :method="'post'" :inputs="[
                        'name' => ['label' => 'Nama Collab', 'type' => 'text', 'value' => old('name'), 'required' => true],
                        'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email'), 'required' => true],
                        'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password'), 'required' => true],
                        'password_confirmation' => [
                            'label' => 'Konfirmasi Password',
                            'type' => 'text',
                            'value' => old('password_confirmation'),
                            'required' => true,
                        ],
                    ]" 
                    :selects="[
                        'label' => 'Izin Produk',
                        'name' => 'permission_product',
                        'options' => collect($products)->map(fn($product) => [
                            'value' => $product['id'],
                            'label' => $product['name'],
                        ])->toArray(),
                        'value' => is_array(old('permission_product')) ? old('permission_product') : [],
                    ]"
                    :btn-cancel="['label' => 'Batal']"
                    :btn-submit="['label' => 'Simpan']" />
                </div>
            </div>
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
