<?php 
namespace App\Controllers;
use App\Models\User;
use App\Config\CustomErrorValidator;
// use App\Models\DataAccess;

class UserController {
  private $user;
  // private $DataAccess;

  public function __construct () {
    $this->user = new User();
    // $this->DataAccess = new DataAccess();
  }

  // SIGNUP
  public function signup(string $rout = 'CREATE') {
    $data = $_POST;
    $validate = CustomErrorValidator::validateData($data);
    
    if(!empty($validate['errors']))
      return CustomErrorValidator::errorResourceMsg('Error! Please verify your information..', $validate['errors']);

    $res = $this->user->create($validate['data']);

    if(!$res)
      return CustomErrorValidator::errorResourceMsg('Error creating user...');

    $response = array(
      'success'=>'User Created Successfully',
      'user' => $res,
      'meta-data'=> [],
    );

    echo json_encode($response);
  }

  // LOGIN 
  public function login(string $rout = "LOGIN") {
    $data = $_POST;
    $validate = CustomErrorValidator::validateData($data);
    
    if(!empty($validate['errors'])) 
      return CustomErrorValidator::errorResourceMsg('Data validation not successful', $validate['errors']);

    $res = $this->user->login($validate['data']);
    
    if(!empty($validate['errors']))
      return CustomErrorValidator::errorResourceMsg('Error! Please verify your information..', $validate['errors']);

    if(!$res) {
      $errors = array(
        'username' => 'Invalid login credentials! try again',
        'password' => 'Invalid login credentials! try again',
      );
      return CustomErrorValidator::errorResourceMsg('Error! Please verify your information..', $errors);
    }


    $response = array(
      'success'=>'User login Successfully',
      'meta_data' => [],
      'login_data'=> $res,
    );

    echo json_encode($response);
  }
}
