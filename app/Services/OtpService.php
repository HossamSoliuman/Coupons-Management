<?php

namespace App\Services;

use App\Models\Log;
use App\Models\VerifiedPhone;
use Illuminate\Support\Facades\Http;

class OtpService
{
    public function sendOtp($phoneNumber, $code)
    {

        $response = $this->sendWithAuthentica($phoneNumber);

        if ($response['success'] == true) {
            $verifiedPhone = VerifiedPhone::where('phone', $phoneNumber)->first();

            if ($verifiedPhone) {
                $verifiedPhone->increment('sent_count');
                $verifiedPhone->update([
                    'code' => $code,
                    'is_verified' => false,
                ]);
            } else {
                VerifiedPhone::create([
                    'phone' => $phoneNumber,
                    'code' => $code,
                    'sent_count' => 1,
                    'is_verified' => false,
                ]);
            }
        } else {
        }
        return $response;
    }

    public function verify($phone, $otp)
    {
        $response = $this->verifyWithAuthentica($phone, $otp);

        if ($response['status'] == true) {
            $verifiedPhone = VerifiedPhone::where('phone', $phone)->first();
            if ($verifiedPhone) {
                $verifiedPhone->update(['is_verified' => true]);
                return [
                    'success' => 1,
                    'phone' => $phone,
                    'code' => $verifiedPhone->code,
                    'message' => $response
                ];
            }
        }

        return [
            'success' => 0,
            'message' => $response
        ];
    }

    public function checkIsVerified($phone)
    {
        $verifiedPhone = VerifiedPhone::where('phone', $phone)->first();
        return $verifiedPhone ? $verifiedPhone->is_verified : false;
    }

    private function sendWithAuthentica($phone)
    {
        $phone = '+966' . $phone;

        $response = Http::withHeaders([
            'X-Authorization' => env('AUTHENTICA_API_KEY'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://api.authentica.sa/api/sdk/v1/sendOTP', [
            'phone' => $phone,
            'method' => 'sms',
            'otp_format' => 'numeric',
            'template_id' => 32,
            'number_of_digits' => 6,
        ]);
        if ($response['success'] != true) {
            Log::create([
                'message' => $response->json()
            ]);
        }
        return $response->json();
    }

    private function verifyWithAuthentica($phone, $otp)
    {
        $phone = '+966' . $phone;

        $response = Http::withHeaders([
            'X-Authorization' => env('AUTHENTICA_API_KEY'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://api.authentica.sa/api/sdk/v1/verifyOTP', [
            'phone' => $phone,
            'otp' => $otp,
        ]);

        return $response->json();
    }
}
