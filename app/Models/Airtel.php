<?php

namespace App\Models;

use RazorInformatics\DPOPhp\DPOPhp;

class Airtel extends DPOPhp
{
    public function generateTokenPublic(
        string $reference,
        int $serviceType,
        float $paymentAmount,
        string $customerFirstName,
        string $customerLastName,
        string $customerPhoneNumber,
        string $customerEmail,
        string $currency = 'KES',
        string $description = ''
    ) {
        return $this->payment()->generateToken(
            $reference,
            $serviceType,
            $paymentAmount,
            $customerFirstName,
            $customerLastName,
            $customerPhoneNumber,
            $customerEmail,
            $currency,
            $description
        );
    }

    // You can also add other airtel-specific methods here
}
