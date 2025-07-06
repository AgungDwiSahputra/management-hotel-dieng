@extends('layouts.app')

@section('content')
    <div class="h-screen flex items-center justify-center flex-col bg-white p-8 rounded-lg shadow-md w-full max-w-3xl">
        <div class="block w-full">
            <img class="w-50 mx-auto my-8" width="50" height="50" src="{{ asset('assets/images/logo.png') }}"
                alt="Logo Vila Hotel Dieng">
        </div>
        <span class="w-full mb-3 block text-start text-gray-700">Login to your Account</span>
        <form class="w-full" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <input type="email" name="email" id="email"
                    class="w-full px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-blue" required
                    autofocus autocomplete="email" placeholder="Email">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-blue" required
                    autocomplete="current-password" placeholder="Password">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-start mb-4">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700">Remember me</label>
            </div>
            <button type="submit"
                class="w-full bg-custom-blue text-white py-2 rounded-lg hover:bg-custom-blue/90 transition duration-200 cursor-pointer">Login</button>
        </form>
    </div>
@endsection
