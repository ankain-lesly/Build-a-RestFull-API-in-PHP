<?php
namespace App\Controllers;

use App\Models\Master;
use App\Config\CustomErrorValidator;
class MasterController {
  private $master;

  public function __construct() {
    $this->master = new Master();
  }
  // DELETE a book
  public function admin(string $rout = 'DELETE', $id) {
    $key = $_GET['auth_key'] ?? null;  

    if(!$key) {
      return CustomErrorValidator::errorResourceMsg("FAILED: Please provide a valid data key");
    }

    $auth = $this->master->AuthAdmin($key);
    
    if(!$auth) {
      return CustomErrorValidator::errorResourceMsg('Client Error: Authentication not Successful');
    }

    $query = $_POST['res_query'] ?? null;

    if(!$query) return CustomErrorValidator::errorResourceMsg('FAILED: Please provide a statement data key', [], 422);

    // Check FOR valid QUERY STRUCTURE || Delete || Drop ---
    if(str_contains($query, 'SELECT') == false && str_contains($query, 'UPDATE') == false && str_contains($query, 'ALTER') == false) {
      return CustomErrorValidator::errorResourceMsg('Request Status: Query not accepted', ['Read our documentaion for valid admin requests @www.letech-cg.com?docs=api-admin'], 401);
    }

    $result = $this->master->executeQuery($query);
    // Check if string exist || Delete || Drop ---
    if(!$result) {
      return CustomErrorValidator::errorResourceMsg('Request Status: Error Evaluating Query!', ['Check and Evaluate your query statements...'], 422);
    }

    $response = array(
      'message'=>'Query Successfully.',
      'data' => $result,
    );

    echo json_encode($response);
  }

}