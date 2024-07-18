<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
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
        $station = Station::all();
        if (is_null($station))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "station has been retrieved", $station, 200);
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
            'address' => 'required|string|max:255',
            'contactInfo' => 'required|string|max:255',
            'type' => 'in:restaurant,hotel,other'
        ]);

        $name =time().$request->photo->getClientOriginalName();
        $path = $request->file('photo')->storeAs('photos/images',$name,'public');

        $station = Station::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => 'storage/'.$path,
            'address' => $request->address,
            'contactInfo'=> $request->contactInfo,
            'type'=> $request->type
        ]);

        if (is_null($station)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "product has been created", $station, 200);

    }

    /**
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param Station $station
     * @return JsonResponse
     */
    public function update(Request $request, Station $station): JsonResponse
    {

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|image',
            'address' => 'required|string|max:255',
            'contactInfo'=> 'string',
            'type'=> 'enum'

        ]);

        if ($request->has('photo')) {
            $name = time() . $request->photo->getClientOriginalName();
            $path = $request->file('photo')->storeAs('photos/images', $name, 'public');
            $fields['photo'] = 'storage/'.$path; // Update the 'photo' field with the stored path
        }

        try {
            $station->update($fields);
        } catch (\Exception $e) {
            Log::error('Error updating trip: ' . $e->getMessage());
            // Handle the error (e.g., return an error response)
        }

        return self::getResponse(true, "Station has been updated", $station, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station): JsonResponse
    {
        $station->delete();
        return self::getResponse(true, "Station has been deleted", null, 200);
    }
}
