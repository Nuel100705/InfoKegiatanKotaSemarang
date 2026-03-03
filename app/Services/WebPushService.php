<?php

namespace App\Services;

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class WebPushService
{
    protected $webPush;

    public function __construct()
    {
        $auth = [
            'VAPID' => [
                'subject' => 'mailto:admin@example.com', // can be a URL or mailto:
                'publicKey' => trim(env('VAPID_PUBLIC_KEY', '')),
                'privateKey' => trim(env('VAPID_PRIVATE_KEY', '')),
            ],
        ];

        $this->webPush = new WebPush($auth);
    }

    public function sendNotification($subscriptionModel, $payload)
    {
        $subscription = Subscription::create([
            'endpoint' => $subscriptionModel->endpoint,
            'publicKey' => $subscriptionModel->public_key,
            'authToken' => $subscriptionModel->auth_token,
        ]);

        return $this->webPush->sendOneNotification(
            $subscription,
            json_encode($payload)
        );
    }
}
