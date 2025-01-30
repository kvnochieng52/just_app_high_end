<?php


namespace App\Services;

class PlayStoreService
{
    public function getAppDownloads($appId)
    {
        // Full path to node and script
        $nodePath = '/home/u221314161/.nvm/versions/node/v22.13.1/bin/node';
        $scriptPath = base_path('node-scripts/getDownloads.mjs'); // Path to your script

        // Constructing the command to run the node script with the appId as argument
        $command = "source ~/.bashrc && $nodePath " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);

        // Execute the command
        $output = shell_exec($command);

        // Return the output of the command
        dd($output);  // For debugging purposes, you can use dd() to inspect the result.

        return trim($output);
    }
}
