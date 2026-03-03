<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$subs = \App\Models\PushSubscription::with('event')->get();
foreach($subs as $sub) {
    echo "Event: " . $sub->event->title . "\n";
    echo "Date: " . $sub->event->event_date . "\n";
    echo "Time: " . $sub->event->jam . "\n";
    echo "Now Date: " . now()->toDateString() . "\n";
    echo "Now Time: " . now()->toTimeString() . "\n";
    echo "1H Time: " . now()->addHour()->toTimeString() . "\n";
}
