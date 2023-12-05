<?php

namespace App\Http\Controllers;

use App\Models\BookingPayment;
use App\Models\Carpark;
use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HttpResponses;
    public function getTotalCounts()
    {
        try {
            $totalUsers = User::where('role', 'user')->count();
            $totalOperators = User::where('role', 'operator')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalCarpack = Carpark::count();
            $totalspace = Space::count();
            $totalUserBookings = BookingPayment::count();
            $totalUserReservation = Reservation::count();
            $totalPayment = BookingPayment::sum('amount');




            return $this->success([
                'total_users' => $totalUsers,
                'total_operators' => $totalOperators,
                'total_admins' => $totalAdmins,
                'total_carpack' =>  $totalCarpack,
                'total_space' =>  $totalspace,
                'total_user_bookings' => $totalUserBookings,
                'total_user_' => $totalUserReservation,
                'total_payment' => $totalPayment,
            ], 'Total counts retrieved successfully', 200);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 'Internal Server Error', 500);
        }
    }

}
