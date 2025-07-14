@extends('layouts.dashboard-app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <!-- Metric Group One -->
                {{-- <include src="./partials/metric-group/metric-group-01.html" /> --}}
                @include('partials.metric-group.metric-group-01')
                <!-- Metric Group One -->

                <!-- ====== Table One Start -->
                {{-- <include src="./partials/table/table-01.html" /> --}}
                <x-tables.table-reservation :rows="$reservations"/>
                <!-- ====== Table One End -->
            </div>
        </div>
    </div>

    <x-js.flowbite-datatable />
@endsection
