<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySelectedFeauture extends Model
{
    use HasFactory;

    public static function getPropertyFeatures($propertyID)
    {


        $PropertyFeatures = PropertyFeatureGroup::where('is_active', 1)->get([
            'id',
            'feature_group_name'
        ]);

        foreach ($PropertyFeatures as $feature) {
            $feature->features = self::where('group_id', $feature->id)->where('property_id', $propertyID)
                ->leftJoin('property_features', 'property_selected_feautures.feature_id', 'property_features.id')
                ->get([
                    'property_selected_feautures.id',
                    'property_features.feature_name'
                ]);
        }

        return $PropertyFeatures;
    }
}
