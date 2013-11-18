<?php

require_once 'mappers/article_mapper.php';
require_once 'models/model.php';

class HomeModel extends Model {
	
	function __construct($view) {
		parent::__construct($view);
		$this->mapper = new ArticleMapper();
		$this->set ( "Map", $this->getArticles() );
	}
	
	function getArticles() {
		return $this->mapper->fetchAll();
	}
}