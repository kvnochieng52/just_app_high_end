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
            'screenshot' => 'nullable|mimes:jpeg,png,gif|max:10240', // Max size 10MB
            'description' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id', // Ensure user_id is provided and valid
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the video file is present
        if ($request->hasFile('video')) {
            $video = $request->file('video');

            // Generate a unique file name for the video
            $videoFileName = time() . '_' . $video->getClientOriginalName();
            // Define the destination path for the video
            $videoDestinationPath = public_path('videos'); // Pointing to public/videos

            // Ensure the public/videos directory exists
            if (!file_exists($videoDestinationPath)) {
                mkdir($videoDestinationPath, 0755, true);
            }

            // Move the uploaded video to the public/videos directory
            $video->move($videoDestinationPath, $videoFileName);

            // Create the path for the video
            $videoPath = 'videos/' . $videoFileName;

            // Initialize screenshot path
            $screenshotPath = null;

            // Check if the screenshot file is present
            if ($request->hasFile('screenshot')) {
                $screenshot = $request->file('screenshot');

                // Generate a unique file name for the screenshot
                $screenshotFileName = time() . '_screenshot.' . $screenshot->getClientOriginalExtension();
                // Define the destination path for the screenshot
                $screenshotDestinationPath = public_path('screenshots'); // Pointing to public/screenshots

                // Ensure the public/screenshots directory exists
                if (!file_exists($screenshotDestinationPath)) {
                    mkdir($screenshotDestinationPath, 0755, true);
                }

                // Move the uploaded screenshot to the public/screenshots directory
                $screenshot->move($screenshotDestinationPath, $screenshotFileName);

                // Create the path for the screenshot
                $screenshotPath = 'screenshots/' . $screenshotFileName;
            }

            // Save video details in the database
            $videoRecord = new ReelVideo();
            $videoRecord->video_path = $videoPath; // Store the path relative to public
            $videoRecord->screenshot = $screenshotPath; // Save screenshot path
            $videoRecord->user_id = $request->input('user_id');
            $videoRecord->description = $request->input('description');
            $videoRecord->created_by = $request->input('user_id');
            $videoRecord->updated_by = $request->input('user_id');
            $videoRecord->save();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'path' => asset($videoPath), // Use asset() to get the full URL
                'screenshot' => $screenshotPath ? asset($screenshotPath) : null // Include screenshot URL if available
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No video file found'
        ], 400);
    }



    public function getVideos(Request $request)
    {
        try {
            $videos = ReelVideo::with(['comments', 'user'])
                ->orderBy('id', 'DESC')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $videos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve videos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function getDetails(Request $request)
    {
        try {
            $details = ReelVideo::with('comments')->where('id', $request['videoId'])->first();

            if ($details) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'details' => $details,
                        'comments' => $details->comments
                    ],
                    'message' => 'Video details retrieved successfully.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the video details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
