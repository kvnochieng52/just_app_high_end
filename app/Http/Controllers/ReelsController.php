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

            // Store the file in the 'public/videos' directory
            $path = $video->storeAs('videos', $fileName, 'public');

            // Check if the file was successfully stored
            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload failed'
                ], 500);
            }

            $video = new ReelVideo();
            $video->video_path = $path;
            $video->user_id = $request->input('user_id');
            $video->description = $request->input('description');
            $video->created_by = $request->input('user_id');
            $video->updated_by = $request->input('user_id');
            $video->save();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'path' => Storage::url($path)
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No video file found'
        ], 400);
    }
}
