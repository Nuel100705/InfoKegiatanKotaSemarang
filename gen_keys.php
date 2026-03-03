<?php
require __DIR__ . '/vendor/autoload.php';
putenv('OPENSSL_CONF=' . __DIR__ . '/openssl.cnf');
$keys = \Minishlink\WebPush\VAPID::createVapidKeys();
echo "VAPID_PUBLIC_KEY={$keys['publicKey']}\n";
echo "VAPID_PRIVATE_KEY={$keys['privateKey']}\n";
