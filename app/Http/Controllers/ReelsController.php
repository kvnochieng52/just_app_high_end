<?php

namespace App\Http\Controllers;

use App\Models\ReelVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReelsController extends Controller
{
    public function uploadVideo(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // Max size 100MB
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the file is present
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            // Generate a unique file name
            $fileName = time() . '_' . $video->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('videos'); // Pointing to public/videos

            // Ensure the public/videos directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move the uploaded file to the public/videos directory
            $video->move($destinationPath, $fileName);

            // Create the path for the video
            $path = 'videos/' . $fileName;

            // Save video details in the database
            $videoRecord = new ReelVideo();
            $videoRecord->video_path = $path; // Store the path relative to public
            $videoRecord->user_id = $request->input('user_id');
            $videoRecord->description = $request->input('description');
            $videoRecord->created_by = $request->input('user_id');
            $videoRecord->updated_by = $request->input('user_id');
            $videoRecord->save();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'path' => asset($path) // Use asset() to get the full URL
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No video file found'
        ], 400);
    }
}
