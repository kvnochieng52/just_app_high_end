<?php

namespace App\Http\Controllers;

use App\Models\LeaseType;
use App\Models\Message;
use App\Models\PhoneLead;
use App\Models\Property;
use App\Models\PropertyCondition;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureGroup;
use App\Models\PropertyFurnish;
use App\Models\PropertyImage;
use App\Models\PropertySelectedFeauture;
use App\Models\PropertySubType;
use App\Models\PropertyType;
use App\Models\SubRegion;
use App\Models\Town;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use OpenGraph;
use Illuminate\Support\Str;

class PropertyController extends Controller
{



    public function propertyDetails($propertyTypeSlug, $propertySlug)
    {
        $property = Property::getPropertyBySlug($propertySlug);
        $propertyImages = PropertyImage::getPropertyImages($property->id);
        $lightShowArray = $propertyImages->pluck('image')->toArray();


        if (!empty($property->video_link)) {
            $lightShowArray[] = $property->video_link;
        }


        dd($property);


        return Inertia::render('Property/Details2', [
            'appUrl' => env('APP_URL'),
            'propertyDetails' => $property,
            'propertyImages' => $propertyImages,
            'lightShowImages' => $lightShowArray,
            'lightShowImageCount' => count($lightShowArray),
            'propertySelectedFeatures' => PropertySelectedFeauture::getPropertyFeatures($property->id),
            'metaDetails' => [
                'title' => $property->property_title,
                'description' => $property->property_description,
                'image_url' => env('APP_URL') . '/' . $property->thumbnail,
                'url' => env('APP_URL') . '/' . $property_type_slug . '/' . $property->slug
            ]
        ]);
    }


    public function post(Request $request)
    {




        return Inertia::render('Property/Post', [
            'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
        ]);
    }



    public function store(Request $request)
    {

        if ($request['step'] == 'new') {


            $this->validate($request, [
                'town' => 'required',
                'subRegion' => 'required',
                'propertyTitle' => 'required',
                'images' => 'required'
            ]);





            $property = new Property();
            $property->property_title = $request['propertyTitle'];
            $property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle')));
            $property->region_id = $request['subRegion'];
            $property->town_id = $request['town'];
            $property->created_by = Auth::user()->id;
            $property->updated_by = Auth::user()->id;
            $property->save();


            $imagepath  = public_path("uploads/images/");
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = Str::random(30) . "." . $image->getClientOriginalExtension();
                    $image->move($imagepath, $fileName);
                    $images[] =  "uploads/images/" . $fileName;
                }
            }


