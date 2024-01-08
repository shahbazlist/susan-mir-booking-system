<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceSlot;
use App\Models\BookingService;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }
    public function booking_index()
    {
        return view('index');
    }
    
    public function booking_ability(Request $request)
    {
        if(ServiceSlot::whereDate('service_date', $request->selectDate)->count()){
            $data['selectedDate'] = date("d M, Y", strtotime($request->selectDate));
            $data['selectedDateId'] = ServiceSlot::whereDate('service_date', $request->selectDate)->first()->id;
            return response()->json(['status' => 'true', 'data' => $data]);
        }else{
            return response()->json(['status' => 'false']);
        }
    }

    public function booking_price_cal(Request $request)
    {
        
        if(ServiceSlot::where('id', $request->bookId)->count()){
            $checkSlot = ServiceSlot::where('id', $request->bookId)->first()->slot;
            if($request->slotQty > $checkSlot){
                return response()->json(['status' => 'false', 'msg' => "Slot available only $checkSlot"]);
            }
            $getData = ServiceSlot::with('service')->where('id', $request->bookId)->first();
            $callData = $getData->service->price*$request->slotQty;
            return response()->json(['status' => 'true', 'data' => $callData]);
        }else{
            dd(0);
        }
        dd($request->all());
    }
    
    public function booking(Request $request)
    {
        $booking = new BookingService();
        $booking->booking_id    = time();
        $booking->service_id    = $request->selectedBookingId;
        $booking->full_name     = $request->full_name;
        $booking->email         = $request->email;
        $booking->booking_qty   = $request->slot_qty;
        $booking->total_cost    = $request->actual_cost;
        $booking->booking_service_date  = date("Y-m-d", strtotime($request->selectedBookingDate));
        $booking->booking_date   = date('Y-m-d H:i:s');
        $booking->save();
        $orgSlot = ServiceSlot::where('id', $request->selectedBookingId)->first()->slot;
        ServiceSlot::where('id', $request->selectedBookingId)->update(['slot'=>$orgSlot-$request->slot_qty]);
        return response()->json(['status' => 'true', 'msg' => "Booking slot has been booked."]);
    }
}
