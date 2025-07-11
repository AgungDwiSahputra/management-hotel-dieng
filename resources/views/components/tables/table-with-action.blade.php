@props([
    'headers' => ['User', 'Project Name', 'Team', 'Status', 'Budget', 'Action'],
    'rows' => [
        [
            1,
            ['user-17.jpg', 'Linsey Curtis', 'Web Designer'],
            'Agency Website',
            ['user-22.jpg', 'user-23.jpg', 'user-24.jpg'],
            'Active',
            '3.9K',
        ],
        [
            2,
            ['user-25.jpg', 'Kaiya George', 'Project Manager'],
            'Technology',
            ['user-25.jpg', 'user-26.jpg'],
            'Pending',
            '24.9K',
        ],
        [3,['user-27.jpg', 'Zain Geidt', 'Content Writter'], 'Blog Writing', ['user-27.jpg'], 'Active', '12.7K'],
        [
            4,
            ['user-28.jpg', 'Abram Schleifer', 'Digital Marketer'],
            'Social Media',
            ['user-28.jpg', 'user-29.jpg', 'user-30.jpg'],
            'Cancel',
            '2.8K',
        ],
        [
            5,
            ['user-31.jpg', 'Carla George', 'Front-end Developer'],
            'Website',
            ['user-31.jpg', 'user-32.jpg', 'user-33.jpg'],
            'Active',
            '4,5K',
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
                            <div class="flex items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 overflow-hidden rounded-full">
                                        <img src="{{ asset('assets/admin-panel/images/user/' . $row[1][0]) }}"
                                            alt="Avatar Image {{ $row[1][1] }}" />
                                    </div>

                                    <div>
                                        <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ $row[1][1] }}
                                        </span>
                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ $row[1][2] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $row[2] }}
                                </p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex -space-x-2">
                                    @foreach ($row[3] as $userImage)
                                        <div
                                            class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                            <img src="{{ asset('assets/admin-panel/images/user/' . $userImage) }}"
                                                alt="user" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p
                                    class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                    {{ $row[4] }}
                                </p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row[5] }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex items-center gap-3">
                                    <button type="button" data-modal-target="show-modal-{{ $key }}" data-modal-toggle="show-modal-{{ $key }}"
                                        class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 transition duration-300 hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path
                                                d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path
                                                d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path
                                                d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7 12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196 15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z"
                                                stroke="#000000" stroke-width="1.5" class="dark:stroke-gray-300" />
                                            <circle cx="12" cy="12" r="2" stroke="#000000"
                                                stroke-width="1.5" class="dark:stroke-gray-300" />
                                        </svg>
                                    </button>
                                    <button type="button" data-modal-target="edit-modal-{{ $key }}" data-modal-toggle="edit-modal-{{ $key }}"
                                        class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 transition duration-300 hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1">
                                            <defs>
                                                <style>
                                                    .cls-1 {
                                                        fill: none;
                                                        stroke: #020202;
                                                        stroke-miterlimit: 10;
                                                        stroke-width: 1.91px;
                                                    }
                                                    .dark .cls-1 {
                                                        stroke: #d1d5db;
                                                    }
                                                </style>
                                            </defs>
                                            <polyline class="cls-1"
                                                points="20.59 12 20.59 22.5 1.5 22.5 1.5 3.41 12.96 3.41" />
                                            <path class="cls-1"
                                                d="M12,15.82l-4.77.95L8.18,12l9.71-9.71A2.69,2.69,0,0,1,19.8,1.5h0a2.7,2.7,0,0,1,2.7,2.7h0a2.69,2.69,0,0,1-.79,1.91Z" />
                                        </svg>
                                    </button>
                                    <button form="delete-reservation-{{ $row[0] }}" type="submit"
                                        class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 transition duration-300 hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M20.5001 6H3.5" stroke="#000000" stroke-width="1.5"
                                                stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path d="M9.5 11L10 16" stroke="#000000" stroke-width="1.5"
                                                stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path d="M14.5 11L14 16" stroke="#000000" stroke-width="1.5"
                                                stroke-linecap="round" class="dark:stroke-gray-300" />
                                            <path
                                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                stroke="#000000" stroke-width="1.5" class="dark:stroke-gray-300" />
                                            <path
                                                d="M18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5M18.8334 8.5L18.6334 11.5"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-gray-300" />
                                        </svg>
                                    </button>
                                    <form id="delete-reservation-{{ $row[0] }}" action="{{ route('reservation.destroy', $row[0]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hidden"></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal toggle -->
                    {{-- <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Toggle modal
                    </button> --}}

                    <!-- Main modal -->
                    <x-modals.modal-form :type="'show'" :key="$key" :data="[
                        'title' => 'Detail Pemesanan',
                        'form' => [
                            'user' => $row[1][1],
                            'project_name' => $row[2],
                            'team' => implode(', ', array_map(fn($img) => asset('assets/admin-panel/images/user/' . $img), $row[3])),
                            'status' => $row[4],
                            'budget' => $row[5],
                        ],
                        'action' => '#',
                    ]" />

                    <x-modals.modal-form :type="'edit'" :key="$key" :data="[
                        'title' => 'Detail Pemesanan',
                        'form' => [
                            'user' => $row[1][1],
                            'project_name' => $row[2],
                            'team' => implode(', ', array_map(fn($img) => asset('assets/admin-panel/images/user/' . $img), $row[3])),
                            'status' => $row[4],
                            'budget' => $row[5],
                        ],
                        'action' => '#',
                    ]" />
                    <!-- End Modal -->
                @endforeach
            </tbody>
        </table>
    </div>
</div>



