@props([
    'headers' => ['ID', 'Nama Partner', 'Email', 'Tanggal Buat', 'Action'],
    'rows' => [
        [
            "id" => 4,
            "name" => "Partner User",
            "email" => "partner@app.com",
            "email_verified_at" => "2025-07-22 07:23:34",
            "remember_token" => "zlWyOdUsf6Ss90QTkr3ketwK2FQnD1f5emDG2QMdjClKDyzHVUGGaKLJOzun",
            "created_at" => "2025-07-22 07:23:34",
            "updated_at" => "2025-07-22 07:23:34",
        ],
    ],
    'btnAction' => [
        [
            'label' => 'Ubah',
            'route' => 'partner.edit',
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
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($rows as $key => $row)
                    <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                        @isset($row['id'])
                            <td class="px-5 py-4 sm:px-6">
                                <span class="text-gray-500 text-theme-xs font-bold">
                                    {{ $row['id'] }}
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
                        @isset($row['email'])
                            <td class="px-5 py-4 sm:px-6">
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $row['email'] }}</span>
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
        </table>
    </div>
</div>
