<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\Status;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    use HttpResponses;

    public function createReservationForSpace($spaceId)
    {
        $user = auth()->user();
        $userReservationsCount = Reservation::where('user_id', $user->id)->count();

        if ($userReservationsCount >= 2) {
            return $this->error('Invalid Operation', ' You have reached the maximum limit of reservations', 400);
        }
        try {
            $space = Space::findOrFail($spaceId);
            $space->status = 'Reserved';
            $space->save();

                $reservation = Reservation::create([
                'space_id' => $space->id,
                'user_id' => auth()->id(),
                'amount' => $space->amount,
                'reservation_date' => now()->toDateString(),
            ]);

            return $this->success(['reservation' => $reservation], 'Reservation created successfully', 201);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 'Internal Server Error', 500);
        }
    }

}
