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
require_once BASE_PATH . '/controller/User.php';

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

switch ($uri) {
  case '/':
    if (User::check()) {
      view('dashboard');
    } else {
      header('Location: /login');
    }
    break;


  case '/register':
    if (!User::check()) {
      view('register');
    } else {
      header('Location: /');
    }
    break;

  case '/register/store':
    if (!User::check()) {
      $user->register($_POST);
    }
    break;

  case '/login':
    if (!User::check()) {
      view('login');
    } else {
      header('Location: /');
    }
    break;

  case '/login/attempt':
    if (!User::check()) {
      $user->login($_POST);
    } else {
      header('Location: /');
    }
    break;

  case '/logout':
    if (User::check()) {
      $user->logout();
    } else {
      header('Location: /');
    }
    break;

  case '/products':
    if (User::check()) {
      $product->index();
    } else {
      header('Location: /');
    }
    break;

  case '/products/create':
    if (User::check()) {
      view('create');
    } else {
      header('Location: /login');
    }
    break;

  case '/products/store':
    if (User::check()) {
      $product->store($_POST, $_FILES);
    } else {
      header('Location: /login');
    }
    break;

  case '/product/delete':
    $product->destroy($_GET['id']);
    break;

  case '/product/edit':
    $product->edit($_GET['id']);
    break;


  case '/product/update':
    $product->update();
    break;

  default:
    die("Sorry the page you are looking is not found");
}
