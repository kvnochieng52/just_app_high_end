<?php

namespace App\Services;

class PlayStoreService
{
    public function getAppDownloads($appId)
    {
        $scriptPath = base_path('node-scripts/getDownloads.mjs'); // Change .js to .mjs
        // $command = "node " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);

        $command = "node -v";

        dd($command);
        return trim(shell_exec($command)); // Execute and return output
    }
}
