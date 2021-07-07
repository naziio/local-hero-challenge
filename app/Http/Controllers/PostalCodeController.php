<?php

namespace App\Http\Controllers;

use App\Models\PostalCode;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostalCodeRequest;
use App\Http\Requests\Validator;
use App\Http\Resources\PostalCodeResource;

class PostalCodeController extends Controller
{
    public function store(StorePostalCodeRequest $request)
    {
        $postalCode = new Validator();
    if(!is_numeric($request->postal_code)) {
        $postalCodeCollection = $postalCode->hasAbbrevation($request);
        
    } else {
        $postalCodeCollection = PostalCode::create($request->all());
    }
    $postalCodeConflicts =  $postalCode->hasConflicts();
    return response()->json((['all_items' => new PostalCodeResource($postalCodeCollection), 'conflicts_items' => $postalCodeConflicts]),201); 
    }
}
