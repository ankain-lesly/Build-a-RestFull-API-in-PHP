<?php 
namespace App\Models;

use App\Config\Database;
use PDO;

class DataAccess {
  private $conn;

  public function __construct() {
    $this->conn = (new Database())->connect();
  }

  // Query the Database
  public function insertCustomData(string $query, array $params) {
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    $id = $this->conn->lastInsertId();
    // $this->conn = null;
    return $id;
  }

  // Query Data
  public function queryCustomData(string $query, array $params) {
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    return $stmt->rowCount();
  }

  // Fetch Custom Data
  public function fetchCustomData(string $query, array $params) {
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    // $this->conn = null;

    if($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return false;
  }

  // Fetch Custom Data Array
  public function fetchCustomDataArray(string $query, array $params) {
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    // $this->conn = null;
    $data = array();
    
    if($stmt->rowCount() > 0) {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
      }
      return $data;
    }

    return false;
  }
    // Fetch All Custom Data Array
  public function fetchAll(string $query) {
    $stmt = $this->conn->query($query);

    // $this->conn = null;
    $data = array();
    
    if($stmt->rowCount() > 0) {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
      }
      return $data;
    }

    return false;
  }
}