<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
  private $conn = null;

  public function __construct() {
    // echo 'database init';
  }

  public function connect():PDO {

    $dns = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;

    $options = array(
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_STRINGIFY_FETCHES => false,
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
      $this->conn = new PDO($dns, DB_USERNAME, DB_PASSWORD, $options);

    }catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    return $this->conn;
  }
}