<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingService;
use Illuminate\Support\Facades\DB;

class BookingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= BookingService::with(['service','serviceAvailable'])->latest()->paginate(10);
        // dd($data);
        // foreach($data as $val){
        //     // $getService = DB::table()
        //     $val['service_name'] =  DB::table('services')->where('id',$val['service_id'])->first()->service_name;
        // }
    
        return view('theme.booking.index',compact('data'));
    }
}
