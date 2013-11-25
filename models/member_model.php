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
		if (isEditor ()) {
			$submitted_articles = $this->articleMapper->fetchAllSubmitted ();
			$this->set ( "SubmittedArticles", $submitted_articles );
			$this->set ( "EditHistory", $this->articleMapper->getEditHistoryOf ( $_SESSION ["UserId"] ) );
			$this->set ( "FeaturedArticles", $this->articleMapper->fetchFeaturedArticles () );
		}
		if (isPublisher ()) {
			$non_publishers = $this->userMapper->getAllNonPublisherUsers ();
			$this->set ( "NonPublishers", $non_publishers );
		}
	}
	function verifyAccountDetails($username, $password) {
		try {
			if ($this->userMapper->validUserCredentials ( $username, $password )) {
				$user = $this->userMapper->getUserByAcc ( $username, $password );
				$this->set ( "UserExists", true );
				$this->set ( "UserType", $user->getType () );
				$_SESSION ["UserId"] = $user->getId ();				
				addMessage ( "success", "You are now logged in." );
			} else {
				$this->set ( "UserExists", false );
			}
		} catch ( DBException $e ) {
			addMessage ( "error", "Error logging in." );
		}
	}
	function registerNewUser($username, $password) {
		try {
			if (! $this->userMapper->usernameTaken ( $username )) {
				$this->userMapper->createNewUser ( $username, $password );
				$this->set ( "CreatedUser", true );
				$this->set ( "username", $username );
			} else {
				$this->set ( "CreatedUser", false );
			}
			addMessage ( "success", "Successfully created user." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Cannot create user." );
		}
	}
	function submitArticle($data) {
		try {
			$this->articleMapper->submitNewArticle ( $data );
			addMessage ( "success", "Successfully added article" . $data ["title"] . "!" );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to add " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function submitReview($data) {
		try {
			$this->articleMapper->submitReview ( $data );
			addMessage ( "success", "Successfully added review " . $data ["title"] . "!" );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to add " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function submitColumnArticle($data) {
		try {
			$this->articleMapper->submitColumnArticle ( $data );
			addMessage ( "success", "Successfully added column article " . $data ["title"] . "!" );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to add " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function updateArticle($data) {
		$article_id = $data ["id"];
		unset ( $data ["id"] );
		try {
			$this->articleMapper->updateArticle ( $data, $article_id );
			addMessage ( "success", "Successfully updated article" . $data ["title"] . "!" );
		} catch ( ArticleMapperException $e ) {
			addMessage ( "error", "Error! Failed to update " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function updateReview($data) {
		$article_id = $data ["id"];
		unset ( $data ["id"] );
		try {
			$this->articleMapper->updateReview ( $data, $article_id );
			addMessage ( "success", "Successfully updated review" . $data ["title"] . "!" );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to update review " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function updateColumnArticle($data) {
		$article_id = $data ["id"];
		unset ( $data ["id"] );
		try {
			$this->articleMapper->updateColumnArticle ( $data, $article_id );
			addMessage ( "success", "Successfully updated column article " . $data ["title"] . "!" );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to update column article " . $data ["title"] . "! Contact the site owner." );
		}
	}
	function promoteUser($user, $new_type) {
		try {
			$this->userMapper->promoteUserType ( $user, $new_type );
			addMessage ( "success", "Successfully promoted user" . $user . " to " . $new_type . "." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Error! Failed to promote user." );
		}
	}
}