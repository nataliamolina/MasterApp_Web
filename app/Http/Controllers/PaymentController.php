<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        return view("payment/index");
    }

    public function store(Request $req){
        $in = $req->all();


        \MercadoPago\SDK::setAccessToken("TEST-3538639200668192-112919-746c1b4f7ccbbbc466c4946c9fe77759-190220543");
        $payment = new \MercadoPago\Payment();

        $payment->transaction_amount = 141;
        $payment->token = "YOUR_CARD_TOKEN";
        $payment->description = "Ergonomic Silk Shirt";
        $payment->installments = 1;
        $payment->payment_method_id = "visa";
        $payment->payer = array(
          "email" => "larue.nienow@hotmail.com"
        );
    
        $payment->save();

        dd($payment->status);
        //echo $payment->status;


        $data= [
            "transaction_amount"=> 100,
            "token"=> "ff8080814c11e237014c1ff593b57b4d",
            "description"=> "Title of what you are paying for",
            "installments"=> 12,
            "payment_method_id"=> "visa",
            "payer"=> [
                "email"=> "test_user_19653727@testuser.com"
            ],
            "external_reference"=> "Reference_1234",
            "metadata"=> [
                "key1"=> "value1",
                "key2"=> "value2"
            ],
            "statement_descriptor"=> "MY E-STORE",
            "notification_url"=> "https=>//www.your-site.com/webhooks",
            "additional_info"=> [
                "items"=> [
                    [
                        "id"=> "item-ID-1234",
                        "title"=> "Title of what you are paying for",
                        "picture_url"=> "https=>//www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                        "description"=> "Item description",
                        "category_id"=> "art", // Available categories at https=>//api.mercadopago.com/item_categories
                        "quantity"=> 1,
                        "unit_price"=> 100
                    ]
                ],
                "payer"=> [
                    "first_name"=> "user-name",
                    "last_name"=> "user-surname",
                    "registration_date"=> "2015-06-02T12:58:41.425-04:00",
                    "phone"=> [
                        "area_code"=> "11",
                        "number"=> "4444-4444"
                    ],
                    "address"=> [
                        "street_name"=> "Street",
                        "street_number"=> 123,
                        "zip_code"=> "5700"
                    ]
                ],
                "shipments"=> [
                    "receiver_address"=> [
                        "zip_code"=> "5700",
                        "street_name"=> "Street",
                        "street_number"=> 123,
                        "floor"=> 4,
                        "apartment"=> "C"
                    ]
                ]
            ]
        ];

        $mp = new MP (env('MP_CLIENT_ID'), env('MP_CLIENT_SECRET'));

        $current_user = auth()->user();
    
        $preferenceData = [
            'external_reference' => $this->id,
            // also you can do this
            //'external_reference' => $this->prefix . $this->id,
            'payer'              => [
               
            ],
            'back_urls'          => [
               
            ],
            'notification_url'=> env('MP_NOTIFICATION_URL')
        ];
    
        // add items
        foreach ($this->items as $item):
            $preferenceData['items'][] = [
                'id'          => '',
                'category_id' => '',
                'title'       => '',            
                'description' => '',
                'picture_url' => '',
                'quantity'    => '',
                'currency_id' => '',
                'unit_price'  => '',
            ];
        endforeach;
    
        $preference = $mp->create_preference($preferenceData);
        // also you can use try-catch for create the preference, DB transaction for the whole generatePaymentGateway method, etc...
    
        // finally return init point to be redirected - or
        // sandbox_init_point
        return $preference['response']['init_point'];


        dd($data);
    }
}
