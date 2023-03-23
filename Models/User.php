<?php 
namespace App\Models;

use App\Config\Library;
use App\Models\DataAccess;

class User {
  private $DataAccess;

  public function __construct() {
    $this->DataAccess = new DataAccess();
  }

  // CREATE USER
  public function create(array $data): bool|array {
    $sql = "INSERT INTO users (username, email, phone, password, userToken) VALUES (:username, :email, :phone, :password, :userToken)";

    $passEncypt = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $token = Library::generateKey();

    $res =  $this->DataAccess->queryCustomData($sql,[
      $data['username'],
      $data['email'],
      $data['phone'],
      $passEncypt,
      $token,
    ]);

    return array(
      'username'=>$data['username'],
      'email'=>$data['email'],
      'token'=>$token.'@@'.$res,
    );
  }


  // LOG IN USER
  public function login(array $data): bool|array {
    $sql = "SELECT userID, username, email, userToken, password FROM users WHERE username = :username";

    $user =  $this->DataAccess->
      fetchCustomData($sql, [$data['username']]);

    if(!$user) return false;

    if (!password_verify($data['password'], $user['password'])) return false;

    $token = Library::generateKey();

      $sql = "UPDATE users SET userToken = :userToken WHERE userID = :userID";
      
      $res =  $this->DataAccess->queryCustomData($sql,[$token,$user['userID']]);

    return array(
      'username'=>$user['username'],
      'email'=>$user['email'],
      'token'=>$token.'@@'.$user['userID'],
      'status'=>$res,
    );
  }
}


  /*
    // CREATE USER
    public function create(array $data): array {
      $sql = "INSERT INTO users (username, email, phone, password, userToken) VALUES (:username, :email, :phone, :password, :userToken)";

      $passEncypt = password_hash($data['password'], PASSWORD_DEFAULT);
      
      $token = Library::generateKey();

      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(":username", $data['username'], PDO::PARAM_STR);
      $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);
      $stmt->bindValue(":phone", $data['phone'], PDO::PARAM_STR);
      $stmt->bindValue(":password", $passEncypt, PDO::PARAM_STR);
      $stmt->bindValue(":userToken", $token, PDO::PARAM_STR);

      $stmt->execute();
      $id = $this->conn->lastInsertId();
      $this->conn = null;
      return array(
        'username'=>$data['username'],
        'email'=>$data['email'],
        'token'=>$token.'@@'.$id,
      );
    }
  */