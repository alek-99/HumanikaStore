<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UlasanController extends Controller
{
    public function index(){
        $ratings = Rating::with('product','user','order')->get();
        return view('admin.rating.index',compact('ratings'));
    }
}
