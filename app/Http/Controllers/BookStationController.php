<?php

namespace App\Http\Controllers;

use App\Models\bookStation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class BookStationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stations = bookStation::all();
        if (is_null($stations))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "all booking records for stations has been retrieved", $stations, 200);

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
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required','exists:stations,id',
            'user_id' => 'required','exists:users,id',
            'date' => 'required | date',
            'daysNum' => 'required',
        ]);

        $bookStation = bookStation::create([
            'station_id' => $request->station_id,
            'user_id' => $request->user_id,
            'date' => $request->date,
            'daysNum' => $request->daysNum
        ]);

        if (is_null($bookStation)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "the station has been reserved", $bookStation, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(bookStation $bookStation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bookStation $bookStation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bookStation $bookStation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bookStation $bookStation)
    {
        $bookStation->delete();
        return self::getResponse(true, "the reservation of the station has been deleted", null, 200);
    }

}
