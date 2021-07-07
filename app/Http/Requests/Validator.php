<?php

namespace App\Http\Requests;

use App\Models\PostalCode;
use App\Http\Resources\PostalCodeResource;

class Validator 
{

    public function hasAbbrevation(StorePostalCodeRequest $request)
    { 
        $code = explode('*', $request->postal_code);
       
            if ($code[0] / 1000 < 1) {
                $beginCode = (int)$code[0]*100;
                $latestCode = (int)$code[0]*100 +99;
            } elseif($code[0] / 1000 < 10) {
                $beginCode = (int)$code[0]*10;
                $latestCode = (int)$code[0]*10 +9;
            }
        
       
        for($i = $beginCode ; $i <= $latestCode ; $i++)
        {
           $postalCode = PostalCode::where('postal_code',$request->postal_code)
                ->firstOrCreate([
                    'postal_code' => $i,
                    'sales_guy' => $request->sales_guy
                ]);
        
        }
        return $postalCode;
    }

    public function hasConflicts()
    {
        $oldPostalCodes = PostalCode::all();
        return $oldPostalCodes->toBase()->duplicates('postal_code');
    }

}