<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangeController extends Controller
{
    public function index(){

        return view("orange.index");
    }

    public function blog(){
        return view("orange.blog");
    }
}