<?php

namespace App\Http\Controllers;

use App\Models\BookingPayment;
use App\Models\Space;
use App\Traits\HttpResponses;
class BookingController extends Controller
{
    use HttpResponses;

    public function createBookingPaymentForSpace($spaceId)
    {
        try {
            $user = auth()->user();

            $space = Space::findOrFail($spaceId);


            if ($space->status === 'booked') {
                return $this->error('', 'Space is already booked, chack again later', 400);
            }


            $space->status = 'Booked';
            $amount = $space->amount;
            $space->save();

            $bookingPayment = BookingPayment::create([
                'space_id' => $space->id,
                'user_id' => $user->id,
                'amount' => $amount,
            ]);

            return $this->success(['bookingPayment' => $bookingPayment], 'Booking payment created successfully', 201);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 'Internal Server Error', 500);
        }
    }

}
