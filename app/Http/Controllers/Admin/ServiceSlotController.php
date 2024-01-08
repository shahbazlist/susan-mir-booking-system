<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ServiceSlot;
use App\Models\Service;

class ServiceSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ServiceSlot::with('service')->latest()->get();
        
        // $data= ServiceSlot::latest()->paginate(10);
        // $data= Service::latest()->get();
        
        return view('theme.service_slot.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = Service::select('id','service_name')->where('status',1)->get()->toArray();
        return view('theme.service_slot.add',compact('service'));
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
            'service'       => 'required',
            'service_date'  => 'required|unique:service_slots,service_date,',
            'slot'          => 'required',
        ]);
        try {
            $service = new ServiceSlot();
            $service->service_id    = $request->service;
            $service->service_date  = $request->service_date;
            $service->slot          = $request->slot;
            $service->save();
            return redirect()->to(route('admin.service_slot.index'))->with('success', 'New service slot has been added.');
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
        $data = ServiceSlot::where('id',$id)->first();
        $service = Service::select('id','service_name')->where('status',1)->get()->toArray();
        return view('theme.service_slot.edit',compact('data','service'));
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
            'service'       => 'required',
            'service_date'  => 'required|unique:service_slots,service_date,'.$id,
            'slot'          => 'required',
        ]);
        try {
            $service = ServiceSlot::find($id);
            $service->service_id    = $request->service;
            $service->service_date  = $request->service_date;
            $service->slot          = $request->slot;
            $service->save();
            return redirect()->to(route('admin.service_slot.index'))->with('success', 'Service slot has been updated.');
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
}
