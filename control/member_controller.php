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
		$data = $_POST ['article'];
		if (array_key_exists ( "writer", $data )) {
			array_push ( $data ["writer"], $_SESSION ['UserId'] );
		} else {
			$data ["writer"] = array (
					$_SESSION ['UserId'] 
			);
		}
		$this->_articleDataRequest ( $data, "submit" );
		header ( 'Location: ' . $_SERVER ['HTTP_REFERER'] );
	}
	function edit($article_id) {
		$data = $_POST ['article'];
		$data ["id"] = $article_id;
		$this->_articleDataRequest ( $data, "update" );
		header ( 'Location: ' . $_SERVER ['HTTP_REFERER'] );
	}
	private function _articleDataRequest($data, $type) {
		$image_path = $this->_uploadImage ();
		if ($image_path) {
			$data ["image_path"] = $image_path;
		}
		if ($type == "update") {
			if (array_key_exists ( "date", $data )) {
				unset ( $data ["date"] );
			}
		} else {
			$data ["date"] = date ( 'Y-m-d H:i:s' );
			$data ["body"] = nl2br ( htmlentities ( $data ["body"], ENT_QUOTES, 'UTF-8' ) );
		}
		// var_dump ( $data );
		switch ($data ["type"]) {
			case "article" :
				// echo "article";
				unset ( $data ["rating"] );
				unset ( $data ["column_article"] );
				$action = $type . "Article";
				$this->_model->$action ( $data );
				break;
			case "column_article" :
				// echo "column_article";
				unset ( $data ["rating"] );
				$action = $type . "ColumnArticle";
				$this->_model->$action ( $data );
				break;
			case "review" :
				// echo "review";
				unset ( $data ["column_article"] );
				$action = $type . "Review";
				$this->_model->$action ( $data );
				break;
		}
	}
	function promote_user() {
		if (! isPublisher ()) {
			header ( 'Location: ' . ROOT );
		}
		$user_id = $_POST ["user"];
		$new_type = $_POST ["newtype"];
		$this->_model->promoteUser ( $user_id, $new_type );
		/* header('Location: ' . $_SERVER['HTTP_REFERER']); */
	}
	function login() {
		$this->setTemplate ( "templates/login.php" );
	}
	function logout() {
		$this->setTemplate ( "templates/logout.php" );
	}
	private function _uploadImage() {
		$abs_path = "";
		if ($_FILES ["file"] ["error"] > 0) {
			return null;
		} else {
			$abs_path = $abs_path . getcwd () . "\\article_img\\" . $_FILES ["file"] ["name"];
			if (file_exists ( $abs_path )) {
				// echo $_FILES ["file"] ["name"] . " already exists. ";
			} else {
				move_uploaded_file ( $_FILES ["file"] ["tmp_name"], $abs_path );
			}
		}
		$rel_path = "/article_img/" . $_FILES ["file"] ["name"];
		return $rel_path;
	}
}
