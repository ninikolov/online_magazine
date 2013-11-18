<?php

require_once 'models/model.php';
require_once 'mappers/article_mapper.php';
require_once 'mappers/comment_mapper.php';
require_once 'mappers/user_mapper.php';

class ArticleModel extends Model {
	

	function __construct($view){
		parent::__construct($view);
		$this->mapper = new ArticleMapper();
		$this->commentMapper = new CommentMapper();
		$this->userMapper = new UserMapper();
	}
	
	function fetchArticleById($id) {		
		$this->set ( "Article", $this->mapper->getArticle($id));
		$this->set ( "Comments", $this->commentMapper->getCommentsByArticleId($id));
		if(isSubscriber()) {			
			$this->set("CanLike", !$this->userMapper->userHasLiked($id, $_SESSION ['Username']));
			//$this->set("CanComment", true);
		} else {
			$this->set("CanLike", false);
			//$this->set("CanComment", false);
		}
	}
	
	function likeArticle($id) {
		$this->mapper ->likeArticle($id);		
	}
	
	function submitComment($comment) {
		$this->commentMapper->submitComment($comment);
	}
}