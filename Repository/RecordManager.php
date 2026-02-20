<?php


class RecordManager
{
  private $conn;

  private $table;

  public function __construct($conn, $table) {}
}

$db = new RecordManager($conn, 'products');
