<?php
$URI = parse_url($_SERVER['REQUEST_URI'])['path'];


$path = explode('/', $URI)[1];

if($path === 'api')
	include_once './api.php';
else 
	include_once './views/index.html';

