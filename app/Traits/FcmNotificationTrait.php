<?php

namespace App;

use Carbon\Carbon;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\NotificationApp;
use App\Models\Driver;


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

    protected static function sendFcmNotification($fcmToken, $title, $body)
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
            ],
        ]);

        return $response->json();
    }

    public function sendNotification($fcmToken, $title, $body, $driver_id = null, $image = null, $schedule = null)
    {
        try {
            $notificationData = [
                "driver_id" => $driver_id,
                "title" => $title,
                "body" => $body,
                "image" => $image,
                "schedule" => $schedule,
                "fcm_token" => $fcmToken,
            ];

            if ($schedule) {
                // If a schedule is provided, save to database without sending
                $created = NotificationApp::create($notificationData);
                return [
                    'success' => true,
                    'message' => 'Notification scheduled successfully',
                    'created' => $created
                ];
            } else {
                // If no schedule, send immediately
                $response = self::sendFcmNotification($fcmToken, $title, $body);
                $created = NotificationApp::create($notificationData);
                return [
                    'success' => true,
                    'message' => 'Notification sent successfully',
                    'response' => $response,
                    'created' => $created
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error processing notification: ' . $e->getMessage()
            ];
        }
    }

    public static function sendScheduledNotifications()
    {
        $now = Carbon::now();
        $scheduledNotifications = NotificationApp::where('schedule', '<=', $now)
            ->whereNull('sent_at')
            ->whereNull('user_id')
            ->get();

        foreach ($scheduledNotifications as $notification) {
            $driver = Driver::find($notification->driver_id);
            $response = self::sendFcmNotification(
                $driver->fcm_token,
                $notification->title,
                $notification->body
            );

            $notification->sent_at = $now;
            $notification->save();
        }
    }
}