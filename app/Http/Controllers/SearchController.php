<?php

namespace App\Http\Controllers;

use App\Models\LeaseType;
use App\Models\Property;
use App\Models\PropertyCondition;
use App\Models\PropertyFeature;
use App\Models\PropertyFurnish;
use App\Models\PropertyStatuses;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {


        $leaseType = $request['leaseType'];
        $leaseTypeHome = $request['leaseTypeHome'];
        $region = $request['propertyLocation'];
        $propertyType = $request['propertyType'];



        //  dd($request['propertyLocation'], $request['address'], $request['town'], $request['subRegion'], $request['country'], $request['countryCode'], $request['latitude'], $request['longitude']);





        $minPrice = $request['minPrice'];
        $maxPrice = $request['maxPrice'];

        $onauction = $request['onauction'];

        $governmentHousing = $request['governmentHousing'];


        if ($request['quickSearch'] == 1) {
            if (!empty($request['selectedPrice'])) {
                $priceArray = (explode(' - ', $request['selectedPrice']['id']));
                $minPrice = $priceArray[0];
                $maxPrice = empty($priceArray[1]) ? 100000000000000000 : $priceArray[1];
            }
        }



        $condition = $request['condition'];
        $bedroom = $request['bedroom'];
        $parking = $request['parking'];
        $furnishType = $request['furnishType'];


        $offplan = $request['offplan'];





        $query = Property::propertiesQuery();
        $data = $query;

        if (!empty($request['search']) && $request['search'] == 1) {



            if (!empty($region)) {

                $regionsArray = explode(',', $region);

                // dd($regionsArray);

                $data->where(function ($query) use ($regionsArray, $region) {
                    $query->where('google_address', 'like', '%' . $regionsArray[0] . '%')
                        ->orWhere('google_address', 'like', '%' . $region . '%')
                        ->orWhere('google_address', 'like', '%' . $region)

                        //  ->orWhere('town_name', 'like', '%' . $regionsArray[0] . '%')
                        ->orWhere('town_name', 'like', '%' . $region . '%')
                        ->orWhere('sub_region_name', 'like', '%' . $region . '%')
                        ->orWhere('address', 'like', '%' . $region . '%');
                });
            }

            if (!empty($leaseType)) {
                $data->where('lease_type_id', $leaseType);
            }

            if (!empty($leaseTypeHome)) {
                $data->where('lease_type_id', $leaseTypeHome);
            }

            if (!empty($propertyType)) {
                $data->whereIn('type_id', $propertyType);
            }

            if (
                !empty($minPrice) &&
                !empty($maxPrice)
            ) {
                $data->where(function ($query) use ($minPrice, $maxPrice) {
                    $query->where('amount', '>=', $minPrice)
                        ->where('amount', '<=', $maxPrice);
                });
            }

            if (!empty($condition)) {
                $data->whereIn('condition_id', $condition);
            }

            if (!empty($bedroom)) {
                $data->whereIn('bedrooms', $bedroom);
            }

            if (!empty($parking)) {
                $data->where('parking_spaces', $parking);
            }

            if (!empty($furnishType)) {
                $data->whereIn('furnish_id', $furnishType);
            }


            if (!empty($offplan) && $offplan != 'all') {
                $data->where('on_offplan', $offplan);
            }

            if (!empty($onauction)) {
                $data->where('on_auction', ' 1');
            }
        }


        if (!empty($request['leaseTypeHome'])) {
            $leaseType = $request['leaseTypeHome'];
        }

        $data->where('properties.is_active', PropertyStatuses::PUBLISHED);
        $data->orderBy('id', 'DESC');



        $properties = $data->paginate(12);
        return Inertia::render('Property/Search', [
            'properties' => $properties,
            'propertyTypes' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->get(),
            'leaseTypes' => LeaseType::where('is_active', 1)->orderBy('order', 'ASC')->get(),
            'propertyConditions' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->get(),
            'furnishTypes' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->get(),
            'propertyFeatures' => PropertyFeature::propertyFeatures(),

            'defaultFormValues' => [
                'leaseTypeDef' => !empty($request['leaseType']) ? $request['leaseType'] : [],
                // 'region' => !empty($request['region']) ? $request['region'] : "",
                'propertyTypeDef' => !empty($request['propertyType']) ? $request['propertyType'] : [],
                'minPrice' => !empty($request['minPrice']) ? $request['minPrice'] : "",
                'maxPrice' => !empty($request['maxPrice']) ? $request['maxPrice'] : "",
                'conditionDef' => !empty($request['condition']) ? $request['condition'] : [],
                'bedroom' => !empty($request['bedroom']) ? $request['bedroom'] : "",
                'parking' => !empty($request['parking']) ? $request['parking'] : "",
                'furnishTypeDef' => !empty($request['furnishType']) ? $request['furnishType'] : [],
                'regionDef' => !empty($request['propertyLocation']) ? $request['propertyLocation'] : "",
            ],
        ]);
    }
}
