<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $clients = \App\Client::where("user_id",auth()->user()->id)->get();
        return view("client",compact("clients"));
    }
}
