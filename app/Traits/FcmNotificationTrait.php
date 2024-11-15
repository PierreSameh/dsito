<?php

namespace App;

use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

trait FcmNotificationTrait
{
    protected static function getFcmCredentialsPath()
    {
        return Storage::path('firebase-credentials.json');
    }

    protected static function getAccessToken()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(self::getFcmCredentialsPath());
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        return $token['access_token'];
    }

    public function sendNotification($fcmToken, $title, $body)
    {
        try {
            $accessToken = self::getAccessToken();
            
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ])->post("https://fcm.googleapis.com/v1/projects/project-id/messages:send", [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ]);

            return [
                'success' => $response->successful(),
                'message' => $response->successful() ? 'Notification sent successfully' : 'Failed to send notification',
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error sending notification: ' . $e->getMessage()
            ];
        }
    }

    // Override this method in your class to set your project ID
    protected function getProjectId()
    {
        return config('services.firebase.project_id');
    }
}