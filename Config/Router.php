<?php 
namespace App\Config;

class Router {

	public function resolve(string $path, array $controls, $id) {
		$classReff = array_shift($controls);
		
		$object = new $classReff;
		$method = array_shift($controls);

		// echo json_encode($this->Controls);
		call_user_func_array([$object, $method], [$path, $id]);

	}
	

}