<?php

namespace App\Http\Controllers;

use App\Events\VideoUpdated;
use App\Models\ReelComment;
use App\Models\ReelVideo;
use App\Models\UserReelsLike;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            $videos = ReelVideo::with(['comments.user', 'user']) // Load user for comments as well
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


    public function getVideosPaginated(Request $request)
    {
        try {
            $videos = ReelVideo::with(['comments.user', 'user']) // Load user for comments as well
                ->orderBy('id', 'DESC')
                ->paginate(2); // Paginate with 2 videos per page

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
            $details = ReelVideo::with(['comments', 'user'])->where('id', $request['videoId'])->first();

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


    public function postComment(Request $request)
    {
        // Validate the request data
        $request->validate([
            'videoID' => 'required|integer',
            'comment' => 'required|string',
            'userID' => 'required|integer',
        ]);

        try {
            // Insert the comment
            ReelComment::insert([
                'video_id' => $request['videoID'],
                'comment' => $request['comment'],
                'created_by' => $request['userID'],
                'updated_by' => $request['userID'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully.',
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to post comment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateLikes(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'videoId' => 'required|integer|exists:reel_videos,id',
            'likes' => 'required|integer|min:0',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            // Update the likes count in the database
            $video = ReelVideo::find($request['videoId']);
            $video->likes = $request['likes'];
            $video->updated_by = $request['user_id'];
            $video->updated_at = Carbon::now()->toDateTimeString();
            $video->save();

            $isLiked = $request['isLiked'];


            Log::info('LIKE: ' . $isLiked);



            $checkUser = UserReelsLike::where('user_id', $request['user_id'])->where('video_id', $request['videoId'])->first();


            if ($isLiked == 'true') {
                if (empty($checkUser)) {
                    UserReelsLike::insert([
                        'user_id' => $request['user_id'],
                        'video_id' => $request['videoId'],
                        'created_by' => $request['user_id'],
                        'updated_by' => $request['user_id'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            } else {
                Log::info('ELSE: ' . "user " . $request['user_id'] . " video " . $request['videoId']);
                UserReelsLike::where('user_id', $request['user_id'])->where('video_id', $request['videoId'])->delete();
            }






            // broadcast(new VideoUpdated($video));


            return response()->json([
                'success' => true,
                'message' => 'Likes updated successfully.',
                'likes' => $video->likes,
                'shares' => $video->shares,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating likes.',
            ], 500);
        }
    }



    public function updateShares(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'videoId' => 'required|integer|exists:reel_videos,id',
            'shares' => 'required|integer|min:0',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            // Update the shares count in the database
            $video = ReelVideo::find($request['videoId']);
            $video->shares = $request['shares'];
            $video->updated_by = $request['user_id'];
            $video->updated_at = Carbon::now()->toDateTimeString();
            $video->save();

            // Trigger the Pusher event
            broadcast(new VideoUpdated($video));
            Log::info('Pusher event triggered for video ID: ' . $video->id);

            return response()->json([
                'success' => true,
                'message' => 'Shares updated successfully.',
                'likes' => $video->likes,
                'shares' => $video->shares,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating shares.',
            ], 500);
        }
    }


    public function getLikesStatus(Request $request)
    {
        try {
            // Validate the incoming request to ensure videoId is present
            $request->validate([
                'videoId' => 'required|integer|exists:reel_videos,id', // Assuming the table name is reel_videos
            ]);

            $video = ReelVideo::find($request['videoId']);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'likes' => $video->likes,
                'shares' => $video->shares,
            ]);
        } catch (\Exception $e) {
            // Log the exception message for debugging


            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching likes status.',
            ], 500);
        }
    }


    public function getUserReels(Request $request)
    {
        try {
            // Validate the request data (ensure user_id is present)
            $request->validate([
                'user_id' => 'required|integer|exists:users,id', // Adjust 'users' to your actual users table
            ]);

            // Fetch reels for the specified user


            $userReels = ReelVideo::with(['comments.user', 'user'])
                ->where('user_id', $request->input('user_id'))
                ->orderBy('id', 'DESC')
                ->get();

            // Check if any reels were found
            if ($userReels->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No reels found for this user.',
                    'data' => [],
                ], 404); // Not Found status
            }

            // Return the user reels as JSON
            return response()->json([
                'success' => true,
                'message' => 'User reels retrieved successfully.',
                'data' => $userReels,
            ], 200); // OK status

        } catch (\Exception $e) {
            // Handle exceptions and return a JSON error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving user reels.',
                'error' => $e->getMessage(), // Include the exception message for debugging (optional)
            ], 500); // Internal Server Error status
        }
    }


    public function deleteReel(Request $request)
    {
        try {
            // Validate the request to ensure 'reelId' is provided
            $request->validate([
                'reelId' => 'required|integer|exists:reel_videos,id', // Ensure it exists in the database
            ]);

            // Delete the reel
            $deleted = ReelVideo::where('id', $request['reelId'])->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reel deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Reel could not be deleted. Please try again.',
                ], 400);
            }
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function getUserLikes(Request $request)
    {
        $videos = UserReelsLike::where('user_id', $request['user_id'])->pluck('video_id');

        return response()->json([
            'success' => true,
            'data' => $videos,
            'message' => 'user liked videos',
        ]);
    }
}
