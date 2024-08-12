<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
            'role' => 'required'
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

    protected $albarakaApiKey = 'your_api_key_here';
    protected $albarakaApiSecret = 'your_api_secret_here'; // modify according to the company's acccout

    public function payWithBank(Request $request): JsonResponse
    {
        $user_id = $request->input('user_id');
        $amount = $request->input('price');

        $user = User::find($user_id);

        if (!$user ) {
            return response()->json(['error' => 'User does not exist'], 403);
        }

        // Prepare the request body
        $body = [
            "amountToBeSend" => $amount,
            "bankCode" => 203, // Example bank code, replace with actual
            "bankName" => $user->bankName,
            "context" => [
                "channel" => "APIBANK",
                "language" => "en", // Adjust language as per your requirement
            ],
            "currencyCode" => null, // Adjust as per your requirement
            "date" => date("Y-m-d"), // Current date
            "explanation" => "Payment explanation", // Customize as needed
            "isReceiptIbanVisible" => true,
            "isfastTransfer" => false,
            "oyak" => true,
            "receiverAccountIdentifier" => [
                "branchCode" => 0, // Example values, replace with actual
                "number" => 0,
                "numberDetail" => "",
                "suffix" => 0,
            ],
            "senderAccount" => [
                "branchCode" => 0, // Example values, replace with actual
                "number" => 0,
                "numberDetail" => $user->accountNumber, // Assuming this is the sender's account number
                "suffix" => 0,
            ],
            "senderIban" => $user->iban, // Assuming you have the sender's IBAN
            "transferReason" => "D", // Customize as needed
        ];

        $generated_token = Auth::attempt(\request(null));
        $response = $user->post('https://api.albarakat.com/moneytransfers/v2/transfer/toaccountno', [
            'headers' => [
                'Authorization' => 'Bearer ' . $generated_token,
                'Content-Type' => 'application/json',
            ],
            'json' => $body,
        ]);

        $responseData = json_decode((string)$response->getBody(), true);

        if ($responseData['header']['status'] == 'SUCCESS') {
            // Handle successful payment
            $user->updatePaymentStatus(true);
            return response()->json(['message' => 'Payment processed successfully']);
        } else {
            // Handle payment failure
            return response()->json(['error' => 'Payment failed'], 400);
        }
    }


}
