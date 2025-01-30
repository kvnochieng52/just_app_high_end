<?php

namespace App\Services;

class PlayStoreService
{
    public function getAppDownloads($appId)
    {
        // $scriptPath = base_path('node-scripts/getDownloads.js'); 
        // $command = "node " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);
        // return trim(shell_exec($command));


        $nodePath = __DIR__ . '/node'; // Assuming 'node' is in your project root
        $scriptPath = __DIR__ . '/node-scripts/getDownloads.mjs';
        $command = $nodePath . " " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);
        $output = shell_exec($command);
        return trim($output);
    }
}
