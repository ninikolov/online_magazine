<?php
require_once 'control/controller.php';
class MemberController extends Controller {
	function login_check() {
		$username = $_POST ['username'];
		$password = $_POST ['password'];
		$this->_model->verifyAccountDetails ( $username, $password );
		$this->setTemplate ( "templates/login.php" );
	}
	function submit() {
		/* $title = $_POST ['title'];
		$body = $_POST ['body'];
		$this->_model->submitArticle ( array (
				"title" => $title,
				'body' => $body 
		) ); */
		
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Error: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Stored in: " . $_FILES["file"]["tmp_name"];
		}
		echo var_dump($_POST ['article']);
	}
	function login() {
		$this->setTemplate ( "templates/login.php" );
	}
	function logout() {
		$this->setTemplate ( "templates/logout.php" );
	}
}
