<?php 
namespace App\Controllers;
use App\Models\Category;
use App\Config\CustomErrorValidator;

class CategoryController {
  private $category;

  public function __construct () {
    $this->category = new Category();
  }


  // GET ALL category
  public function index($rout = 'INDEX') {
    $result = $this->category->getAll();
    
    if(empty($result)) return CustomErrorValidator::errorResourceMsg();

    $response = array(
      'message'=>'Data Loaded successfully',
      'data' => $result,
      'meta-data'=> 'posts: '.count($result).' || PAGINATION limit, offset, total, page-quatity, page-size, current-page',
      'more-info' => 'some random info here',
    );
    echo json_encode($response);
  }




  // GET a book
  public function show($rout = 'SHOW', $keyword = null) {

    if(!$keyword) {
      $msg = "Error Getting Resource data.";
      $errors = ['Provide a valide Data key set!'];
      return CustomErrorValidator::errorResourceMsg($msg, $errors);
    }
    $keyword = str_replace('%20', ' ', $keyword);
    $keyword = str_replace('_', ' ', $keyword);

    $result = $this->category->get($keyword);
    
    if(empty($result)) return CustomErrorValidator::errorResourceMsg();

    $response = array(
      'message'=>'Data Loaded successfully',
      'data' => $result,
      'meta-data'=> 'some random info here',
    );

    echo json_encode($response);
  }
  // CREATE a book
  public function create(string $rout = 'CREATE') {
    $data = $_POST;
    $newData = CustomErrorValidator::validateData($data, 'sanitize')['data'];

    $result = $this->category->create_module($newData);
    
    if(!$result) return CustomErrorValidator::errorResourceMsg('FAILED: Error creating category data...');

    $response = array(
      'success'=>'Category Created Successfully',
      'data' => 'Module Data Count: '.$result,
    );

    echo json_encode($response);
  }

  // CREATE a Category
  public function create_category(string $rout = 'CREATE') {
    $bookData = $_POST;
    $validate = CustomErrorValidator::validateData($bookData);

    if(!empty($validate['errors']))
      return CustomErrorValidator::errorResourceMsg('Error! Please verify your information..', $validate['errors']);

    $res = $this->category->createCategory($validate['data']);

    if(!$res)
      return CustomErrorValidator::errorResourceMsg('Error creating Category...');

    $response = array(
      'success'=>'Category Created Successfully',
      'data' => $res,
      'meta-data'=> [],
    );

    echo json_encode($response);
  }
  // UPDATE a book
  public function update(string $rout = 'UPDATE') {
    $bookData = $_POST;

    $errors = $this->validateNewBook($bookData, false);


    if(!empty($errors)) {
      $msg = 'Invalid Form Data!';
      return CustomErrorValidator::errorResourceMsg($msg, $errors, 422);
    }

    $result = $this->category->updateBook($bookData);
    
    if($result == 0)
      return CustomErrorValidator::errorResourceMsg('FAILED: Error updating category data...');

    $response = array(
      'message'=>'Book Updated Successfully at:'.$result,
      'data' => 'Affected Data Count: '.$result,
    );

    echo json_encode($response);
  }
  // DELETE a book
  public function delete(string $rout = 'DELETE') {
    $delete_key = $_GET['delete_key'] ?? null;    
    $auth_key = $_GET['auth_key'] ?? null;    

    if(!$delete_key || !$auth_key)
      return CustomErrorValidator::errorResourceMsg("FAILED: Please provide Valid data keys");

    $result = $this->category->deleteBook($delete_key, $auth_key);
    
    if($result == 0)
      return CustomErrorValidator::errorResourceMsg('FAILED: Error deleting category data...');
    else if($result == 401)
      return CustomErrorValidator::errorResourceMsg('FAILED: Request was not successful...', [], $result);

    $response = array(
      'message'=>'Book Data Deletet Successfully. at:'.$delete_key,
      'data' => 'Affected Data Count: '.$result,
    );

    echo json_encode($response);
  }

  // SEARCH a PRODUCT
  public function search(string $rout = 'SEARCH',string $keyword) {
    if(!$keyword)
      return CustomErrorValidator::errorResourceMsg("FAILED: Please provide a search term!");

    $result = $this->category->searchBook($keyword);
    
    if(empty($result)) return CustomErrorValidator::errorResourceMsg();

    $response = array(
      'message'=>'Data Loaded successfully',
      'data' => $result,
      'meta-data'=> 'posts: '.count($result).' || PAGINATION limit, offset, total, page-quatity, page-size, current-page',
      'more-info' => 'some random info here',
    );
    echo json_encode($response);
  }

  // Validator
  public function validateNewBook(array $data, $is_new = true): array {
    $errors = [];

    if($is_new == false && empty($data['key']))
      $errors[] = 'ERROR: Undefined Data Key Parameter';
    
    if(empty($data['title']))
      $errors[] = 'Name is required';
    
    if(empty($data['author']))
      $errors[] = 'Author is required';

    // if(empty($data['description']))
    //   $errors[] = 'Description is required';
    // if(empty($data['URL']))
    //   $errors[] = 'URL is required';
    
    if(empty($data['category']))
      $errors[] = 'Category is required';
    
    if(empty($data['user']))
      $errors[] = 'Invalid data authorisation!';
    
    
    return $errors;
  }

}
