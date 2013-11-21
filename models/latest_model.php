<?php

require_once 'mappers/article_mapper.php';
require_once 'models/model.php';

class LatestModel extends Model {
	
	function __construct($view) {
		parent::__construct($view);
		$this->mapper = new ArticleMapper();
		$this->set ( "Map", $this->mapper->fetchAll() );
	}
}