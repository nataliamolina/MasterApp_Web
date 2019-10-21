<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\StakeholderInformacionExtra;
use DB;
class StakeholderInfoExtraController extends Controller
{
    public function getStudies(){
        $in = DB::table("vstakeholder_extra_information")->where("type_information_id",1)->where("stakeholder_id",auth()->user()->stakeholder->id)->get();
        return response()->json(["results"=>$in]);
    }

    public function storeStudy(Request $req){
        $in = $req->all();
        $in["stakeholder_id"]=auth()->user()->stakeholder->id;
        $in["type_information_id"]=1;
        $res = StakeholderInformacionExtra::create($in);
        return response()->json(["status"=>"created"]);
    }

    public function update(Request $request, $id){
        $row = StakeholderInformacionExtra::find($id);
        $row->fill($request->all());
        $row->save();
        return response()->json(["status"=>"updated"]);
    }

    public function getExperience(){
        $in = DB::table("vstakeholder_extra_information")->where("type_information_id",2)->where("stakeholder_id",auth()->user()->stakeholder->id)->get();
        return response()->json(["results"=>$in]);
    }

    public function storeExperience(Request $req){
        $in = $req->all();
        $in["stakeholder_id"]=auth()->user()->stakeholder->id;
        $in["type_information_id"]=2;
        $res = StakeholderInformacionExtra::create($in);
        return response()->json(["status"=>"created"]);
    }


    
}
