<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
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


        $propertDetails = Property::getPropertyByID(996);
        Mail::send(
            'mailing.admin.admins_notify',
            [
                'property_title' => $propertDetails->property_title,
                'created_by_name' => $propertDetails->created_by_name,
                'address' => $propertDetails->google_address,
            ],
            function ($message) use ($propertDetails, $request) {

                $adminEmails = DB::table('model_has_roles')->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                    ->where('role_id', 1)
                    ->where('users.email', '!=', null)
                    ->pluck('users.email')
                    ->toArray();
                $adminEmails[] = 'thejustgrouplimited@gmail.com';


                $subject =  'POSTED ' . ": {$propertDetails->property_title} Requires Approval";
                $message->from('app@justhomesapp.com', 'Just Homes');
                $message->to($adminEmails);
                $message->subject($subject);
            }


        );





        return Inertia::render('Home/Home', [
            'propertyTypes' => PropertyType::where('property_type_is_active', 1)
                ->orderBy('order', 'ASC')
                ->get(['id', 'property_type_name as name'])
        ]);
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


    public function governmentHouses()
    {



        return Inertia::render('Home/GovernmentHouses', [
            'listData' => Property::governMentHouses()

        ]);
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


    public function refundPolicy(Request $request)
    {
        return Inertia::render('Home/RefundPolicy', []);
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

        // Collect the validated data into an array
        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'userMessage' => $validatedData['message'], // Rename 'message' to 'userMessage'
            'telephone' => $validatedData['telephone'] ?? 'N/A', // Default to 'N/A' if telephone is not provided
        ];

        // Send the email
        Mail::send('mailing.contact', $data, function ($message) {
            $message->from('noreply@justhomes.co.ke', 'Just Homes');
            $message->to('info@justhomes.co.ke')->subject("Message from Just Home");
        });

        // Return a response
        return back()->with('success', 'Email sent successfully!');
    }




    public function addSubRegion(Request $request)
    {
        return Inertia::render('Home/AddSubRegions', [
            'subregions' => SubRegion::orderBy('id', 'DESC')->paginate(20),
            'towns' => Town::get(['id', 'town_name'])
        ]);
    }



    public function saveSubRegion(Request $request)
    {
        SubRegion::insert([
            'town_id' => $request['town'],
            'sub_region_name' => $request['regionName'],
            'is_active' => 1,
        ]);

        return redirect('/home/sub-region-list')->with(
            'success',
            'Saved Succeefully.'
        );
    }


    public function toggleSubregionStatus(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'subregionId' => 'required|integer|exists:sub_regions,id',
            'is_active' => 'required|boolean',
        ]);

        // Find the subregion by ID and update its is_active status
        $subregion = SubRegion::find($request->subregionId);
        $subregion->is_active = $request->is_active;
        $subregion->save();


        return redirect('/home/sub-region-list')->with(
            'success',
            'Edited Succeefully.'
        );

        // Optionally, you can return a response or redirect
        // return response()->json(['message' => 'Subregion status updated successfully.']);
    }



    public function deactivateAccount(Request $request)
    {
        return Inertia::render('Home/Deactivate', []);
    }
}
