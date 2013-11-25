<?php
require_once 'models/model.php';
require_once 'mappers/article_mapper.php';
require_once 'mappers/comment_mapper.php';
require_once 'mappers/user_mapper.php';
class ArticleModel extends Model {
	function __construct($view) {
		parent::__construct ( $view );
		$this->mapper = new ArticleMapper ();
		$this->commentMapper = new CommentMapper ();
		$this->userMapper = new UserMapper ();
	}
	function fetchArticleById($article_id) {
		$article = $this->mapper->getArticle ( $article_id );
		$this->set ( "Article", $article );
		$Comments = $this->commentMapper->getCommentsByArticleId ( $article_id );
		if (! empty ( $Comments )) {
			$this->set ( "Users", $this->userMapper->getAuthorsOfComments ( $Comments ) );
		}
		$this->set ( "Comments", $Comments );
		if (isSubscriber ()) {
			$this->set ( "CanLike", ! $this->userMapper->userHasLiked ( $article_id, $_SESSION ['UserId'] ) );
		} else {
			$this->set ( "CanLike", false );
		}
		if (isWriter ()) {
			$this->set ( "WriterList", $this->userMapper->getAllOtherWriters () );
		}
	}
	function likeArticle($id) {
		try {
			$this->mapper->likeArticle ( $id );
			addMessage ( "success", "Liked article." );
		} catch ( DBException $e ) {
		}
	}
	function unlikeArticle($id) {
		try {
			$this->mapper->unlikeArticle ( $id );
			addMessage ( "success", "Unliked article." );
		} catch ( DBException $e ) {
		}
	}
	function submitComment($comment) {
		try {
			$this->commentMapper->submitComment ( $comment );
			addMessage ( "success", "Successfully submitted comment." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Could not submit comment. " );
		}
	}
	function setUnderReview($article_id) {
		$this->mapper->setUnderReview ( $article_id );
	}
	function updateStatus($article_id, $status) {
		try {
			$this->mapper->updateArticleStatus ( $article_id, $status );
			addMessage ( "success", "Article is now " . $status . "." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Could not submit comment. " );
		}
	}
	function featureArticle($article_id) {
		try {
			$this->mapper->setFeaturedArticle ( $article_id );
			addMessage ( "success", "Article is now featured on the homepage." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Could not feature article. " );
		}
	}
	function unFeatureArticle($article_id) {
		try {
			$this->mapper->unsetFeaturedArticle ( $article_id );
			addMessage ( "success", "Article is now removed from featured." );
		} catch ( DBException $e ) {
			addMessage ( "error", "Could not unfeature article. " );
		}
	}
}