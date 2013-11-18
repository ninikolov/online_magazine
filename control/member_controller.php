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
		echo var_dump($_POST ['article']);
	}
	function login() {
		$this->setTemplate ( "templates/login.php" );
	}
	function logout() {
		$this->setTemplate ( "templates/logout.php" );
	}
}
