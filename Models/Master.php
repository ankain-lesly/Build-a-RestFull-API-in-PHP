<?php
namespace App\Models;
use App\Config\Database;
use PDO;

class Master extends Database{
	private $conn = null;

	public function __construct() {
		$this->conn = (new Database())->connect();
	}


	public function AuthAdmin($key) {
		$key = strtolower($key);
		$users = ['asdf', 'aaaa', 'abcd', 'abab'];

		if(in_array($key, $users)) {
			return 1;
		}
	}

	public function executeQuery($query) {
		$stmt = $this->conn->query($query);

		if(str_contains($query, 'SELECT')) {
			$data = [];
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

			return $data;
		}

		$this->conn = null;
    	return ['status'=>'Book details UPDATED. ref: at 1'];
	}
}