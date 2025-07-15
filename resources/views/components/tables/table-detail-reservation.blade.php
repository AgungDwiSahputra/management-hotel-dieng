@props([
    'headers' => ['ID', 'Produk', 'Tanggal Reservasi', 'Unit', 'Status', 'Dibuat', 'Action'],
    'rows' => [
        [
            'id' => 'f4834db4-80a3-4fa6-be46-4390bbedb5a8',
            'transaksi_id' => 'c88513d9-69ca-4bbb-80aa-c96ee7a9e22d',
            'date' => '2025-07-08',
            'unit' => 1,
            'status' => 'PENDING',
            'created_at' => '2025-07-06T03:37:47.000000Z',
            'produk_name' => 'FULL HOUSE BEST VIEW',
            'category_name' => 'Villa',
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
                            <div
                                class="w-10 h-10 overflow-hidden rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-theme-xs font-bold">
                                    {{ strtoupper(substr($row['id'], 0, 2)) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div>
                                <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $row['produk_name'] ?? '-' }}
                                </span>
                                <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    {{ $row['category_name'] ?? '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['date'] }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['unit'] }}</span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span
                                class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                                @if ($row['status'] === 'PENDING') bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500
                                @elseif ($row['status'] === 'APPROVED')
                                    bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500
                                @elseif ($row['status'] === 'REJECTED')
                                    bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500 @endif 
                            ">
                                {{ $row['status'] }}
                            </span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($row['created_at'])->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-2">
                                <button
                                    onclick="showConfirmationSwal('Menyetujui Pemesanan ?', 'Anda yakin ingin menyetujui pemesanan ini ?', 'warning', () => approveReservation('{{ $row['id'] }}'))"
                                    class="flex items-center gap-1 rounded-full px-3 py-1.5 border border-green-500 bg-green-500 dark:bg-green-700 text-theme-sm font-medium text-white hover:bg-green-600 dark:hover:bg-green-800 transition duration-300 shadow-sm">
                                    <span>Approve</span>
                                </button>
                                <button
                                    onclick="showConfirmationSwal('Menolak Pemesanan ?', 'Anda yakin ingin menolak pemesanan ini ?', 'warning', () => rejectReservation('{{ $row['id'] }}'))"
                                    class="flex items-center gap-1 rounded-full px-3 py-1.5 border border-red-500 bg-red-500 dark:bg-red-700 text-theme-sm font-medium text-white hover:bg-red-600 dark:hover:bg-red-800 transition duration-300 shadow-sm">
                                    <span>Reject</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
