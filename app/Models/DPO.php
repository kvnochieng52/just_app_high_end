<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Exception;
use RazorInformatics\DPOPhp\DPOPhp;

class DPO extends Model
{

    protected $companyToken;
    protected $accountType;
    protected $serviceTypeCode;
    protected $baseUrl = 'https://secure.3gdirectpay.com/API/v6/';
    protected $timeout = 30;



    public function __construct()
    {
        $this->companyToken = config('services.dpo.company_token');
        $this->accountType = config('services.dpo.account_type', 'test');
        $this->serviceTypeCode = config('services.dpo.service_type_code');
    }

    public  function initiatePayment($paymentMethod, $reference, $amount, $firstName, $lastName, $phone, $email, $description)
    {
        $dpo = new DPOPhp($this->companyToken);

        if ($paymentMethod == 'mpesa') {
            $results = $dpo->payment()->chargeMpesa($reference,  $this->serviceTypeCode, $amount, $firstName, $lastName, $phone, $email, $description);
            return $results;
        }


        if ($paymentMethod == 'airtel') {
        }


        // if ($paymentMethod == 'card') {
        //     $results = $dpo->payment()->card($reference,  $this->serviceTypeCode, $amount, $cardNumber, $cardExpiry, $cardCvv, $customerFirstName, $customerLastName, $customerPhone, $customerEmail, $currency, $description);
        //     return $results;
        // }
    }








    public  function initiatePayment2()
    {

        $dpo = new DPOPhp($this->companyToken);

        $transactionToken = '324B8488-F55F-445E-9544-85BE02A52B1E';

        $results = $dpo->token()->verify($transactionToken);

        dd($results);











        // return Inertia::render('Home/Home', [
        //     'propertyTypes' => PropertyType::where('property_type_is_active', 1)
        //         ->orderBy('order', 'ASC')
        //         ->get(['id', 'property_type_name as name'])
        // ]);
    }
}
