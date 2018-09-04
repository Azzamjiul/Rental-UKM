<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class AdminController extends Controller
{
    public function index(){

    }

    public function inventaris(){
      return view('inventaris');
    }

    public function addProduct(Request $request){
      
    }
}
