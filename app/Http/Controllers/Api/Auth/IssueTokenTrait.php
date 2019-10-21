<?php

namespace App\Http\Controllers\Api\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait IssueTokenTrait{

    private $client;

    public function __construct(){
        $this->client=Client::find(1);
    }

    public function issueToken(Request $request, $grant_type, $scope="*"){
        $params=[
            "grant_type"=>$grant_type,
            "client_id" => $this->client->id,
            "client_secret" => $this->client->secret,
            "scope"=>$scope
        ];

        if($grant_type!=='social'){
            $params["username"] = $request->username ?: $request->email;
        }

        
        $request->request->add($params);
        $proxy = Request::create("oauth/token","POST");

        return Route::dispatch($proxy);
    }
}