<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlayStoreService;

class PlayStoreController extends Controller
{
    protected $playStoreService;

    public function __construct(PlayStoreService $playStoreService)
    {
        $this->playStoreService = $playStoreService;
    }

    public function getDownloads(Request $request)
    {
        $appId = $request->input('app_id', 'com.whatsapp'); // Default app ID
        $downloads = $this->playStoreService->getAppDownloads($appId);
        return response()->json(['app_id' => $appId, 'downloads' => $downloads]);
    }
}
