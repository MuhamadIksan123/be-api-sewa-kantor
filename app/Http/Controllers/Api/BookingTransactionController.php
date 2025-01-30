<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource as ApiBookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingTransactionController extends Controller
{
    public function store(BookingTransactionRequest $request)
    {
        $validatedData = $request->validated();

        Log::info($validatedData);

        $officeSpace = OfficeSpace::find($validatedData['office_space_id']);

        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();
        $validatedData['duration'] = $officeSpace->duration;

        // Memastikan bahwa 'started_at' adalah format tanggal yang valid
        $startedAt = new \DateTime($validatedData['started_at']);
        $validatedData['ended_at'] = $startedAt->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction = BookingTransaction::create($validatedData);

        // Mengirimkan notifikasi (logika untuk mengirimkan notifikasi perlu ditambahkan di sini)

        // Mengembalikan resource
        $bookingTransaction->load('officeSpace');
        return new ApiBookingTransactionResource($bookingTransaction);
    }

    public function booking_details(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'booking_trx_id' => 'required|string'
        ]);

        $booking = BookingTransaction::where('phone_number', $request->phone_number)
            ->where('booking_trx_id', $request->booking_trx_id)
            ->with(['officeSpace', 'officeSpace.city'])  // Memperbaiki penulisan 'with'
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);  // Memperbaiki format response
        }

        return new ViewBookingResource($booking);
    }
}
