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
        //$command = $nodePath . " " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);

        $command = "/home/u221314161/.nvm/versions/node/v22.13.1/bin/node '/home/u221314161/domains/justhomes.co.ke/public_html/node-scripts/getDownloads.mjs' 'ke.co.justhomes.app'";


        $command = "source ~/.bashrc && /home/u221314161/.nvm/versions/node/v22.13.1/bin/node";

        // $command = "source ~/.bashrc && /home/u221314161/.nvm/versions/node/v22.13.1/bin/node " . escapeshellarg($scriptPath) . " " . escapeshellarg($appId);

        $output = shell_exec($command);

        dd($output);

        return trim($output);
    }
}
