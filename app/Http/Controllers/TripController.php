<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Trip;
//use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
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
        $trip = Trip::all();
        if (is_null($trip))
            return self::getResponse(false, "No data available", null, 204);

            return self::getResponse(true, "trips has been retrieved", $trip, 200);
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|image',
            'capacity' => 'required|int|max:255'
        ]);

//        $photo = $request->photo;
        $name =time().$request->photo->getClientOriginalName();
//        $photo->move('photos/images',$newPhoto);

        $path = $request->file('photo')->storeAs('photos/images',$name,'public');

        $trips = Trip::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => 'storage/'.$path,
            'capacity' => $request->capacity
        ]);

        if (is_null($trips)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "product has been created", $trips, 200);

    }



    /**
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param Trip $trip
     * @return JsonResponse
     */
    public function update(Request $request, Trip $trip): JsonResponse
    {

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|image',
            'capacity' => 'required|int|max:255'
        ]);

        if ($request->has('photo')) {
            $name = time() . $request->photo->getClientOriginalName();
            $path = $request->file('photo')->storeAs('photos/images', $name, 'public');
            $fields['photo'] = 'storage/'.$path; // Update the 'photo' field with the stored path
        }

        try {
            $trip->update($fields);
        } catch (\Exception $e) {
            Log::error('Error updating trip: ' . $e->getMessage());
            // Handle the error (e.g., return an error response)
        }

        return self::getResponse(true, "Trip has been updated", $trip, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip): JsonResponse
    {
        $trip->delete();
        return self::getResponse(true, "Trip has been deleted", null, 200);
    }
}
