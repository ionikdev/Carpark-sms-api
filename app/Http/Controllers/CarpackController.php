<?php

namespace App\Http\Controllers;

use App\Models\Carpark;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CarpackController extends Controller
{
    use HttpResponses;

    public function getCarpack(Request $request)
    {
        $carparks = Carpark::all();

        return $this->success([
            'carparks' => $carparks,
        ], "Retrieved all car parks successfully", 200);
    }

    public function createCarpack(Request $request)
    {

        $carpark = Carpark::create([
            'carpark_name' => $request->input('carpark_name'),
            'address' => $request->input('address'),
            'max_capacity' => $request->input('max_capacity'),
        ]);

        return $this->success([
            'carpack'=> $carpark,
        ], "Carpark created successfully", 201);


    }

}
