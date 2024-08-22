<?php

namespace App\Services;

use App\Models\VerifiedPhone;
use Twilio\Rest\Client;

class OtpService
{
    protected $twilio;

    public function __construct()
    {
        // $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function sendOtp($phoneNumber, $code)
    {
        $otp = rand(100000, 999999);
        // $message = "Your verification code is: $otp";
        // $this->twilio->messages->create($phoneNumber, [
        //     'from' => env('TWILIO_PHONE_NUMBER'),
        //     'body' => $message
        // ]);

        $verifiedPhone = VerifiedPhone::where('phone', $phoneNumber)->first();

        if ($verifiedPhone) {
            $verifiedPhone->increment('sent_count');
            $verifiedPhone->update([
                'otp' => $otp,
                'code' => $code,
                'is_verified' => false,
            ]);
        } else {
            VerifiedPhone::create([
                'phone' => $phoneNumber,
                'otp' => $otp,
                'code' => $code,
                'sent_count' => 1,
                'is_verified' => false,
            ]);
        }
    }

    public function verify($phone, $otp)
    {
        $verifiedPhone = VerifiedPhone::where('phone', $phone)->first();
        if ($verifiedPhone && $verifiedPhone->otp == $otp) {
            $verifiedPhone->update(['is_verified' => true]);
            return [
                'success' => 1,
                'phone' => $phone,
                'code' => $verifiedPhone->code
            ];
        } else {
            return ['success' => 0];
        }
    }

    public function checkIsVerified($phone)
    {
        $verifiedPhone = VerifiedPhone::where('phone', $phone)->first();
        return $verifiedPhone ? $verifiedPhone->is_verified : false;
    }
}
