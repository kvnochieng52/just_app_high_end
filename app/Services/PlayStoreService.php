<?php

namespace App\Services;

class PlayStoreService
{
    public function getAppDownloads($appId)
    {
        // $scriptPath = base_path('node-scripts/getDownloads.js'); 
        // $command = "node " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);
        // return trim(shell_exec($command));


        $nodePath = '/home/u221314161/.nvm/versions/node/v22.13.1/bin/node'; // Full path to node
        $scriptPath = base_path('node-scripts/getDownloads.mjs');
        $command = $nodePath . " " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);
        $output = shell_exec($command);
        return trim($output);
    }
}
