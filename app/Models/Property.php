<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;

class Property extends Model
{
    use HasFactory;


    public static function propertiesQuery()
    {


        $subquery = DB::table('property_images')
            ->select(DB::raw('GROUP_CONCAT(image SEPARATOR ", ")'))
            ->whereColumn('property_images.property_id', 'properties.id');
        $query = self::select([
            'properties.*',
            'property_types.property_type_name',
            'property_types.property_type_slug',
            'towns.town_name',
            'sub_regions.sub_region_name',
            'property_conditions.condition_name',
            'property_furnishes.furnish_name',
            'lease_types.lease_type_name',
            'lease_types.lease_type_color_code',
            'users.name AS created_by_name',
            'users.created_at AS user_registered_date',
            'users.telephone AS created_by_telephone',
            'users.avatar AS created_by_avatar',
            'users.email',
            'users.company_name',
            'users.website',
            'users.facebook',
            'users.twitter',
            'users.tiktok',
            'users.linkedin',
            'users.profile',
            new Expression('(' . $subquery->toSql() . ') AS property_images')
        ])
            ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
            ->leftJoin('towns', 'properties.town_id', 'towns.id')
            ->leftJoin('sub_regions', 'properties.region_id', 'sub_regions.id')
            ->leftJoin('property_conditions', 'properties.condition_id', 'property_conditions.id')
            ->leftJoin('property_furnishes', 'properties.furnish_id', 'property_furnishes.id')
            ->leftJoin('lease_types', 'properties.lease_type_id', 'lease_types.id')
            ->leftJoin('users', 'properties.created_by', 'users.id');
        $query->mergeBindings($subquery);

        return $query;
    }



    public static function getProperties()
    {
        $query = self::propertiesQuery();


        $userRole = DB::table('model_has_roles')
            ->leftJoin("roles", "model_has_roles.role_id", "roles.id")
            ->where('model_id', Auth::user()->id)
            ->first(['roles.name']);

        $role = 'Standard';

        if (!empty($userRole)) {
            $role = $userRole->name;
        }

        if ($role == 'Admin') {
            $data = $query->get();
        } else {
            $data = $query->where('properties.created_by', Auth::user()->id)->get();
        }

        return $data;
    }


    public static function getPropertyByID($propertyID)
    {
        $query = self::propertiesQuery();
        $data = $query->where('properties.id', $propertyID)->first();

        return $data;
    }

    public static function getPropertyBySlug($slug)
    {
        $query = self::propertiesQuery();
        $data = $query->where('properties.slug', $slug)->first();

        return $data;
    }




