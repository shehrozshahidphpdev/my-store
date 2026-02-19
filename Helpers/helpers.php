<?php

function view(string $file)
{
  $filePath = BASE_PATH . '/resources/views/' . $file . '.php';
  if (file_exists($filePath)) {
    require_once $filePath;
  } else {
    die('404 File Not Found');
  }
}

function asset(string $file)
{
  $filePath = BASE_PATH . '/public/assets/' . $file;
  if (file_exists($filePath)) {
    return ASSETS_URL . $file;
  } else {
    echo "File Not Found";
  }
}

function isAuthenticated(): bool
{
  if (isset($_SESSION['user'])) {
    return true;
  } else {
    return false;
  }
}
