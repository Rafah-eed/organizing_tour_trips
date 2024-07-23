<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Trip;
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

        $trip = Trip::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => 'storage/'.$path,
            'capacity' => $request->capacity
        ]);


        if (is_null($trip)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "product has been created", $trip, 200);

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

        $trip->station->attach($request->station_id);

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

    /**
     * attach stations to a trip
     */
    public function attachStationToTrip(Request $request, $tripId): JsonResponse
    {
        // Retrieve the trip instance
        $trip = Trip::find($tripId);

        // Check if the trip exists
        if (!$trip) {
            return response()->json(['error' => 'Trip not found'], 404);
        }

        // Retrieve the station_id from the request
        $stationId = $request->input('station_id');
        $daysNum = $request->input('daysNum');

        // Validate the station_id
        if (!$stationId) {
            return response()->json(['error' => 'Station ID is required'], 400);
        }

        // Attach the station to the trip
        $trip->stations()->attach($stationId, ['daysNum' => $daysNum]);

        // Return a successful response
        return response()->json(['success' => 'Station attached successfully'], 200);
    }

    /**
     * Get all stations for a certain trip
     */
    public function allStationsForTrip(Trip $trip): \Illuminate\Http\JsonResponse
    {

        $trip->load('stations');

        $stationsData = [];

        foreach ($trip->stations as $station) {
            $stationsData[] = [
                'id' => $station->id,
                'name' => $station->name,
                'description' => $station->description,
                'photo' => $station->photo,
                'address' => $station->address,
                'contactInfo' => $station->contactInfo,
                'type' => $station->type,
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $stationsData,
        ], 200);

    }


    /**
     * search in trips
     */
    public function search(Request $request): JsonResponse
    {
        $searchTerm = $request->get('term');

        $query = Trip::query();


           $trips= $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%')->orderBy('created_at', 'desc')->get();

        if (!empty($query)) {
            return response()->json([
                'status' => true,
                'data' => $trips,
            ], 200);

        }

        return response()->json([
            'status' => false,
            'data' => "the searched Item does not exist... Try different words ",
        ], 200);

    }

}
