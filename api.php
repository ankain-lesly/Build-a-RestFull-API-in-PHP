<?php
require "./headers.inc.php";
// Exceptions and Error Handling
// use this in a namespace system
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");


// Import Class
use App\Config\Router;
// use App\Config\ErrorHandler;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\MasterController;
use App\Controllers\UserController;
use App\Config\CustomErrorValidator;


$path = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];
$path_key = $method.'@'.$path;

$ID = explode('/', $path)[4] ?? null;

$router = new Router();

$routes = array(
				// Productss //
	   "GET@/api/products/books"	=> 	[ProductController::class, 'index'],
	"DELETE@/api/products/books" 	=> 	[ProductController::class, 'delete'],	// delete_key, auth_key
	  "POST@/api/products/books"	=> 	[ProductController::class, 'update'],	// key, name, author, is_read

   "GET@/api/products/books/$ID"	=> 	[ProductController::class, 'show'],		// book id
  "GET@/api/products/search/$ID"	=> 	[ProductController::class, 'search'],	// search keyword
	
      "POST@/api/create/product"	=> 	[ProductController::class, 'create'],	// book-data

				// Category //
	   "GET@/api/category/books"	=> 	[CategoryController::class, 'index'],
	"DELETE@/api/category/books" 	=> 	[CategoryController::class, 'delete'],	// delete_key, auth_key
	  "POST@/api/category/books"	=> 	[CategoryController::class, 'update'],	// key, name, author, is_read

   "GET@/api/category/books/$ID"	=> 	[CategoryController::class, 'show'],		// book id
  "GET@/api/category/search/$ID"	=> 	[CategoryController::class, 'search'],	// search keyword
	
     "POST@/api/create/category"	=> 	[CategoryController::class, 'create'],	// name, author

				// Masters //
	           "POST@/api/admin"	=> 	[MasterController::class, 'admin'],		// auth_key, res_query

				// Users //
         "POST@/api/user/signup"	=> 	[UserController::class, 'signup'],	// signup user data
          "POST@/api/user/login"	=> 	[UserController::class, 'login'],		// login user data

);

if(!array_key_exists($path_key, $routes)) {
	// $object = new ProductController();
	// return call_user_func_array([$object, 'notFound'], []);
	return CustomErrorValidator::errorResourceMsg('not-found',[],404);
}

// Execute Router
$router->Resolve($path, $routes[$path_key], $ID);

/**
 * Catching PHP errors
 * Catching PHP Exceptions
 */