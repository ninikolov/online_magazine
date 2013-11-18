<?php

require_once 'models/model.php';
require_once 'mappers/article_mapper.php';

class ArticleModel extends Model {
	

	function __construct($view){
		parent::__construct($view);
		$this->mapper = new ArticleMapper();
	}
	
	function fetchArticleById($id) {		
		$this->set ( "Article", $this->mapper->getArticle($id));
	}
}