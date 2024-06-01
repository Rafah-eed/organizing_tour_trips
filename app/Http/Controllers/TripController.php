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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'is_open' => 'boolean', 
            'capacity' => 'required|int|max:1000', 
        ]);
        

        $todo = Todo::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $request->photo,
            'is_open' => $request->is_open,
            'capacity' => $request->capacity,
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
        $trips = trips::find($id);
        return response()->json([
            'status' => 'success',
            'trips' => $trips,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|string|max:255',
            'is_open' => 'boolean', 
            'capacity' => 'required|int|max:1000', 
        ]);

        $trips = trips::find($id);


        $trips->title = $trips->title;
        $trips->description = $trips->description;
        $trips->photo = $trips->photo;
        $trips->is_open = $trips->is_open;
        $trips->capacity = $trips->capacity;
        $todo->save();

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
        $trips = trips::find($id);
        $trips->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'trip deleted successfully',
            'trip' => $tripss,
        ]);
    }
}
