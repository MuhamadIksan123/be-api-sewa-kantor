<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource as ApiBookingTransactionResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingTransactionController extends Controller
{
    public function store(BookingTransactionRequest $request)
    {
        Log::info("TEST");
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
}
