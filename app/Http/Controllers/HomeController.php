<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home', [
        'title' => 'Beranda',
        'rents' => Rent::all()->take(3)
    ]);
    }
}
