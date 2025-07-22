@props([
    'type' => 'show',
    'key' => '0',
    'textButton' => 'Ubah Data',
    'data' => [
        'title' => 'Create New Pemesanan',
        'form' => [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Nama Produk',
                'value' => 'Agung Dwi Sahputra',
            ],
            [
                'type' => 'number',
                'name' => 'price',
                'label' => 'Harga',
            ],
            [
                'type' => 'select',
                'name' => 'category',
                'label' => 'Kategori',
                'options' => [
                    ['value' => '', 'label' => 'Pilih Kategori'],
                    ['value' => 'Villa', 'label' => 'Villa'],
                    ['value' => 'Hotel', 'label' => 'Hotel'],
                    ['value' => 'Cottage', 'label' => 'Cottage'],
                ],
            ],
            [
                'type' => 'textarea',
                'name' => 'description',
                'label' => 'Deskripsi',
            ],
        ],
        'action' => '#',
    ],
])

<div id="{{ $type }}-modal-{{ $key }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $data['title'] }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="{{ $type }}-modal-{{ $key }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ $data['action'] }}" method="POST" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    @foreach ($data['form'] as $field)
                        <div class="col-span-2">
                            <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $field['label'] }}
                            </label>
                            @if ($field['type'] === 'text' || $field['type'] === 'number')
                                <input
                                    type="{{ $field['type'] }}"
                                    name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Masukkan {{ strtolower($field['label']) }}"
                                    value="{{ old($field['name'], $field['value'] ?? '') }}"
                                    @if($type == 'show') readonly @endif
                                    required
                                >
                            @elseif ($field['type'] === 'select')
                                <select
                                    name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    @if($type == 'show') disabled @endif
                                    required
                                >
                                    @foreach ($field['options'] as $option)
                                        <option value="{{ $option['value'] }}" @if(isset($field['value']) && $field['value'] == $option['value']) selected @endif>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif ($field['type'] === 'textarea')
                                <textarea
                                    name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Masukkan {{ strtolower($field['label']) }}"
                                    @if($type == 'show') readonly @endif
                                    required
                                >{{ old($field['name'], $field['value'] ?? '') }}</textarea>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($type != 'show')
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{-- <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg> --}}
                        {{ $textButton }}
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>
