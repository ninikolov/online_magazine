<?php
require_once 'db_connect.php';
require_once 'user.class.php';
class UserMapper extends DBConnect {
	function __construct() {
		$this->connect ();
	}
	function validUser($username, $password) {
		$response = $this->selectAllFromWhere ( "users", "`name`=:name and `password`=:password", array (
				":name" => $username,
				":password" => $password 
		) );
		$results = $response->fetch ();
		return ! $this->responseIsEmpty ( $results );
	}
	function createNewUser($username, $password) {
		$outcome = $this->_buildInsertQuery ( array (
				"name" => $username,
				"password" => $password 
		), "users" );
		if (! $outcome) {
			throw new UserMapperException ();
		}
	}
	function getUserByAcc($username, $password) {
		$response = $this->selectAllFromWhere ( "users", "`name`=:name and `password`=:password", array (
				":name" => $username,
				":password" => $password 
		) );
		$result = $response->fetch ();
		try {
			return new User ( $result );
		} catch ( Exception $e ) {
			return false;
		}
	}
	function validUserCredentials($username, $password) {
		$response = $this->selectAllFromWhere ( "users", "`name`=:name and `password`=:password", array (
				":name" => $username,
				":password" => $password 
		) );
		//$result = $response->fetch ();
		return ! $this->responseIsEmpty ( $response );
	}
	function getUserByName($username) {
		$response = $this->selectAllFromWhere ( "users", "`name`=:name", array (
				":name" => $username 
		) );
		$result = $response->fetch ();
		try {
			return new User ( $result );
		} catch ( Exception $e ) {
			return false;
		}
	}
	function usernameTaken($username) {
		$response = $this->selectAllFromWhere ( "users", "`name`=:name", array (
				":name" => $username 
		) );
		//$result = $response->fetch ();
		return ! $this->responseIsEmpty ( $response );
	}
	function getUserById($id) {
		$response = $this->selectAllFromWhere ( "users", "`id`=:id", array (
				":id" => $id 
		) );
		$result = $response->fetch ();
		try {
			return new User ( $result );
		} catch ( Exception $e ) {
			return false;
		}
	}
	function userHasLiked($article_id, $user_id) {
		$response = $this->selectAllFromWhere ( "likes", "`article_id`=:article_id and `user_id`=:user_id", array (
				":article_id" => $article_id,
				":user_id" => $user_id 
		) );
		return ! $this->responseIsEmpty ( $response );
	}
	function getAllWriters() {
		$result = $this->selectAllFrom ( "writers_list_view" );
		$output = [ ];
		while ( $row = $result->fetch () ) {
			array_push ( $output, new User ( $row ) );
		}
		return $output;
	}
	function getAllOtherWriters() {
		$writers = $this->getAllWriters ();
		foreach ( $writers as $key => $writer ) {
			if ($writer->getName () == $_SESSION ['Username']) {
				unset ( $writers [$key] );
				return $writers;
			}
		}
		return $writers;
	}
	function getAllNonPublisherUsers() {
		$result = $this->selectAllFrom ( "non_publisher_users_view" );
		$output = [ ];
		while ( $row = $result->fetch () ) {
			array_push ( $output, new User ( $row ) );
		}
		return $output;
	}
	function promoteUserType($user_id, $new_type) {
		$sql = $this->_buildUpdateQuery ( array (
				"type" => $new_type 
		), "users", array (
				"id" => $user_id 
		) );
	}
	function getAuthorsOfComments($Comments) {
		$Users = array ();
		foreach ( $Comments as $key => $value ) {
			$Users [$key] = $this->getUserById ( $value->getUserId () );
		}
		return $Users;
	}
}
class UserMapperException extends Exception {
}