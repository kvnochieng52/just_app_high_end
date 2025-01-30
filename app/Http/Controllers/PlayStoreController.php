<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlayStoreService;
use DOMDocument;
use DOMXPath;

class PlayStoreController extends Controller
{
    protected $playStoreService;

    public function __construct(PlayStoreService $playStoreService)
    {
        $this->playStoreService = $playStoreService;
    }

    public function getDownloads(Request $request)
    {
        // URL of the app on Google Play Store
        $url = "https://play.google.com/store/apps/details?id=ke.co.justhomes.app";

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute cURL request and get HTML response
        $html = curl_exec($ch);

        // Check if the request was successful
        if ($html === false) {
            return response()->json(['error' => 'Error fetching the page.'], 500);
        }

        // Load HTML into DOMDocument
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);

        // Create a DOMXPath object to query the HTML
        $xpath = new DOMXPath($dom);

        // Query the download section using XPath
        $downloads = $xpath->query('//div[@class="ClM7O"]');

        if ($downloads->length > 0) {
            // Get the download count text
            $downloads_text = $downloads->item(0)->nodeValue;
            return response()->json(['playStoreDownloads' => trim($downloads_text)]);
        } else {
            return response()->json(['error' => 'Download count not found.'], 404);
        }

        // Close cURL session
        curl_close($ch);
    }
}
