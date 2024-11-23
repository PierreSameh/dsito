<?php

namespace App\Traits;

use App\Models\AppNotification;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


trait FcmNotificationTrait
{
    protected static function getFcmProjectId()
    {
        return "toola-driver-e7c9a";
    }

    protected static function getFcmCredentialsPath()
    {
        return Storage::path('toola-driver-e7c9a-firebase-adminsdk-2fu1o-4d4c072b1e.json');
    }

    protected static function getGoogleClient()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(self::getFcmCredentialsPath());
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        return $client;
    }

    protected static function getAccessToken()
    {
        $client = self::getGoogleClient();
        $token = $client->getAccessToken();
        return $token['access_token'];
    }

    protected static function sendFcmNotification($fcmToken, $title, $body, $url = null, $method = null)
    {
        $projectId = self::getFcmProjectId();
        $accessToken = self::getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ])->post("https://fcm.googleapis.com/v1/projects/toola-driver-e7c9a/messages:send", [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => [
                    'url' => $url ?? null,
                    'method' => $method ?? null
                ]
            ],
        ]);

        return $response->json();
    }

    public function sendNotification($fcmToken, $title, $body, $url = null, $method = null, $customer_id = null)
    {
        try {
            $response = self::sendFcmNotification($fcmToken, $title, $body, $url ?? null, $method ?? null);
            //Save Notification to database
            if($customer_id){
            AppNotification::create([
                'customer_id' => $customer_id,
                "title" => $title,
                "body" => $body
            ]);
            }
            return [
                'success' => true,
                'message' => 'Notification sent successfully',
                'response' => $response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error processing notification: ' . $e->getMessage()
            ];
        }
    }

}