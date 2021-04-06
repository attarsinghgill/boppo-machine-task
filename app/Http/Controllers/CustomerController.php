<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket;
use App\Models\sale;
use App\Models\event;

class CustomerController extends Controller
{
    function book_ticket(Request $request){
        $diced = explode(",", $request->ticket);
        $event_meta = explode(",", $request->event);

        $total = $diced[1] * $request->qty;

        //enter total cost in the event db
            //fetch the previous total revenue and add $total to it
            $prev_total = event::where('id', $event_meta[1])->get()[0]->total_revenue;

            $updated_total = $total + $prev_total;
            $update = event::where('id', $event_meta[1])->update(['total_revenue'=>$updated_total]);

       

            

        if($diced[0] == 'silver'){
            $prev_tick = event::where('id', $event_meta[1])->get()[0]->silver;
            $remaining = event::where('id', $event_meta[1])->get()[0]->silver;

            //update ticket specific total revenue in the events db
                //fetch previous ticket total
                $tic = event::where('id', $event_meta[1])->get()[0]->silver_revenue;
                //add current total cost to previous ticket total revenue
                $new_revenue = $total + $tic;

                $update_tick = event::where('id', $event_meta[1])->update(['silver_revenue'=>$new_revenue]);
        }

        if($diced[0] == 'platinum'){
            $prev_tick = event::where('id', $event_meta[1])->get()[0]->platinum;
            $remaining = event::where('id', $event_meta[1])->get()[0]->platinum;
            //update ticket specific total revenue in the events db
                //fetch previous ticket total
                $tic = event::where('id', $event_meta[1])->get()[0]->platinum_revenue;
                //add current total cost to previous ticket total revenue
                $new_revenue = $total + $tic;

                $update_tick = event::where('id', $event_meta[1])->update(['platinum_revenue'=>$new_revenue]);
        }

        if($diced[0] == 'gold'){
            $prev_tick = event::where('id', $event_meta[1])->get()[0]->gold;
            $remaining = event::where('id', $event_meta[1])->get()[0]->gold;
            //update ticket specific total revenue in the events db
                //fetch previous ticket total
                $tic = event::where('id', $event_meta[1])->get()[0]->gold_revenue;
                //add current total cost to previous ticket total revenue
                $new_revenue = $total + $tic;

                $update_tick = event::where('id', $event_meta[1])->update(['gold_revenue'=>$new_revenue]);
        }

        //first verify if available seats are greater than the required seats
        if($request->qty > $remaining){
            return back()->with(['notification'=>'Insufficient seats.']); 
        }

        if($request->qty <= $remaining){
        //deduct seats from total available seats from the event db
        $avail_seats = $remaining - $request->qty;
        $total = event::where('id', $event_meta[1])->get()[0]->available_seats;
        $total_remaining = $total - $request->qty;

        $deduct = event::where('id', $event_meta[1])->update([$diced[0]=>$avail_seats, 'available_seats'=>$total_remaining]);

            

        //enter record in sales table
        $order = new sale;
        $order->event_name = $event_meta[0];
        $order->event_id = $event_meta[1];
        $order->ticket_name = $diced[0];
        $order->ticket_cost = $diced[1];
        $order->ticket_qty = $request->qty;
        $order->total_cost = $total;

        $order->save();

        return back()->with(['notification'=>'Tickets Booked Successfully']);
        }
    }

    function book_ticket_view(){
        //fetch all tickets/seats
        $tickets = ticket::all(); 

        //fetch all events
        $events = event::all();
        return view('welcome', ['tickets'=>$tickets, 'events'=>$events]);
    }
}
