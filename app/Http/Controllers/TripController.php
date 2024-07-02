<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $trips = trips::all();
        return response()->json([
            'status' => 'success',
            'trips' => $trips,
        ]);
    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|string|max:255',
            'capacity' => 'required|int|max:1000'
        ]);
        

        $trips = Trip::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $request->photo,
            'capacity' => $request->capacity
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'trip created successfully',
            'trips' => $trips,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        $trip = Trip::find($id);
        return response()->json([
            'status' => 'success',
            'trip' => $trip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trips)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|string|max:255',
            'capacity' => 'required|int|max:255'
        ]);

        $trips = Trip::find($id);


        $trips->title = $request->title;
        $trips->description = $request->description;
        $trips->photo = $request->photo;
        $trips->capacity = $request->capacity;
        $trips->save();

        return response()->json([
            'status' => 'success',
            'message' => 'trip updated successfully',
            'trip' => $trips,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip = Trip::find($id);
        $trip->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'trip deleted successfully',
            'trip' => $trip,
        ]);
    }
}
