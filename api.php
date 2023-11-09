<?php
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// cors off
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include "init.php";

$controller = new \Fh\Controller();
$response = $controller->runAction($_GET['request']);

echo $response;
