<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\SubRegion;
use App\Models\Town;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('Home/Home', []);
    }


    public function fetchLatestListings(Request $request)
    {
        //sleep(3);
        return Property::getLatestProperties(9);
    }


    public function fetchPropertiesByType($slug)
    {
        return Property::getPropertiesbyTypeSlug($slug);
    }


    public function fetchPropertiesImage($id)
    {
        // sleep(3);
    }

    public function fetchLocationAxios($location)
    {


        $finalArray = [];


        $towns = Town::where('is_active', 1)
            ->where('town_name', 'like', '%' . $location . '%')
            ->pluck('town_name', 'id')
            ->take(5)
            ->toArray();


        $subRegions = SubRegion::where('sub_regions.is_active', 1)
            ->leftJoin('towns', 'sub_regions.town_id', 'towns.id')
            ->where('sub_region_name', 'like', '%' . $location . '%')
            ->get([DB::raw("CONCAT(sub_region_name,', ',town_name) as region_name")])
            ->pluck('region_name')
            ->take(5)
            ->toArray();

        $finalArray = array_merge($towns, $subRegions);

        return $finalArray;
    }


    public function privacyPolicy(Request $request)
    {
        return Inertia::render('Home/PrivacyPolicy', []);
    }

    public function termsOfService(Request $request)
    {
        return Inertia::render('Home/TermsOfService', []);
    }


    public function contactUs(Request $request)
    {

        return Inertia::render('Home/ContactUs', []);
    }


    public function contactSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'telephone' => 'nullable|string|max:20',
        ]);

        Mail::send('mailing.contact', $validatedData, function ($message) use ($request) {
            $message->from('noreply@justhomes.co.ke');
            $message->to('info@justhomes.co.ke')->subject("Message from Just Home");
        });

        // Return a response (you can redirect or return a success message)
        return back()->with('success', 'Email sent successfully!');
    }
}
