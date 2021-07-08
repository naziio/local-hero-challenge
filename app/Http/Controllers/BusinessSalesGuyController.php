<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use App\Http\Resources\BusinessPostalCodeResource;

class BusinessSalesGuyController extends Controller
{
    public function fakeData()
    {
        $data = collect([[
            'id' => 1,
            'people' => 10,
            'quantity' => 5,
            'business' => 'Hotel',
            'termin' => 20
        ],
        [
            'id' => 2,
            'people' => 20,
            'quantity' => 2,
            'business' => 'Hotel',
            'termin' => 2
        ],
        [
            'id' => 3,
            'people' => 30,
            'quantity' => 2,
            'business' => 'Restaurant',
            'termin' => 5

        ],
        [
            'id' => 4,
            'people' => 40,
            'quantity' => 5,
            'business' => 'Gym',
            'termin' => 11

        ]]);
        return response()->json($data,201);
    }

    public function dataSelected(Request $request)
    {
        $data = $request->data;
        $new =  collect([]);
        
        $collection = collect($this->fakeData()->getData());
        if($data == null){
            return response()->json($this->fakeData()->getData(),201);
        }
        foreach($data as $d){
             $collection->map(function ($value, $key) use ($d,$new){
               if($value->business == $d) {
                $new->push($value);                
               }                 
            });
        }
        return response()->json($new->all(),201);
                
    }
}
