<?php

namespace App\Http\Controllers;
use App\Models\Space;
use App\Models\Status;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpaceController extends Controller
{
    use HttpResponses;

    public function getAllSpacesWithCarparks()
    {
        try {
            $user = Auth::user();
            $spacesWithCarparks = Space::with('carpark')
            ->orderBy('created_at', 'desc')
            ->get();


            foreach ($spacesWithCarparks as $space) {
                $space->user = $user;
            }

            return $this->success(['spaces' => $spacesWithCarparks], 'Spaces with car parks retrieved successfully', 200);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 'Internal Server Error', 500);
        }
    }


    public function createSpace(Request $request)
    {
        try{


        $validatedData = $request->validate([
            'carpark_id' => 'required|exists:carparks,id',
            'space_name' => 'required',
            'space_type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $space = Space::create($validatedData);
        return $this->success([
            'carpack'=>  $space,
        ], "Space created successfully", 201);
    }
    catch (ValidationException $validationException) {
        return $this->error($validationException->errors(), 'Validation error', 422);
    } catch (Exception $exception) {
        return $this->error('An unexpected error occurred', 'Internal Server Error', 500);
    }

}

public function createSpaceStatus(Request $request)
{
    try {
        // Validate incoming request data
        $validatedData = $request->validate([
            'status' => 'required|unique:status|max:50',

        ]);

        // Create a new space status
        $spaceStatus = Status::create($validatedData);

        return $this->success(['space_status' => $spaceStatus], 'Space status created successfully', 201);
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage(), 'Internal Server Error', 500);
    }
}
}
