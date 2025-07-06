@extends('layouts.app')

@section('content')
    <div class="h-screen flex items-center justify-center flex-col bg-white p-8 rounded-lg shadow-md w-full max-w-3xl">
        <div class="block w-full">
            <img class="w-50 mx-auto my-8" width="50" height="50" src="{{ asset('assets/images/logo.png') }}"
                alt="Logo Vila Hotel Dieng">
        </div>
        <span class="w-full mb-3 block text-start text-gray-700">Welcome to Admin Dashboard</span>
        <p class="text-gray-600">This is the main page for administrators.</p>

        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
@endsection