    public static function getSimilarProperties($limit, $cretedByID, $currentProperty)
    {
        $query = self::propertiesQuery()->where('properties.created_by', $cretedByID)
            ->where('properties.id', '!=', $currentProperty)
            ->where('properties.is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
        return $query;
    }


    public static function getLatestProperties($limit)
    {


        $subquery = DB::table('property_images')
            ->select(DB::raw('GROUP_CONCAT(image SEPARATOR ", ")'))
            ->whereColumn('property_images.property_id', 'properties.id');

        $query = self::select([
            'properties.*',
            'property_types.property_type_name',
            'property_types.property_type_slug',
            'towns.town_name',
            'sub_regions.sub_region_name',
            'property_conditions.condition_name',
            'property_furnishes.furnish_name',
            'lease_types.lease_type_name',
            'lease_types.lease_type_color_code',
            'users.name AS created_by_name',
            'users.created_at AS user_registered_date',
            'users.telephone AS created_by_telephone',
            'users.avatar AS created_by_avatar',
            'users.email',
            'users.company_name',
            'users.website',
            'users.facebook',
            'users.twitter',
            'users.tiktok',
            'users.linkedin',
            'users.profile',
            new Expression('(' . $subquery->toSql() . ') AS property_images')
        ])
            ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
            ->leftJoin('towns', 'properties.town_id', 'towns.id')
            ->leftJoin('sub_regions', 'properties.region_id', 'sub_regions.id')
            ->leftJoin('property_conditions', 'properties.condition_id', 'property_conditions.id')
            ->leftJoin('property_furnishes', 'properties.furnish_id', 'property_furnishes.id')
            ->leftJoin('lease_types', 'properties.lease_type_id', 'lease_types.id')
            ->leftJoin('users', 'properties.created_by', 'users.id')
            ->where('properties.is_active', 1)
            ->whereNotNull('properties.property_title')
            ->orderBy('created_at', 'desc')
            ->take($limit);


        $query->mergeBindings($subquery);

        return $query->get();
    }


    public static function getPropertiesbyTypeSlug($slug)
    {
        $query = self::propertiesQuery();
        $data = $query->where('property_types.property_type_slug', $slug)->paginate(10);
        return $data;
    }


    public static function governMentHouses()
    {
        $query = self::propertiesQuery();
        $data = $query->where('properties.government_house', 1)->paginate(10);

        // dd($data);
        return $data;
    }

    public static function getUserProperties($userID)
    {
        $query = self::propertiesQuery();
        $query->where('properties.is_active', 1);
        $data = $query->where('properties.created_by', $userID)->get();
        return $data;
    }


    public static function getFavorites($user_id)
    {
        // $query = self::propertiesQuery();
        // $data = $query->where('properties.is_active', 1)
        // ->orderBy('created_at', 'desc')->take($limit)->get();
        // return $data;
        $userFavories = Favorite::where('user_id', $user_id)->pluck('property_id')->toArray();


        $subquery = DB::table('property_images')
            ->select(DB::raw('GROUP_CONCAT(image SEPARATOR ", ")'))
            ->whereColumn('property_images.property_id', 'properties.id')
            ->limit(5);

        $query = self::select([
            'properties.*',
            'property_types.property_type_name',
            'property_types.property_type_slug',
            'towns.town_name',
            'sub_regions.sub_region_name',
            'property_conditions.condition_name',
            'property_furnishes.furnish_name',
            'lease_types.lease_type_name',
            'lease_types.lease_type_color_code',
            'users.name AS created_by_name',
            'users.created_at AS user_registered_date',
            'users.telephone AS created_by_telephone',
            'users.avatar AS created_by_avatar',
            'users.email',
            'users.company_name',
            'users.website',
            'users.facebook',
            'users.twitter',
            'users.tiktok',
            'users.linkedin',
            'users.profile',
            new Expression('(' . $subquery->toSql() . ') AS property_images')
        ])
            ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
            ->leftJoin('towns', 'properties.town_id', 'towns.id')
            ->leftJoin('sub_regions', 'properties.region_id', 'sub_regions.id')
            ->leftJoin('property_conditions', 'properties.condition_id', 'property_conditions.id')
            ->leftJoin('property_furnishes', 'properties.furnish_id', 'property_furnishes.id')
            ->leftJoin('lease_types', 'properties.lease_type_id', 'lease_types.id')
            ->leftJoin('users', 'properties.created_by', 'users.id')
            ->where('properties.is_active', 1)
            ->whereIn('properties.id', $userFavories)
            ->orderBy('created_at', 'desc');


        $query->mergeBindings($subquery);

        return $query->get();
    }



    public static function getCordinates($townID, $subRegionID)
    {
        $townName = Town::where('id', $townID)->first()->town_name;
        $subRegionName = SubRegion::where('id', $subRegionID)->first()->sub_region_name;
        $country = 'KENYA';
        $address = $townName . ", " . $subRegionName . ", " . $country;

        $apiKey = 'AIzaSyBP_0fcfVMUL_4vQmkOa1dKjJJslcVUJ44'; // Replace with your Google API key
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK') {
            return [
                'success' => true,
                'latitude' => $data['results'][0]['geometry']['location']['lat'],
                'longitude' => $data['results'][0]['geometry']['location']['lng'],
                'coordinates' =>
                $data['results'][0]['geometry']['location']['lat'] . ',' . $data['results'][0]['geometry']['location']['lng'],
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }
}
