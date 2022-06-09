<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome, {{ $user->name}}. You're logged in!
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 py-24 flex justify-center">
                    @if($user->approved)
                    <p class="text-2xl text-green-500">Your account is approved</p>
                    @else
                    <p class="text-2xl text-red-500">Your account is not yet approved</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>