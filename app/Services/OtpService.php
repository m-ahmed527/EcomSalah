<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class OtpService
{

    protected $client;
    protected $smsUser;
    protected $smsKey;
    protected $templateId;

    public function __construct()
    {
        $this->client = new GuzzleHttpClient();
        $this->smsUser = env('ENGAGE_LAB_USER');
        $this->smsKey = env('ENGAGE_LAB_KEY');
        $this->templateId = env('ENGAGE_LAB_TEMPLETE_ID');
    }
    public static function generateOtp($length)
    {
        return Str::random($length);
    }

    public static function generateOtpExpiry(int $time)
    {
        return now()->addMinutes($time);
    }

    protected function generateOtpMessage($otp, $time)
    {
        // $expiry = Carbon::parse($expiry)->addHour(5)->format('h:i A');
        return "Your OTP is  \"$otp\". This OTP will expire in $time minutes.";
    }

    public function sendOtp($otp, $phone = null, $email = null, $via, $expiry)
    {

        foreach ($via as $v) {
            $this->{'sendVia' . $v ?: 'phone'}($otp, $$v, $expiry);
        }
    }

    // public function sendViaphone($otp, $phone, $expiry)
    // {
    //     $sid = env('TWILIO_SID');
    //     $token = env('TWILIO_AUTH_TOKEN');
    //     $twilioNumber = env('TWILIO_PHONE_NUMBER');

    //     $client = new Client($sid, $token);

    //     $client->messages->create(
    //         $phone,
    //         [
    //             'from' => $twilioNumber,
    //             'body' => $this->generateOtpMessage($otp, $phone, $expiry),
    //         ]
    //     );
    // }

    // public function sendViaphone($otp, $phone, $expiry)
    // {
    //     $url = 'https://sms.api.engagelab.cc/v1/send';
    //     $auth = base64_encode("{$this->smsUser}:{$this->smsKey}");
    //     $headers = [
    //         'Authorization' => "Basic {$auth}",
    //         'Content-Type' => 'application/json',
    //     ];
    //     $body = [
    //         'to' => $phone,
    //         'body' => [
    //             'template_id' => $this->templateId,
    //             'vars' => $this->generateOtpMessage($otp, $expiry),
    //         ],
    //     ];

    //     try {
    //         $response = $this->client->post($url, [
    //             'headers' => $headers,
    //             'json' => $body,
    //         ]);

    //         return json_decode($response->getBody(), true);
    //     } catch (\Exception $e) {
    //         Log::error('SMS sending failed: ' . $e->getMessage());
    //         return ['error' => 'SMS sending failed.'];
    //     }
    // }

    public function sendViaemail($otp, $email, $expiry)
    {
        // dd($otp, $email, $expiry);
        Mail::to($email)->send(new OtpMail($this->generateOtpMessage($otp, $expiry)));
    }


    public static function verifyOtp(string $otp, bool $remember): array
    {
        try {
            $user = User::where('otp', $otp)->first();

            if (!$user) {
                return self::buildResponse('Invalid OTP', false);
            }
            if (Carbon::parse($user->otp_expires_at) < now()) {
                return self::buildResponse('OTP has expired', false);
            }
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
                'otp_verified_at' => now(),
            ]);
            Auth::login($user, $remember);
            return self::buildResponse('OTP Verified Successfully', true);
        } catch (Exception $e) {
            return self::buildResponse('An error occurred while verifying OTP', false);
        }
    }

    private static function buildResponse(string $message, bool $auth): array
    {
        return [
            'message' => $message,
            'success' => $auth,
        ];
    }
}
