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
        return view('theme.booking.index',compact('data'));
    }
}
