<?php

require('vendor/autoload.php');

$api = new \InvisionApi\Api(\getenv('IPA_URL'), \getenv('IPA_TOKEN'), (bool)\getenv('IPS_OAUTH', true));
eval(\Psy\sh());