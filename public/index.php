<?php

declare(strict_types=1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once '../constants.php';
require_once BASE_PATH . '/database/Database.php';
require_once BASE_PATH . '/Helpers/helpers.php';
require_once BASE_PATH . '/database/Database.php';
$conn = $conn->getConnection();
require_once BASE_PATH . '/controller/Product.php';
require_once BASE_PATH . '/controller/Auth.php';

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

switch ($uri) {
  case '/':
    if (isAuthenticated()) {
      view('dashboard');
    } else {
      header('Location: /login');
    }
    break;


  case '/register':
    if (!isAuthenticated()) {
      view('register');
    } else {
      header('Location: /dashboard');
    }
    break;

  case '/login':
    if (!isAuthenticated()) {
      view('login');
    } else {
      header('Location: /dashboard');
    }
    break;



  case '/register/store':
    $auth->register($_POST);
    break;

  default:
    die("Sorry the page you are looking is not found");
}
