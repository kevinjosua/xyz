<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::with("kurir")->get();
        // dd($pengiriman);
        return view ("admin.pengiriman.index", compact ("pengiriman"));
    }

    public function create()
    {
        return view ("admin.create");
    }
    public function store(Request $request){

    }
}
