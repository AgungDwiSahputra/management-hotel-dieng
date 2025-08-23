@props([
    'action' => route('collab.store'),
    'method' => 'post',
    'inputs' => [
        'name' => ['label' => 'Nama Collab', 'type' => 'text', 'value' => old('name')],
        'email' => ['label' => 'Email', 'type' => 'email', 'value' => old('email')],
        'password' => ['label' => 'Password', 'type' => 'text', 'value' => old('password')],
        'password_confirmation' => [
            'label' => 'Konfirmasi Password',
            'type' => 'text',
            'value' => old('password_confirmation'),
        ],
    ],
    'selects' => [
        'label' => 'Produk',
        'name' => 'product',
        'options' => [
            ['value' => '1', 'label' => 'Product 1'],
            ['value' => '2', 'label' => 'Product 2'],
        ],
        'value' => is_array(old('product')) ? old('product') : [],
    ],
    'btnCancel' => [
        'label' => 'Batal',
        'class' => 'from-red-400 via-red-500 to-red-600 focus:ring-red-300 dark:focus:ring-red-800',
    ],
    'btnSubmit' => [
        'label' => 'Simpan',
        'class' => 'from-blue-500 via-blue-600 to-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800',
    ]
])

<form class="px-5 py-4 sm:px-6 sm:py-5" action="{{ $action }}" method="post">
    @csrf
    @if ($method === 'put')
        @method('PUT')
    @elseif ($method === 'patch')
        @method('PATCH')
    @elseif ($method === 'delete')
        @method('DELETE')
    @else
        @method('POST')
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @foreach ($inputs as $name => $input)
            <div>
                @if ($input['type'] === 'text')
                    <x-form.input-text name="{{ $name }}" label="{{ $input['label'] }}" value="{{ $input['value'] }}" />
                @elseif ($input['type'] === 'email')
                    <x-form.input-email name="{{ $name }}" label="{{ $input['label'] }}" value="{{ $input['value'] }}" />
                @elseif ($input['type'] === 'number')
                    <x-form.input-number name="{{ $name }}" label="{{ $input['label'] }}" value="{{ $input['value'] }}" />
                @endif
            </div>
        @endforeach
        <x-form.select-multiple name="{{ $selects['name'] }}" label="{{ $selects['label'] }}" :options="$selects['options']" :value="$selects['value']" />
    </div>

    <div class="flex items-center justify-end gap-1 mt-5">
        <button type="button" onclick="window.location.href = '{{ route('collab.index') ?? '' }}'"
            class="text-white bg-gradient-to-r hover:bg-gradient-to-br focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 {{ $btnCancel['class'] ?? 'from-red-400 via-red-500 to-red-600 focus:ring-red-300 dark:focus:ring-red-800' }}">{{ $btnCancel['label'] ?? '' }}</button>
        <button type="submit"
            class="text-white bg-gradient-to-r hover:bg-gradient-to-br focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 {{ $btnSubmit['class'] ?? 'from-blue-500 via-blue-600 to-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800' }}">{{ $btnSubmit['label'] ?? '' }}</button>
    </div>
</form>
