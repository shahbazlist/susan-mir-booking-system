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
        $data= BookingService::latest()->get();
        foreach($data as $val){
            $val['service_name'] =  DB::table('services')->where('id',$val['service_id'])->first()->service_name;
            // $val['service_name'] = ->service_name;
        }
    
        return view('theme.booking.index',compact('data'));
    }
}
