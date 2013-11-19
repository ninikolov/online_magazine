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
		$abs_path = "";
		if ($_FILES ["file"] ["error"] > 0) {
			echo "Error: " . $_FILES ["file"] ["error"] . "<br>";
		} else {
			$abs_path = $abs_path . getcwd () . "\\article_img\\" . $_FILES ["file"] ["name"];
			if (file_exists ( $abs_path )) {
				echo $_FILES ["file"] ["name"] . " already exists. ";
			} else {
				move_uploaded_file ( $_FILES ["file"] ["tmp_name"], $abs_path );
			}
		}
		$rel_path = ROOT . "/article_img/" . $_FILES ["file"] ["name"];
		
		$data = $_POST ['article'];
		if (array_key_exists ( "writer", $data )) {
			array_push ( $data ["writer"], $_SESSION ['UserId'] );
		} else {
			$data ["writer"] = array (
					$_SESSION ['UserId'] 
			);
		}
		
		$data ["image_path"] = $rel_path;
		var_dump ( $data );
		if ($data ["type"] == "review") {
			unset ( $data ["column_article"] );
			$this->_model->submitReview ( $data );
		} elseif ($data ["type"] == "column_article") {
			unset ( $data ["rating"] );
			$this->_model->submitColumnArticle ( $data );
		} else {
			unset ( $data ["rating"] );
			unset ( $data ["column_article"] );
			$this->_model->submitArticle ( $data );
		}
	}
	function login() {
		$this->setTemplate ( "templates/login.php" );
	}
	function logout() {
		$this->setTemplate ( "templates/logout.php" );
	}
}
