<?php
include "init.php";

$controller = new \Fh\Controller();
$response = $controller->runByRequest($_GET['request']);

echo $response;
