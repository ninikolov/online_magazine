<?php

require_once 'models/model.php';
require_once 'mappers/user_mapper.php';
require_once 'mappers/article_mapper.php';

class MemberModel extends Model {
	
	function __construct($view) {
		parent::__construct($view);
		$this->userMapper = new UserMapper();
		$this->articleMapper = new ArticleMapper();
	}
	
	function verifyAccountDetails($username, $password) {
		$user = $this->userMapper->getUser($username, $password);
		if ($user) {
			$this->set ( "UserExists", true );
			$this->set ( "UserType", $user->getType());
		} else {
			$this->set ( "UserExists", false );
		}
	}
	
	function submitArticle($data) {
		$this->articleMapper->submitNewArticle($data);
	}
}