<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Trip;
//use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Http\Response;

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
            'photo' => 'photos/images'.$path,
            'capacity' => $request->capacity
        ]);

        if (is_null($trips)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "product has been created", $trips, 200);

    }





    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
       // $trip = Trip::find($id);
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

      //  $trips = Trip::find($id);


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
    //    $trip = Trip::find($id);
        $trip->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'trip deleted successfully',
            'trip' => $trip,
        ]);
    }
}
