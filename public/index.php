<?php

declare(strict_types=1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once '../constants.php';
require_once BASE_PATH . '/Helpers/helpers.php';
die;



$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);


switch ($uri) {
  case '/';
}
