<?php

use RobinMglsk\DataMerge;
require_once('../../vendor/autoload.php');

$theData = [
    'firstname' => 'John',
    'lastname' => 'Doe',
    'address' => [
        'street' => 'Zonneveldweg',
        'number' => '1',
        'postalcode' => '3500',
        'city' => 'Hasselt',
    ],
];

$theString = 'Hello my name is {{firstname}}. I live in {{address.city}}';

$dm = new DataMerge($theData);
echo $dm->mergeStr($theString);