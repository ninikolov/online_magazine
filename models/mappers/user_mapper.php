<?php
require_once 'db_connect.php';
require_once 'article_mapper.php';
class User {
	private $id;
	private $name;
	private $password;
	private $type;
	public function getId() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getType() {
		return $this->type;
	}
	public function __construct($row) {
		// var_dump($row);
		$class_vars = get_class_vars ( get_class ( $this ) );
		// var_dump($class_vars);
		foreach ( array_keys ( $class_vars ) as $value ) {
			if (array_key_exists ( $value, $row )) {
				$this->$value = fixEncoding ( $row [$value] );
			} else {
				throw new ArticleException ( "No row " . $value . " returned from query or wrong article model." );
			}
		}
	}
}
class UserMapper extends DBConnect {
	function __construct() {
		$this->connect ();
	}
	function validUser($username, $password) {
		$response = $this->query ( "select * from `users` where `name` = '" . $username . "' and `password` = '" . $password . "'" );
		$results = $response->fetch ();
		return ! empty ( $results );
	}
	function getUser($username, $password) {
		$response = $this->query ( "select * from `users` where `name` = '" . $username . "' and `password` = '" . $password . "'" );
		$result = $response->fetch ();
		try {
			return new User ( $result );
		} catch ( Exception $e ) {
			return false;
		}
	}
}