            if (!empty($images)) {
                $property->thumbnail = $images[0];
                $property->save();
                foreach ($images as $image) {
                    // $this->processImage($image);
                    PropertyImage::insert([
                        'property_id' => $property->id,
                        'image' => $image,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }



            return redirect('/post-edit/2/' . $property->id);
        }



        if ($request['step'] == 1) {
            $this->validate($request, [
                'town' => 'required',
                'subRegion' => 'required',
                'propertyTitle' => 'required'
            ]);

            Property::where('id', $request['propertyID'])->update([
                'property_title' => $request['propertyTitle'],
                'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle'))),
                'region_id' => $request['subRegion'],
                'town_id' => $request['town'],
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            return redirect('/post-edit/2/' . $request['propertyID']);
        }

        if ($request['step'] == 2) {


            $this->validate($request, [
                'propertType' => 'required',
                'propertyCondition' => 'required',
                'furnishStatus' => 'required',
                'leaseType' => 'required',
                'description' => 'required',
                'amount' => 'required',
                'address' => 'required',
            ]);



            Property::where('id', $request['propertyID'])->update([
                'type_id' => $request['propertType'],
                'sub_property_type_id' => $request['propertSubType'],
                'condition_id' => $request['propertyCondition'],
                'furnish_id' => $request['furnishStatus'],
                'parking_spaces' => $request['parking'],
                'measurements' => $request['measurement'],
                'bedrooms' => $request['bedrooms'],
                'address' => $request['address'],
                'lease_type_id' => $request['leaseType'],
                'property_description' => $request['description'],
                'amount' => $request['amount'],
                'is_active' => 1,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            return redirect('/post-edit/3/' . $request['propertyID']);
        }


        if ($request['step'] == 3) {



            if (!empty($request['video'])) {

                $video_data = OpenGraph::fetch($request['video']);

                Property::where('id', $request['propertyID'])->update([
                    'video_link' => $request['video'],
                    'video_thumb' => $video_data['image'],
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]);
            }
            if (!empty($request['selectedFeatures'])) {
                PropertySelectedFeauture::where('property_id', $request['propertyID'])->delete();
                foreach ($request['selectedFeatures'] as $feature) {
                    PropertySelectedFeauture::insert([
                        'property_id' => $request['propertyID'],
                        'group_id' => PropertyFeature::where('id', $feature)->first()->property_feature_group_id,
                        'feature_id' => $feature,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                }
            }

            return redirect('/dashboard')->with('success', 'Property Successfully Posted.');
        }
    }


    public function postEdit($step, $id)
    {

        if ($step == 1) {
            $property = Property::find($id);
            return Inertia::render('Property/PostEditBasic', [
                'property' => $property,
                'defaultSubRegion' => SubRegion::where('id', $property->region_id)->first(['sub_region_name AS text', 'id']),
                'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
            ]);
        }


        if ($step == 2) {

            return Inertia::render('Property/PostEdit', [
                'property' => Property::find($id),
                'propertyTypes' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->get(['property_type_name AS text', 'id']),
                'propertyConditions' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->get(['condition_name AS text', 'id']),
                'furnishStatuses' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->get(['furnish_name AS text', 'id']),
                'leaseTypes' => LeaseType::where('is_active', 1)->orderBy('order', 'ASC')->get(['lease_type_name AS text', 'id']),
            ]);
        }

        if ($step == 3) {



            return Inertia::render('Property/PostEditFinal', [
                'featureGroups' => PropertyFeature::propertyFeatures(),
                'property' => Property::find($id),
                'propertyFeatures' => PropertySelectedFeauture::where("property_id", $id)->pluck('feature_id')->toArray(),
            ]);
        }
    }



    public function fetchSubLocations($townId)
    {

        $subRegions = SubRegion::where('town_id', $townId)
            ->where('is_active', 1)
            ->orderBy('order', 'ASC')
            ->get(['sub_region_name AS text', 'id']);
        return response()->json([
            'success' => true,
            'data' => $subRegions
        ], 200);
    }



    public function fetchSubProperties($type_id)
    {

        $subRegions = PropertySubType::where('property_type_id', $type_id)
            ->where('is_active', 1)
            // ->orderBy('order', 'ASC')
            ->get(['property_sub_type_name AS text', 'id']);
        return response()->json([
            'success' => true,
            'data' => $subRegions
        ], 200);
    }




    public function uploadImages(Request $request)
    {

        if ($request->hasFile('imageFilepond')) {
            return $request->file('imageFilepond')->store('uploads/images', 'public');
        }

        return 'no';
    }


    protected function processImage($image)
    {
        if ($image) {
            $path = storage_path('app/public/' . $image);
            if (file_exists($path)) {
                copy($path, public_path($image));
                unlink($path);
            }
        }
    }

    public function postDelete($id)
    {


        Property::where('id', $id)->delete();
        return redirect('/dashboard')->with('success', 'Property Deleted.');
    }


    public function propertiesByType($propertyTypeSlug)
    {
        return Inertia::render('Property/TypeDetails', [
            'propertyTypeSlug' => $propertyTypeSlug,
            'propertyTypeDetails' => PropertyType::where('property_type_slug', $propertyTypeSlug)->first(),
        ]);
    }


    public function storeLead(Request $request)
    {

        PhoneLead::insert([
            'property_id' => $request['propertyID'],
            'user_id' => $request['userID'],
            'date' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            "success" => true,
        ]);
    }



    public function sendMessage(Request $request)
    {

        Message::insert([
            'name' => $request['name'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'message' => $request['message'],
            'user_id' => $request['userID'],
            'property_id' => $request['propertyID'],
            'date' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            "success" => true,
        ]);
    }
}
