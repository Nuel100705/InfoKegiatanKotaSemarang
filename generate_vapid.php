<?php
require __DIR__ . '/vendor/autoload.php';

$keys = Minishlink\WebPush\VAPID::createVapidKeys();
file_put_contents('.env', "\n\nVAPID_PUBLIC_KEY={$keys['publicKey']}\nVAPID_PRIVATE_KEY={$keys['privateKey']}\n", FILE_APPEND);
echo 'VAPID keys generated and appended to .env';
