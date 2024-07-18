<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\stationTrip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StorestationTripRequest;
use App\Http\Requests\UpdatestationTripRequest;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;

class StationTripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $stationTrips = StationTrip::all();
        if (is_null($stationTrips))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "stationTrips has been retrieved", $stationTrips);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'station_id' => 'required','exists:stations,id',
            'trip_id' => 'required','exists:trips,id',
             'daysNum' => 'required|int|max:255'
        ]);

        $stationTrip = StationTrip::query()->create([
            'station_id' => $request->station_id,
            'trip_id' => $request->trip_id,
            "daysNum"=>$request->daysNum
        ]);

        if (!$stationTrip) {
            return self::getResponse(false, "error in create ", null, 400);
        }
//
        return self::getResponse(true, "success", $stationTrip,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(stationTrip $stationTrip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stationTrip $stationTrip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, stationTrip $stationTrip): \Illuminate\Http\JsonResponse
    {
        $fields = $request->validate([
                'station_id' => 'required','exists:stations,id',
                'trip_id' => 'required','exists:trips,id',
                'daysNum' => 'required|int|max:255'
        ]);

        try {
            $stationTrip->update($fields);
        } catch (\Exception $e) {
            Log::error('Error updating stationTrip: ' . $e->getMessage());
            // Handle the error (e.g., return an error response)
        }

        return self::getResponse(true, "success", $stationTrip, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stationTrip $stationTrip): \Illuminate\Http\JsonResponse
    {
        $stationTrip->delete();
        return self::getResponse(true, "stationTrip has been deleted", null, 200);

    }




}
