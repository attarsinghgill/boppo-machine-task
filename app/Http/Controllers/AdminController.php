<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\event;
use App\Models\ticket;
use App\Models\sale;

class AdminController extends Controller
{
    function dashboard(){
        //calculate total revenue
        $sales = sale::all();
        $total_sales = array();

        foreach($sales as $item){
            array_push($total_sales, $item->total_cost);
        }

        $total_sales = array_sum($total_sales);

        
        return view('dashboard', ['total_revenue'=>$total_sales]);
    }

    function delete_event($id){
        
    }

    function set_ticket_cost(Request $request){
        $cost_platinum = $request->cost;
        
        //update the cost of platinum]
        $t = ticket::where('name','platinum')->update(['cost'=>$cost_platinum]);

        //calculate the cost of gold  - 70% of platinum's price
        $cost_gold = 0.7 * $cost_platinum;
        $t_two = ticket::where('name','gold')->update(['cost'=>$cost_gold]);

        //calculate the cost of silver - 80% of gold's price 
        $cost_silver = 0.8 * $cost_gold;
        $t_three = ticket::where('name','silver')->update(['cost'=>$cost_silver]);

        return back()->with(['notification'=>'Cost updated successfully']);
    }

    function tickets(){
        //fetch all tickets
        $tickets = ticket::all();

        //fetch all events
        $events = event::all();


        return view('ticket-manage', ['tickets'=>$tickets, 'events'=>$events]);

    }


    function create_event(Request $request){
        /**
         * Silver seats - 25%
         * Platinum seats - 35%
         * Gold seats - 40%
         */
        $silver = 0.25 * $request->seats;

        if(gettype($silver) == 'double'){
            return back()->with(['notification'=>"Seat distribution not possible with silver:". $silver]);
        }

        $platinum = 0.35 * $request->seats;

        if(gettype($platinum) == 'double'){
            return back()->with(['notification'=>"Seat distribution not possible with platinum:".$platinum]);
        }


        $gold = 0.4 * $request->seats;

        if(gettype($gold) == 'double'){
            return back()->with(['notification'=>'Seat distribution not possible with gold:'. $gold]);
        }

        $event = new event;
        $event->name = $request->name;
        $event->total_seats = $request->seats;
        $event->available_seats = $request->seats;

        $event->silver = $silver;
        $event->platinum = $platinum;
        $event->gold = $gold;

        $event->total_silver = $silver;
        $event->total_platinum = $platinum;
        $event->total_gold = $gold;

        $event->save();

        return back()->with(['notification'=>'Event Created Successfully']);
    }


    function events(){
        //fetch all events
        $events = event::all();
        return view('event-manage', ['events'=>$events]);
    }
}
