<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Service;
use Validator;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= DB::table('services')->get();
        return view('theme.service.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('theme.service.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'service_price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> false,'msg'=> $validator->getMessageBag()]);
        }
        $service = new Service();
        $service->service_name  = $request->service_name;
        $service->price         = $request->service_price;
        $service->save();
        return response()->json(['status' => 200, 'message'=>'Service added successfully.']);
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
        // if($request->isMethod('post')) {
        //     DB::table('reason_cancel')->where('id', $request->id)
        //         ->limit(1)
        //         ->update(array('reason'=>$request->edit_cancelreason));
          
        //        return response()->json(['status' => 200, 'message'=>'Cancel Reason updated successfully.']);
        // }
        
        // $data = $request->all();
        
        // $getData = DB::table('reason_cancel')
        //                     ->select('id','reason')
        //                     ->where('id', $data['id'])
        //                     ->first();
        // $viewRender = "";
        // $viewRender = view('admin.master.editcancelreason',compact('getData'))->render();
        // return response()->json(['success' => true, 'html' => $viewRender]);
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
        //
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

    public function services()
    {
        $data= DB::table('services_data')->get();
        // $data= Service::latest()->get();
        
        return view('theme.service.service_name',compact('data'));
    }

    public function services_store(Request $request)
    {
        dd($request->all());
    }
}
