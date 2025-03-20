<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Message;
use App\Models\PhoneLead;
use App\Models\Product;
use App\Models\Property;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {


        return Inertia::render('Dashboard/Index', [
            'properties' => Property::getProperties(),
        ]);
    }


    public function dashboard(Request $request)
    {
        return Inertia::render('Dashboard/Dashboard', [
            'telephoneLeadsCount' => PhoneLead::where('user_id', Auth::user()->id)->count(),
            'messagesCount' => Message::where('user_id', Auth::user()->id)->count(),
            'appartmentsCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 1)->count(),
            'housesCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 2)->count(),
            'landsCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 7)->count(),
            'officeCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 3)->count(),
            'villasCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 4)->count(),
            'towhHouseCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 5)->count(),
            'shoppsCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 6)->count(),
            'recentMessages' => Message::leftJoin('properties', 'messages.property_id', 'properties.id')
                ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
                ->where('messages.user_id', Auth::user()->id)
                ->take(5)
                ->get([
                    'messages.*',
                    'properties.property_title',
                    'property_types.property_type_name',
                ])
        ]);
    }


    public function leads(Request $request)
    {
        return Inertia::render('Dashboard/Leads', [
            'telephoneLeadsCount' => PhoneLead::where('user_id', Auth::user()->id)->count(),
            'messagesCount' => Message::where('user_id', Auth::user()->id)->count(),
            'appartmentsCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 1)->count(),
            'housesCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 2)->count(),
            'officeCount' => Property::where('created_by', Auth::user()->id)->where('type_id', 3)->count(),
            'recentMessages' => Message::leftJoin('properties', 'messages.property_id', 'properties.id')
                ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
                ->where('messages.user_id', Auth::user()->id)
                ->get([
                    'messages.*',
                    'properties.property_title',
                    'property_types.property_type_name',
                ])
        ]);
    }





    public function userEdit($id)
    {

        $user = User::find($id);
        $role = DB::table('model_has_roles')->where('model_id', $id)->first();
        return Inertia::render('Dashboard/UserEdit', [
            'userDetails' => $user,
            'role' => $role->role_id,

        ]);
    }

    public function updateUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            // 'email' => 'required|email|unique:users,email',
            // 'mobile' => 'required|unique:users,telephone',
        ]);


        User::where('id', $request['UserID'])->update([
            'name'  => $request['name'],
            'email'  => $request['email'],
            'telephone'  => $request['mobile'],
            'company_name'  => $request['companyName'],
            'website'  => $request['website'],
            'facebook'  => $request['facebook'],
            'tiktok'  => $request['tiktok'],
            'twitter'  => $request['twitter'],
            'linkedin'  => $request['linkedin'],
            'is_active'  => $request['isActive'],
            'profile'  => $request['profile'],
        ]);

        DB::table('model_has_roles')->where('model_id', $request['UserID'])->update([
            'role_id' => $request['role']
        ]);

        return redirect('dashboard/users')->with('success', 'User Updated');
    }


    public function users(Request $request)
    {
        $users = User::leftJoin("model_has_roles", "model_has_roles.model_id", "users.id")
            ->leftJoin("roles", "model_has_roles.role_id", "roles.id")
            ->get([
                'users.*',
                'roles.name as role_name'
            ]);

        return Inertia::render('Dashboard/Users', [
            'users' => $users,

        ]);
    }


    public function create(Request $request)
    {

        return Inertia::render('Dashboard/Create', [
            'categories' => Category::where('visible', 1)->pluck('category_name', 'id')
        ]);
    }


    public function settings(Request $request)
    {
        return Inertia::render('Dashboard/Settings', [
            'userDetails' => User::find(Auth::user()->id),
        ]);
    }


    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            // 'email' => 'required|email|unique:users,email',
            // 'mobile' => 'required|unique:users,telephone',
        ]);


        User::where('id', $request['UserID'])->update([
            'name'  => $request['name'],
            'email'  => $request['email'],
            'telephone'  => $request['mobile'],
            'company_name'  => $request['companyName'],
            'website'  => $request['website'],
            'facebook'  => $request['facebook'],
            'tiktok'  => $request['tiktok'],
            'twitter'  => $request['twitter'],
            'linkedin'  => $request['linkedin'],
            'profile'  => $request['profile'],
        ]);

        return redirect('dashboard/settings')->with('success', 'Profile Updated');
    }


    public function userDelete($user_id)
    {
        User::where('id', $user_id)->delete();
        return redirect('dashboard/users')->with('success', 'User Deleted');
    }

    public function editPhoto(Request $request)
    {

        return Inertia::render('Dashboard/EditPhoto', [
            'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
        ]);
    }


    public function uploadProfilePhoto(Request $request)
    {

        if (!empty($request['uploadedImages'])) {

            $image = $request['uploadedImages'][0];

            if ($image) {
                $path = storage_path('app/public/' . $image);
                if (file_exists($path)) {
                    copy($path, public_path($image));
                    unlink($path);
                }
            }

            User::where('id', Auth::user()->id)->update([
                'avatar' => '/' . $image
            ]);
        }

        return redirect('dashboard')->with('success', 'Profile Photo Updated');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            // 'date_online' => 'required',
            // 'date_offline' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'

        ]);

        $product = new Product();

        $product->title = $request->input('title');
        $product->slug =  strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title')));
        $product->category_id = $request->input('category');
        $product->email = $request->input('email');
        $product->mobile = $request->input('telephone');
        $product->date_online = Carbon::parse($request->input('date_online'))->toDateTimeString();
        $product->date_offline = Carbon::parse($request->input('date_offline'))->toDateTimeString();
        $product->price = $request->input('price');
        $product->currency = env('CURRENCY');

        $product->description = $request->input('description');
        $product->created_by = Auth::user()->id;
        $product->updated_by = Auth::user()->id;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image_file = $request->file('image');
            $image_file_name = Str::random(30) . '.' . $image_file->getClientOriginalExtension();
            $image_file->move('images/', $image_file_name);
            $product->image =  $image_file_name;
        }

        $product->save();

        return redirect('dashboard/')->with('success', 'Product Created Successfully !');
    }




    // public function heatMap(Request $request)
    // {
    //     // Fetch the coordinates
    //     $coordinates = Property::where('is_active', 1)
    //         ->where('coordinates', '!=', null)
    //         ->pluck('coordinates');


    //     // dd($coordinates);

    //     // Transform the coordinates to an array of arrays with lat, long, and intensity
    //     $heatMapData = $coordinates->map(function ($coordinate) {
    //         $parts = explode(',', $coordinate);
    //         return [
    //             (float)$parts[0],  // Latitude
    //             (float)$parts[1],  // Longitude
    //             1 // Intensity
    //         ];
    //     });

    //     return Inertia::render('Dashboard/GoogleTemplate', [
    //         'heatMapData' => $heatMapData
    //     ]);
    // }



    public function heatMap(Request $request)
    {
        // Fetch the coordinates, ensuring they are not null or empty
        $coordinates = Property::where('is_active', 1)
            ->whereNotNull('coordinates')
            ->where('coordinates', '!=', '')
            ->pluck('coordinates');

        // Ensure the coordinates collection is not empty
        if ($coordinates->isEmpty()) {
            return Inertia::render('Dashboard/GoogleTemplate', [
                'heatMapData' => []
            ]);
        }

        // Transform the coordinates to an array of arrays with lat, long, and intensity
        $heatMapData = $coordinates->map(function ($coordinate) {
            $parts = explode(',', $coordinate);

            // Ensure we have valid latitude and longitude values
            if (count($parts) < 2 || !is_numeric($parts[0]) || !is_numeric($parts[1])) {
                return null; // Ignore invalid data
            }

            return [
                (float) $parts[0], // Latitude
                (float) $parts[1], // Longitude
                1 // Intensity
            ];
        })->filter(); // Remove null values from invalid coordinates

        return Inertia::render('Dashboard/GoogleTemplate', [
            'heatMapData' => $heatMapData->values() // Reset array keys
        ]);
    }
}
