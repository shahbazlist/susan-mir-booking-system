<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ServiceSlot;
use App\Models\Service;
use App\Models\ServiceAvailable;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Service::latest()->paginate(10);
        return view('theme.services.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('theme.services.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_title'    => 'required',
            'slot'             => 'required',
            'price'            => 'required',
        ]);
        try {
            $service = new Service();
            $service->service_title = $request->service_title;
            $service->description   = $request->service_desc;
            $service->slot          = $request->slot;
            $service->price         = $request->price;
            $service->save();
            return redirect()->to(route('admin.services.index'))->with('success', 'New service has been added.');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Service::where('id',$id)->first();
        return view('theme.services.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_title'     => 'required',
            'price'             => 'required',
            'slot'              => 'required',
        ]);
        try {
            $service = Service::find($id);
            $service->service_title     = $request->service_title;
            $service->description       = $request->service_desc;
            $service->slot              = $request->slot;
            $service->price             = $request->price;
            $service->save();
            return redirect()->to(route('admin.services.index'))->with('success', 'Service has been updated.');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'something went wrong!');
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
    
    public function availability(Request $request)
    {
        $data= ServiceAvailable::with('service')->latest()->paginate(10);
        
        return view('theme.services.availability',compact('data'));
    }

    public function availability_add(Request $request)
    {
        if($request->isMethod('post')) {
            $request->validate([
                'service'       => 'required',
                'date'          => 'required',
            ]);
            if(ServiceAvailable::whereDate('from_date',$request->date)->where('service_id',$request->service)->count()){
                return redirect()->back()->withInput()->with('errorDate', 'The date has already been taken this service');
            }
            $service = new ServiceAvailable();
            $service->service_id = $request->service;
            $service->from_date  = $request->date;
            // $service->to_date    = $request->date;
            $service->save();
            return redirect()->to(route('admin.services.availability'))->with('success', 'New Slot has been added.');
        }
        $data= Service::where('status',1)->get();
        return view('theme.services.avalability_add',compact('data'));
    }
    
    public function status(Request $request)
    {
        if($request->data_id){
            $status = ServiceAvailable::where('id',$request->data_id)->first()->status == 1 ? 0 : 1;
            ServiceAvailable::where('id',$request->data_id)->update(['status'=>$status]);
            return 1;
        }else{
            return 0;
        }
    }
    
    public function edit_availability(Request $request, $id)
    {
        if($request->isMethod('post')) {
            if(ServiceAvailable::whereDate('from_date',$request->date)->where('service_id',$request->service)->where('id','!=',$id)->count()){
                return redirect()->back()->withInput()->with('errorDate', 'The date has already been taken this service');
            }
            $getBookedSlotQty = ServiceAvailable::where(['id'=>$id,'service_id'=>$request->service])->whereDate('from_date',$request->date)->first();
            if($getBookedSlotQty->booked_slot > $request->max_slot){
                return redirect()->to(route('admin.services.aval.edit',[$id]))->with('error', "Please add max slot more than $getBookedSlotQty->booked_slot.");
            }
            
            ServiceAvailable::where('id',$id)->update(['service_id'=>$request->service,'from_date'=>$request->date,'updated_max_slot'=>$request->max_slot]);
            return redirect()->to(route('admin.services.aval.edit',[$id]))->with('success', 'Slot updated successfully.');
        }
        $data = ServiceAvailable::where('id',$id)->first();
        $services = Service::get()->toArray();
        return view('theme.services.edit_avalability',compact('data','services'));
    }
}
