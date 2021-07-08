<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PostalCode;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\StorePostalCodeRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use App\Http\Controllers\PostalCodeController;
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
        $request = new StorePostalCodeRequest();
        $request->postal_code = '112*';
        $response = $this->json('POST', 'api/postal-code',[
            'postal_code' => $request->postal_code,
            'sales_guy' => 1
        ]);
        $response->assertStatus(201);
      }

      function test_store_validates_using_a_form_request()
        {
        $this->assertActionUsesFormRequest(
            PostalCodeController::class,
            'store',
            StorePostalCodeRequest::class
        );
        }

}
