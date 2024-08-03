<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $reservations = Reservation::all();
        if (is_null($reservations))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "reservation records has been retrieved", $reservations, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return (Response());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required','exists:users,id',
            'active_id' => 'required','exists:actives,id',
            'reserve_statue' => 'required',
        ]);

        $reservations = Reservation::create([
            'user_id' => $request->user_id,
            'active_id' => $request->active_id,
            'reserve_statue'=> $request->reserve_statue
        ]);

        if (is_null($reservations)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "reservation records has been retrieved", $reservations, 200);

    }

    /**
     *
     * Update the specified resource in storage.
     * it works for showing the comment of provided IDs
     * @param Request $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $fields = $request->validate([
            'user_id' => 'required','exists:users,id',
            'active_id' => 'required','exists:actives,id',
            'reserve_statue' => 'required|boolean',
        ]);

        // Attempt to find the comment based on trip_id and user_id
        $existingReservation = Reservation::where('active_id', $fields['active_id'])
            ->where('user_id', $fields['user_id'])
            ->first();

        if (!$existingReservation) {
            return response()->json(['message' => 'reservation not found'], 404);
        }

        try {
            // Update the found comment with the new details
            $existingReservation->update([
                'reserve_statue' => $fields['reserve_statue']
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating reserve_statue: ' . $e->getMessage()); // Fixed unclosed parenthesis here
            return response()->json(['message' => 'Failed to update reserve_statue'], 500);
        }

        // Return success response with the updated comment
        return self::getResponse(true, "reserve_statue have been updated successfully.", $existingReservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();
        return self::getResponse(true, "reservation has been deleted", null, 200);
    }

}
