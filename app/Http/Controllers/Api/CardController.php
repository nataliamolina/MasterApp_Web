<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Card;

class CardController extends Controller
{
    public function index(){
        $res["results"]=Card::all();
        return response()->json($res);
    }

    public function store(Request $req){
        $in = $req->all();
        $id = Card::create($in);
        return response()->json(["status"=>true]);
    }
}
