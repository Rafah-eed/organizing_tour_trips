<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Activate a Trip
     */
    public function activate(Request $request, $trip_id): JsonResponse
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'isOpened' => 'required',
            'start_date' => 'required|date',
            'price' => 'required|numeric'
        ]);

        // Retrieve the trip instance
        $trip = Trip::find($trip_id);

        // Check if the trip exists
        if (!$trip) {
            return response()->json(['error' => 'Trip not found'], 404);
        }

        // Retrieve the columns from the request
        $user_id = $request->input('user_id');
        $isOpened = $request->input('isOpened');
        $start_date = $request->input('start_date');
        $price = $request->input('price');
        // Validate the request data

        if (!$user_id || !$isOpened || !$start_date || !$price) {
            return response()->json(['error' => 'Missing required data'], 400);
        }

        // Attach the user to the trip with the active state
        try {
            $trip->users()->attach($user_id, [
                'isOpened' => $isOpened,
                'start_date' => $start_date,
                'price' => $price
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update trip status: " . $e->getMessage());
            return response()->json($e, 500);
        }

        // Return a successful response
        return response()->json(['success' => 'Trip status updated successfully'], 200);
    }
    /**
     * filter according to time,price and place
     */
    public function filter(Request $request): JsonResponse
    {
        $trips = Trip::query();

        if ($request->has('price')) {
            $trips = $trips->whereHas('actives', function ($query) use ($request) {
                $query->where('price', '=', (int)$request->price); //we can use >= or <= for min and max operations
            });
              //  ->orderBy('actives.price', 'desc'); // Order by start_date in descending order;
        }

        if ($request->has('name')) {
            $trips = $trips->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('start_date')) {
            $trips = $trips->whereHas('actives', function ($query) use ($request) {
                $query->whereDate('start_date', $request->start_date);
            });
              //  ->orderBy('actives.start_date', 'desc'); // Order by start_date in descending order
        }


        // Fetch the filtered trips
        $filteredTrips = $trips->get();

        // Return the filtered trips as a JSON response
        if (!empty($filteredTrips)) {
            return response()->json([
                'status' => true,
                'data' => $filteredTrips,
            ], 200);

        }
        return response()->json([
            'status' => false,
            'data' => "There are no trips yet ",
        ], 200);



    }


}
