<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
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
        $users = User::all();
        if (is_null($users))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "users has been retrieved", $users, 200);

    }
    /**
    */
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): Response
    {
        return (Response());
    }

    /**
     * Store a newly created resource in storage.
     *  @param Request $request
     * @return JsonResponse
     */

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'bankName' => 'required|string|max:255',
            'accountNumber' => 'required|numeric',
            'role' => 'in:admin,guide,user'
        ]);

        try {
            $user->update($fields);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            // Handle the error (e.g., return an error response)
        }

        return self::getResponse(true, "User has been updated", $user, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return self::getResponse(true, "User has been deleted", null, 200);

    }

    /**
     * Retrieve all guides
     */
    public function getAllGuides(): JsonResponse
    {
        $guides = User::where('role', 'guide')->get();
        if (is_null($guides))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "Data Retrieved ", $guides, 200);

    }

    public function getAllCustomers(): JsonResponse
    {
        $customers = User::where('role', 'user')->get();

        if ($customers->isEmpty()) {
            return self::getResponse(false, "No data available", null, 204);
        }

        return self::getResponse(true, "Data Retrieved ", $customers, 200);
    }

}
