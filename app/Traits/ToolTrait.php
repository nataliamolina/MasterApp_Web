<?php
namespace App\Traits;

use DB;
use App\Models\Administration\Comment;
use Auth;
use Log;

trait ToolTrait {

    public function sendPush($recipients,$notification,$data=null){
        //$recipients=["e8Vkx1TyIEA:APA91bFKDWxLO222h68fRRlTlVOfUEZmDlayL3BgfL9OYbd6WKOn0trEA6ElLBH5y-6hS896UhKUiVEh0fo7Jnded-M7zmelYXjz3tEhSHaVT6QRipTT7MY_T6sP7hmEVk0pd9J9ldI3"];
        
        // $res = fcm()
        //     ->to($recipients) // $recipients must an array
        //     ->notification([
        //         'title' => 'Solicitud de Servicio',
        //         'body' => 'El señor x tiene una peticion para el 23 de dicimbre',
        //     ])
        //     ->data([
        //     'title' => 'Test FCM',
        //     'body' => 'This is a test of FCM',
        //     ])
        //     ->send();

        Log::debug("sendPush");
        Log::debug("recipients",$recipients);
        Log::debug("recipients",$notification);
        Log::debug($data);

         $res = fcm()
             ->to($recipients)->notification($notification);

             if($data!=null){
                $res->data($data);
             }
             $res->send();
    }


}