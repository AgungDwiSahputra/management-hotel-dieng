@props([
    'headers' => ['ID', 'Nama Produk', 'Kamar', 'Max. Orang', 'Harga Weekday', 'Harga Weekend', 'Dibuat', 'Action'],
    'rows' => [
        [
            'id' => 'd03d9b8e-6a20-407e-8a24-4c5d266466b7',
            'category_id' => 'cd12155b-fca6-4418-8515-a2e9dacc97e3',
            'name' => '1 Kamar Best View Lantai 3',
            'slug' => '1-kamar-best-view-lantai-3',
            'unit' => 1,
            'kamar' => 1,
            'orang' => 4,
            'maks_orang' => 6,
            'lokasi' => '1 Kamar Best View Lantai 3',
            'harga_weekday' => 500000,
            'harga_weekend' => 600000,
            'label' => null,
            'urutan' => 5,
            'created_at' => '2025-07-01T23:58:02.000000Z',
            'updated_at' => '2025-07-01T23:58:12.000000Z',
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
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($rows as $key => $row)
                    <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-500 text-theme-xs font-bold">
                                {{ strtoupper(substr($row['id'], 0, 2)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $row['name'] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['kamar'] }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['maks_orang'] }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span
                                class="text-gray-500 text-theme-sm dark:text-gray-400">Rp{{ number_format($row['harga_weekday'], 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span
                                class="text-gray-500 text-theme-sm dark:text-gray-400">Rp{{ number_format($row['harga_weekend'], 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($row['created_at'])->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('calendar.show', $row['id']) }}"
                                    class="flex items-center gap-1 rounded-full px-3 py-1.5 border border-gray-300 bg-blue-500 dark:bg-blue-900 text-theme-sm font-medium text-white dark:text-white hover:bg-blue-600 dark:hover:bg-blue-800 transition duration-300">
                                    <span>Ketersediaan</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
