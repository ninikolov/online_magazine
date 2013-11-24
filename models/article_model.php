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
		if (isEditor ()) {
			$this->set ( "WriterList", $this->userMapper->getAllOtherWriters () );
		}
	}
	function likeArticle($id) {
		$this->mapper->likeArticle ( $id );
	}
	function submitComment($comment) {
		$this->commentMapper->submitComment ( $comment );
	}
	function setUnderReview($article_id) {
		$this->mapper->setUnderReview ( $article_id );
	}
	function updateStatus($article_id, $status) {
		$this->mapper->updateArticleStatus ( $article_id, $status );
	}
	function featureArticle($article_id) {
		$this->mapper->setFeaturedArticle($article_id);
	}
	function unFeatureArticle($article_id) {
		$this->mapper->unsetFeaturedArticle($article_id);
	}
}