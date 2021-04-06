<style>
.actions{
    float:right;
}
</style>

<style>
    .panel {
    margin-bottom: 22px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
    
}

.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: 0.25em;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #666 !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    *cursor: hand;
    color: #333 !important;
    border: 1px solid transparent;
    border-radius: 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    *cursor: hand;
    color: #333 !important;
    border: 1px solid transparent;
    border-radius: 2px;
}

.dataTables_wrapper .dataTables_paginate .ellipsis {
    padding: 0 1em;
}

.dataTables_wrapper .dataTables_info {
    clear: both;
    float: left;
    padding-top: 0.755em;
}

.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: 0.25em;
}

.panel-default>.panel-heading {
    color: #333;
    background-color: #fff;
    border-color: #d3e0e9;
}

div#datatable_filter {
    display: inline;
    float: right;
}

div#datatable_length {
    display: inline;
}
    </style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"  style="display:inline">
            {{ __('Admin Dashboard') }}
        </h2>
        <div class="actions">
        <a href="{{route('events')}}"><p style="display:inline; margin-right: 14px;">Events</p></a>
        <a href="{{route('tickets')}}"><p style="display:inline; margin-right:14px">Tickets</p></a>
        </div>

    </x-slot>

    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                
                <!-- Set platinum ticket price form  -->
                <div style="width:30%; margin:20px; padding:20px; border:1px solid #D6D7D9; float:left; border-radius:5px">
                <p>Set ticket cost</p>
                <p style="font-size:11px">{{ Session::get('notification') }}</p>
                <br>
                
                <form method="POST" action="{{ route('update.ticket') }}">
                @csrf
                <p style="display:inline;">Ticket name: </p>
                <p style="display:inline;font-weight:bold">Platinum</p>
                <br>
                <p style="display:inline">Cost: </p>
                <b>₹</b><input type="number" name="cost" style="margin-left:5px; height: 25px; font-weight:bold">
                <br>
                <br>
                <button type="submit" style="padding:5px; border:2px solid black; background-color:#F3F4F6">Submit</button>
                </form>

                </div>
                
                <!-- Datagrid for all tickets/seats -->
                <div style="width:60%; margin:20px; float:left; margin:20px; padding:20px; border:1px solid #D6D7D9; border-radius:5px;">
                
                <table style="width:100%">
                <tr>
                <td style="font-weight:bold">Name</td>
                <td style="font-weight:bold">Reservation %</td>
                <td style="font-weight:bold">Cost</td>
                </tr>

                @foreach($tickets as $t)
                <tr>

                <td>{{ $t->name }}</td>
                <td>{{ $t->reserve }}</td>
                <td>{{ $t->cost }}</td>

                </tr>
                @endforeach

                </table>

                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-top:50px">

                
            
                <!-- Datagrid for all events -->
                <div style="width:97%; margin:20px; float:left; margin:20px; padding:20px; border:1px solid #D6D7D9; border-radius:5px;">
                
                <table style="width:100%">
                <tr>
                <td style="font-weight:bold">Event</td>
                <td style="font-weight:bold">Total seats</td>
                <td style="font-weight:bold">Available seats</td>

                <td style="font-weight:bold">Silver seats</td>
                <td style="font-weight:bold">Platinum seats</td>
                <td style="font-weight:bold">Gold seats</td>
                <td style="font-weight:bold">Total revenue</td>
                
                </tr>

                @foreach($events as $t)
                <tr>

                <td>{{ $t->name }}</td>
                <td>{{ $t->total_seats }}</td>
                <td>{{ $t->available_seats }}</td>

                <td>
                
                

                <table>
                <tr>
                <td>
                {{ $t->silver }} / {{ $t->total_silver }}
                </td>
                </tr>

                <tr>
                <td>
                ₹{{ $t->silver_revenue }}
                </td>
                </tr>
                </table>
                
                </td>
                <td>
                
                
                <table>
                <tr>
                <td>
                {{ $t->platinum }} / {{ $t->total_platinum }}
                </td>
                </tr>

                <tr>
                <td>
                ₹{{ $t->platinum_revenue }}
                </td>
                </tr>
                </table>
                
                </td>

                <td>
                <table>
                <tr>
                <td>
                {{ $t->gold }} / {{ $t->total_gold }}
                </td>
                </tr>

                <tr>
                <td>
                ₹{{ $t->gold_revenue }}
                </td>
                </tr>
                </table>
                </td>

                <td>{{ $t->total_revenue }}</td>

                </tr>
                @endforeach

                </table>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
