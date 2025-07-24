@props([
    'action' => route('product.store'),
    'method' => 'post',
    'inputs' => [
        'name' => ['label' => 'Nama Produk', 'type' => 'text', 'value' => old('name')],
        'unit' => ['label' => 'Jumlah Unit', 'type' => 'number', 'value' => old('unit')],
        'harga_weekday' => ['label' => 'Harga Weekday', 'type' => 'number', 'value' => old('harga_weekday')],
        'harga_weekend' => ['label' => 'Harga Weekend', 'type' => 'number', 'value' => old('harga_weekend')],
    ],
    'btnCancel' => [
        'label' => 'Batal',
    ],
    'btnSubmit' => [
        'label' => 'Simpan',
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
                @elseif ($input['type'] === 'number')
                    <x-form.input-number name="{{ $name }}" label="{{ $input['label'] }}" value="{{ $input['value'] }}" />
                @endif
            </div>
        @endforeach
    </div>

    <div class="flex items-center justify-end gap-1 mt-5">
        <button type="button" onclick="window.location.href = '{{ route('product.index') }}'"
            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">{{ $btnCancel['label'] }}</button>
        <button type="submit"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">{{ $btnSubmit['label'] }}</button>
    </div>
</form>
