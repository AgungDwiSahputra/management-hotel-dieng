@props([
    'headers' => ['ID', 'Nama Produk', 'Kamar', 'Max. Orang', 'Harga Weekday', 'Harga Weekend', 'Dibuat', 'Action'],
    'rows' => [
        [
            'id' => 'd03d9b8e-6a20-407e-8a24-4c5d266466b7',
            'category_id' => 'cd12155b-fca6-4418-8515-a2e9dacc97e3',
            'owner' => 'admin@app.com',
            'name' => '1 Kamar Best View Lantai 3',
            'slug' => '1-kamar-best-view-lantai-3',
            'unit' => 1,
            'total_reservations' => 0,
            'kamar' => 1,
            'orang' => 4,
            'maks_orang' => 6,
            'lokasi' => '1 Kamar Best View Lantai 3',
            'harga_weekday' => 500000,
            'harga_weekend' => 600000,
            'label' => null,
            'urutan' => 5,
            'status' => 'draft',
            'created_at' => '2025-07-01T23:58:02.000000Z',
            'updated_at' => '2025-07-01T23:58:12.000000Z',
        ],
    ],
    'btnAction' => [
        [
            'label' => 'Ketersediaan',
            'route' => 'calendar.show',
            'method' => null,
        ],
    ],
])

<div class="overflow-hidden rounded-xl p-5 sm:p-6 bg-white dark:bg-gray-900 dark:border-gray-800">
    <div class="max-w-full overflow-x-auto">
        <table id="default-table" class="datatable min-w-full bg-white dark:bg-gray-900">
            <!-- table header start -->
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    @foreach ($headers as $header)
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    {{ $header }}
                                </p>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <!-- table header end -->
            <!-- table body start -->
            @if (!empty($rows))
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($rows as $key => $row)
                        <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                            @isset($row['id'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-500 text-theme-xs font-bold">
                                        {{ strtoupper(substr($row['id'], 0, 2)) }}
                                    </span>
                                </td>
                            @endisset
                            @isset($row['name'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $row['name'] }}
                                    </span>
                                </td>
                            @endisset
                            @isset($row['slug'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['slug'] }}</span>
                                </td>
                            @endisset
                            @isset($row['unit'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['unit'] }}</span>
                                </td>
                            @endisset
                            @isset($row['kamar'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['kamar'] }}</span>
                                </td>
                            @endisset
                            @isset($row['maks_orang'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['maks_orang'] }}</span>
                                </td>
                            @endisset
                            @isset($row['harga_weekday'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span
                                        class="text-gray-500 text-theme-sm dark:text-gray-400">Rp{{ number_format($row['harga_weekday'], 0, ',', '.') }}</span>
                                </td>
                            @endisset
                            @isset($row['harga_weekend'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span
                                        class="text-gray-500 text-theme-sm dark:text-gray-400">Rp{{ number_format($row['harga_weekend'], 0, ',', '.') }}</span>
                                </td>
                            @endisset
                            @isset($row['total_reservations'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['total_reservations'] }}</span>
                                </td>
                            @endisset
                            @isset($row['created_at'])
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($row['created_at'])->format('d M Y') }}
                                    </span>
                                </td>
                            @endisset
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-1">
                                    @foreach ($btnAction as $btn)
                                        @if ($btn['method'] == 'delete')
                                            <form action="{{ route($btn['route'], $row['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-1 rounded-full px-3 py-1.5 border border-red-500 bg-red-500 dark:bg-red-900 text-theme-sm font-medium text-white dark:text-white hover:bg-red-600 dark:hover:bg-red-800 transition duration-300">
                                                    <span>{{ $btn['label'] }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route($btn['route'], $row['id']) }}"
                                                class="flex items-center gap-1 rounded-full px-3 py-1.5 border border-gray-300 bg-blue-500 dark:bg-blue-900 text-theme-sm font-medium text-white dark:text-white hover:bg-blue-600 dark:hover:bg-blue-800 transition duration-300">
                                                <span>{{ $btn['label'] }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <tr>
                        <td colspan="{{ count($headers) + 1 }}" class="px-5 py-4 sm:px-6 text-center">Data belum tersedia</td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>
</div>
