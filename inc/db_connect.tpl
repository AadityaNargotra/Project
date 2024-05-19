<?php

require_once('config.tpl');
//mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
class DatabaseConnection {

	protected $host;
	protected $database;
	protected $username;
	protected $password;
	protected $connection;
	public $message;
	
	public function __construct() {
		$this->host = DBH;
		$this->database = DB;
		$this->username = DBU;
		$this->password = DBP;
		$this->create();
	}

	protected function create() {
		$this->connection = new mysqli($this->host,$this->username,$this->password,$this->database);
	}

	public function insert_query($query_string) {
		if(mysqli_query($this->connection,$query_string))
			return 1;
			return 0;
	}

	public function update_query($query_string) {
		if(mysqli_query($this->connection,$query_string))
			return 1;
			return 0;
	}

	public function read_query($query_string) {
		$result = mysqli_query($this->connection,$query_string);
		if($result) {
			if(mysqli_num_rows($result) > 0)
				return $result;
		}
			return 0;
	}

	public function delete_query($query_string) {
		if(mysqli_query($this->connection,$query_string))
			return 1;
			return 0;
	}

	public function close() {
		mysqli_close($this->connection);
	}

	public function access() {
		return $this->connection;
	}

	public function error() {
		return $this->connection->error;
	}

}
