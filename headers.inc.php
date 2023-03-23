<?php 
declare(strict_types=1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");



require(__DIR__."/Config/config.php");

require(__DIR__."/Config/Router.php");
require(__DIR__."/Config/CustomLibrary.php");
require(__DIR__."/Config/Database.php");
require(__DIR__."/Config/ErrorHandler.php");
require(__DIR__."/Config/CustomErrorValidator.php");

require(__DIR__."/Controllers/ProductController.php");
require(__DIR__."/Controllers/CategoryController.php");
require(__DIR__."/Controllers/UserController.php");
require(__DIR__."/Controllers/MasterController.php");

require(__DIR__."/Models/Product.php");
require(__DIR__."/Models/Category.php");
require(__DIR__."/Models/User.php");
require(__DIR__."/Models/Master.php");
require(__DIR__."/Models/DataAccess.php");


// require(__DIR__."/../vendor/autoload.php");

