<?php

namespace App\Http\Controllers;

use App\Models\GuidesDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;


class GuidesDetailsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::find($request->user_id);

        // Check if the user is a guide
        if (!$user || !$user->isGuide()) {
            return response()->json(['error' => 'User is not a guide'], 403);
        }

        $request->validate([
            'user_id' => 'required','exists:users,id',
            'TotalTrips' => 'required|integer',
            'salary' => 'required|numeric|digits_between:1,255'
        ]);

        $guidesDetails = GuidesDetails::create([
            'user_id' => $request->user_id,
            'TotalTrips' => $request->TotalTrips,
            'salary'=> $request->salary
        ]);

        if (is_null($guidesDetails)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "guidesDetails has been added", $guidesDetails, 200);

        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuidesDetails $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GuidesDetails $guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuidesDetails $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuidesDetails $guide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuidesDetails $guide)
    {
        //
    }
}
