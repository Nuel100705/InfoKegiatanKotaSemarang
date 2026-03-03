<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sub = \App\Models\PushSubscription::first();
if ($sub) {
    $event = $sub->event;
    echo "Event ID: " . $event->id . " Name: " . $event->title . "\n";
    $event->jam = now()->addMinutes(15)->format('H:i:s');
    $event->event_date = now()->toDateString();
    $event->save();
    echo "Updated Event to: " . $event->event_date . " " . $event->jam . "\n";
} else {
    echo "No subscriptions found.\n";
}
