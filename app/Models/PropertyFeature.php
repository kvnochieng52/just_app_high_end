<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    use HasFactory;


    public static function propertyFeatures()
    {

        $featureGroups = PropertyFeatureGroup::where('is_active', 1)->orderBy('order', 'ASC')->get([
            'id',
            'feature_group_name',
            'group_icon',
            'group_description',
        ]);

        foreach ($featureGroups as $group) {
            $group->features = self::where('is_active', 1)
                ->where('property_feature_group_id',  $group->id)
                ->orderBy('order', 'ASC')
                ->get([
                    'id',
                    'feature_name',
                    'feature_icon',
                    'feature_description'
                ]);
        }

        return $featureGroups;
    }
}
