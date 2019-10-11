<?php

use RobinMglsk\DataMerge;
require_once('../../src/DataMergePHP/DataMerge.php');

$theData = [
    'firstname' => 'John',
    'lastname' => 'Doe',
];

$theString = 'Hello my name is {{firstname}}.';

$dm = new DataMerge($theData);
echo $dm->mergeStr($theString);