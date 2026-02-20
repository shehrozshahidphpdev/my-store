<?php

function view(string $file, mixed $data = [])
{
  $filePath = BASE_PATH . '/resources/views/' . $file . '.php';
  if (file_exists($filePath)) {
    extract($data);
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

function dd(mixed $data)
{
  echo "<pre>";
  print_r($data);
  die;
}


function session($key, $value)
{
  $_SESSION[$key] = $value;
}
