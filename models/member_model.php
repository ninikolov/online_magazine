<?php
require_once 'models/model.php';
require_once 'mappers/user_mapper.php';
require_once 'mappers/article_mapper.php';
class MemberModel extends Model {
	function __construct($view) {
		parent::__construct ( $view );
		$this->userMapper = new UserMapper ();
		$this->articleMapper = new ArticleMapper ();
		if (isWriter ()) {
			$user = $this->userMapper->getUserByName ( $_SESSION ['Username'] );
			$this->set ( "UserArticles", $this->articleMapper->getUserArticles ( $user ) );
			$this->set ( "WriterList", $this->userMapper->getAllOtherWriters () );
		}
		if (isEditor()) {
			$submitted_articles = $this->articleMapper->fetchAllSubmitted();
			$this->set("SubmittedArticles", $submitted_articles);
		}
		if (isPublisher()) {
			$non_publishers = $this->userMapper->getAllNonPublisherUsers();
			$this->set("NonPublishers", $non_publishers);
		}
	}
	function verifyAccountDetails($username, $password) {
		$user = $this->userMapper->getUserByAcc ( $username, $password );
		if ($user) {
			$this->set ( "UserExists", true );
			$this->set ( "UserType", $user->getType () );
			$_SESSION ["UserId"] = $user->getId ();
		} else {
			$this->set ( "UserExists", false );
		}
	}
	function submitArticle($data) {
		$this->articleMapper->submitNewArticle ( $data );
	}
	function submitReview($data) {
		$this->articleMapper->submitReview ( $data );
	}
	function submitColumnArticle($data) {
		$this->articleMapper->submitColumnArticle ( $data );
	}
	function updateArticle($data) {
		$article_id = $data["id"];
		unset($data["id"]);
		$this->articleMapper->updateArticle ( $data , $article_id);
	}
	function updateReview($data) {
		$article_id = $data["id"];
		unset($data["id"]);
		$this->articleMapper->updateReview ( $data , $article_id);
	}
	function updateColumnArticle($data) {
		$article_id = $data["id"];
		unset($data["id"]);
		$this->articleMapper->updateColumnArticle ( $data , $article_id);
	}
	
	function promoteUser($user, $new_type) {
		$this-> userMapper -> promoteUserType($user, $new_type) ;
	}
	
}