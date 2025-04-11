<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Message;
use App\Models\PhoneLead;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyStatuses;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function pendingApproval(Request $request)
    {
        return Inertia::render('Admin/PendingApproval', [
            'properties' => Property::propertiesQuery()->where('properties.is_active', PropertyStatuses::PENDING)->get(),
        ]);
    }


    public function updateStatus($propertyID)
    {
        return Inertia::render('Admin/UpdateStatus', [
            'property' => Property::propertiesQuery()->where('properties.id', $propertyID)->first(),
        ]);
    }


    public function decision(Request $request)
    {



        Property::where('id', $request['property_id'])->update([
            'is_active' => $request['action'] == 'approve' ? PropertyStatuses::PUBLISHED : PropertyStatuses::REJECTED,
            'reject_comment' => $request['comment'],
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);



        $propertDetails = Property::getPropertyByID($request['property_id']);


        Mail::send(
            'mailing.admin.approve_notify',
            [
                'property_title' => $propertDetails->property_title,
                'created_by_name' => $propertDetails->created_by_name,
                'comment' => $request['comment'],
                'action' => $request['action'],
            ],
            function ($message) use ($propertDetails, $request) {

                $subject = ($request['action'] == 'approve' ? 'APPROVED' : 'DECLINED') . ": {$propertDetails->property_title}";
                $message->from('app@justhomesapp.com', 'Just Homes');
                $message->to($propertDetails->email);
                $message->subject($subject);
            }
        );


        return redirect('admin/pending-approval')->with('success', 'Property Updated');
    }
}
