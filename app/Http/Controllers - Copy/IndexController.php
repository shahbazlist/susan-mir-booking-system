<?php

namespace App\Http\Controllers;

use App\Models\ServiceAvailable;
use App\Models\BookingService;
use Illuminate\Http\Request;
use App\Models\ServiceSlot;
use App\Models\Service;
use Validator;

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
        if(ServiceAvailable::where('status',1)->whereDate('from_date', $request->selectDate)->count()){
            $getServiceAvailable = ServiceAvailable::with('service')->where('status',1)->whereDate('from_date', $request->selectDate)->get();
            $viewData = '';
            foreach($getServiceAvailable as $val){
                $totalSlot = $val->updated_max_slot == 0 ? $val->service->slot : $val->updated_max_slot;
                if($totalSlot > $val->booked_slot){
                    $viewData .='<div style="display:flex; justify-content:space-between"><strong style="width:50%">'.$val->service->service_title.'</strong>
                            <span style="width:50%">'.date("d M, Y", strtotime($val['from_date'])).'</span></div><hr>
                            <p>'.$val->service->description.'</p>
                            <a class="btn btn-primary" href="javascript:void(0);" onclick="choseBook('.$val['id'].')" >Choose</a><br><br>';
                }
            }
            return response()->json(['status' => 'true', 'data' => $viewData]);
        }else{
            $viewData = '<p class="text-danger">Service is not available, Please choose the other date</p>';
            return response()->json(['status' => 'false','data'=>$viewData]);
        }
    }

    public function booking_price_cal(Request $request)
    {
        if(ServiceAvailable::where('id', $request->bookId)->count()){
            $checkSlot = ServiceAvailable::with('service')->where('id', $request->bookId)->first();
            $totalSlot = $checkSlot->updated_max_slot == 0 ? $checkSlot->service->slot : $checkSlot->updated_max_slot;
            $finalAvalSlot = $totalSlot - $checkSlot->booked_slot;
            
            if($request->slotQty > $finalAvalSlot){
                return response()->json(['status' => 'false', 'msg' => "Slot available only $finalAvalSlot"]);
            }
            $callData = $checkSlot->service->price*$request->slotQty;
            return response()->json(['status' => 'true', 'data' => $callData]);
        }else{
            return response()->json(['status' => 'false']);
        }
    }
    
    public function booking(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email'     => 'required',
            'slot_qty'  => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status'=> false,'msg'=> $validator->getMessageBag()]);
        }
        $getServiceId = ServiceAvailable::with('service')->where('id', $request->selectedBookingId)->first();
        $calculate = $request->slot_qty*$getServiceId->service->price;
        
        $booking = new BookingService();
        $booking->booking_id    = time();
        $booking->service_id    = $getServiceId->service_id;
        $booking->service_available_id = $request->selectedBookingId;
        $booking->full_name     = $request->full_name;
        $booking->email         = $request->email;
        $booking->booking_qty   = $request->slot_qty;
        $booking->total_cost    = $calculate;
        $booking->booking_service_date  = date("Y-m-d", strtotime($request->selectedBookingDate));
        $booking->booking_date   = date('Y-m-d H:i:s');
        $booking->save();
        ServiceAvailable::where('id', $request->selectedBookingId)->update(['booked_slot'=>$request->slot_qty+$getServiceId->booked_slot]);
        // Service::where('id', $getServiceId->service->id)->update(['slot'=>$getServiceId->service->slot-$request->slot_qty]);
        return response()->json(['status' => 'true', 'msg' => "Booking slot has been booked."]);
    }

    public function chosebook(Request $request)
    {
        $servData = ServiceAvailable::with('service')->where('id', $request->id)->first();
        $data['selectedDate'] = date("d M, Y", strtotime($servData->from_date));
        $data['selectedDateId'] = $servData->id;
        
            $data['slot'] = $servData->service->slot;//Defoult Slot
        
        
        return response()->json(['status' => 'true', 'data' => $data]);
    }
}
