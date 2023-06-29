<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\GeoApiSettings;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
// use App\Notifications\FirebaseNotification;
use GuzzleHttp\Exception\RequestException;

class PushNotificationController extends Controller
{
    //     public function sendNotification(Request $request)
    //     {
    //         $client = new Client();

    //         $user = "ghjkl";
    //         $geoapisettings = GeoApiSettings::first();

    //         $response = $client->post('https://fcm.googleapis.com/fcm/send', [
    //             'headers' => [
    //                 'Authorization' => 'key='.$geoapisettings->firebase_key,
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => [
    //                 'data' => (new FirebaseNotification())->toFirebase(null),
    //                 'to' => "$'user->firebase_token'",
    //             ],
    //         ]);


    //         return response()->json(['message' => 'Notification sent successfully']);
    //     }
    // }


    public function sendNotification($user_id, $notification, $data=[])
    {
        $client = new Client();
        $user = User::find($user_id);
        $geoapisettings = GeoApiSettings::first();

        try {
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $geoapisettings->firebase_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'notification' => $notification,
                    'data' => $data,
                    'to' => $user->fcm_token,
                ],
            ]);
            // Check the response status code
            if ($response->getStatusCode() === 200) {
                return response()->json(['message' => 'Notification sent successfully']);
            } else {
                return response()->json(['message' => 'Failed to send notification'], $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Handle request exception
            return response()->json(['message' => 'Failed to send notification: ' . $e->getMessage()], $e->getCode());
        }
    }
}
