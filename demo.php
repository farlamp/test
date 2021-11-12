<?php
include_once 'Lib/Tool.php';

$data = (new Tool())->index('Barcelona', 'Geron Airport', 2);

var_dump($data);
