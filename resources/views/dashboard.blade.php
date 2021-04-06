<style>
.actions{
    float:right;
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"  style="display:inline">
            {{ __('Admin Dashboard') }}
        </h2>
        <div class="actions">
        <a href="{{route('events')}}"><p style="display:inline; margin-right:14px">Events</p></a>
        <a href="{{route('tickets')}}"><p style="display:inline; margin-right:14px">Tickets</p></a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding:30px">
                
                <!-- Total revenue -->
                <div>
                <h3><b>Total Revenue:</b> ₹{{ $total_revenue }}</h2>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
