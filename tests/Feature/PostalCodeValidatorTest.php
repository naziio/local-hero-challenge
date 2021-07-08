<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PostalCode;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\StorePostalCodeRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use App\Http\Controllers\PostalCodeController;
use App\Http\Requests\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostalCodeValidator extends TestCase
{
    use RefreshDatabase;
    
     function test_get_postal_code_url()
    {
        $response = $this->get('/postal-code');

        $response->assertStatus(200);
    }
 
      function test_check_if_postal_code_has_wrong_input()
     {

        $response = $this->json('POST', 'api/postal-code',[
            'postal_code' => '71*',
            'sales_guy' => 1
        ]);

        $response->assertStatus(422);

     }

      function test_check_if_postal_code_has_right_input()
     {
        $response = $this->json('POST', 'api/postal-code',[
            'postal_code' => 75111,
            'sales_guy' => 1
        ]);

        $response->assertStatus(201);
     }

     function test_check_if_postal_code_has_conflicts()
     {
         $responseSalesGuy1 = $this->json('POST', 'api/postal-code',[
            'postal_code' => 76554,
            'sales_guy' => 1,
         ])->assertJson([
             'all_items' => [
                'postal_code' => 76554,
                'sales_guy' => 1  
             ]
            
        ])->assertStatus(201);;

         $responseSalesGuy2 = $this->json('POST', 'api/postal-code',[
            'postal_code' => 76554,
            'sales_guy' => 2,
         ])->assertJson([
            'all_items' => [
               'postal_code' => 76554,
               'sales_guy' => 2  
            ],
            'conflicts_items' => [
                1 => 76554
            ]
       ])->assertStatus(201);
     }

      function test_store_postal_code_abrevation()
      {
        $validator = new Validator(); 
        $data = $this->valid_data();      
        if(!is_numeric($data->postal_code)){
            $postalCode1 = $validator->hasAbbrevation($data);
        } else {
            $postalCode2 = PostalCode::create([
                'postal_code' => $data->postal_code,
                'sales_guy' => $data->sales_guy]);
        }

        $response = $this->json('POST', 'api/postal-code',[
            'postal_code' => $data->postal_code,
            'sales_guy' => $data->sales_guy
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['postal_code' => $postalCode1->postal_code]);
      }

      function test_store_validates_using_a_form_request()
        {
        $this->assertActionUsesFormRequest(
            PostalCodeController::class,
            'store',
            StorePostalCodeRequest::class
        );
        }

        public function valid_data()
        {
            $request = new StorePostalCodeRequest();
             $data = [
                'postal_code' => '112*',
                'sales_guy' => 1
            ];
            $request->postal_code = $data['postal_code'];
            $request->sales_guy = $data['sales_guy'];
            return $request;
        }

}
