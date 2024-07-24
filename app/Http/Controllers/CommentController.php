<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
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
        $comments = Comment::all();
        if (is_null($comments))
            return self::getResponse(false, "No data available", null, 204);

        return self::getResponse(true, "comments has been retrieved", $comments, 200);
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
            'trip_id' => 'required','exists:trips,id',
            'user_id' => 'required','exists:users,id',
            'comment' => 'required|string|max:255',
            'rating' => 'required|between:1,5'
        ]);

        $comment = Comment::create([
            'trip_id' => $request->trip_id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
            'rating'=> $request->rating
        ]);

        if (is_null($comment)) {
            return self::getResponse(true, "error in create ", null, 204);
        }
        return self::getResponse(true, "comment has been created", $comment, 200);

    }


    /**
     *
     * Update the specified resource in storage.
     * it works for showing the comment of provided IDs
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $fields = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'string|max:255',
            'rating' => 'between:1,5'
        ]);

        // Attempt to find the comment based on trip_id and user_id
        $existingComment = Comment::where('trip_id', $fields['trip_id'])
            ->where('user_id', $fields['user_id'])
            ->first();

        if (!$existingComment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        try {
            // Update the found comment with the new details
            $existingComment->update([
                'comment' => $fields['comment'],
                'rating' => $fields['rating']
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating comment or rating: ' . $e->getMessage()); // Fixed unclosed parenthesis here
            return response()->json(['message' => 'Failed to update comment'], 500);
        }

        // Return success response with the updated comment
        return self::getResponse(true, "Comment and rating have been updated successfully.", $existingComment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return self::getResponse(true, "Comment has been deleted", null, 200);
    }

}
