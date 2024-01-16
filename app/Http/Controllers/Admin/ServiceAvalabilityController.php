<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceAvailable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceAvalabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id = null)
    {
        $service= Service::get()->toArray();
        $new_id = $service[0]['id'];
        $select = $new_id;
        if (!empty($id)) {
            $new_id = $id;
            $select = $new_id;
        }
        $events = [];
        $serviceAvail = ServiceAvailable::with('service')->where('service_id',$new_id)->get();
        foreach($serviceAvail as $val){
            $totalSlot = $val->updated_max_slot == 0 ? $val->service->slot : $val->updated_max_slot ;
            $events[] = [
                'title'=> '('.$val->booked_slot.'/'.$totalSlot.')',
                'start' => $val->from_date,
                'end' => $val->from_date,
            ];
        }
        
        return view('theme.services_availability.index',compact('service','select','events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $inputDate = explode(" - ",$request->daterange);
            $service_id = $request->service;
            $update_max_slot = $request->update_max_slot;
            
            $startDate = Carbon::createFromFormat('Y-m-d', Date('Y-m-d',strtotime($inputDate[0])));
            $endDate = Carbon::createFromFormat('Y-m-d', Date('Y-m-d',strtotime($inputDate[1])));
            $dateRange = CarbonPeriod::create($startDate, $endDate);
            $updateMaxSlot = [];
            $createMaxSlot = [];
            foreach($dateRange->toArray() as $val){
                $date = $val->format("Y-m-d");
                $getBookedSlotQty = ServiceAvailable::where('service_id',$service_id)->whereDate('from_date',$date)->first();
                if($getBookedSlotQty){
                    if($getBookedSlotQty->booked_slot > $update_max_slot){
                        return response()->json(['status' => 'false', 'msg' => "Please add max slot more than date $getBookedSlotQty->booked_slot at this $date"]);
                    }
                    $updateMaxSlot[] = ['from_date'=>$date,'updated_max_slot'=>$update_max_slot];
                }else{
                    $createMaxSlot[] = ['service_id'=>$service_id,'from_date'=>$date,'updated_max_slot'=>$update_max_slot];
                }
            }
            
            if(count($createMaxSlot)){
                DB::table('service_availables')->insert($createMaxSlot);
            }
            foreach($updateMaxSlot as $valUpdate){
                ServiceAvailable::where('service_id',$service_id)->whereDate('from_date',$valUpdate['from_date'])->update(['updated_max_slot'=>$update_max_slot]);
            }
            return response()->json(['status' => 'true', 'msg' => "Service slot has been changes successfully."]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'false', 'msg' => "Something went wrong!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
