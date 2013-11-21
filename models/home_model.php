<?php

require_once 'mappers/article_mapper.php';
require_once 'models/model.php';

class HomeModel extends Model {
	
	function __construct($view) {
		parent::__construct($view);
		$this->mapper = new ArticleMapper();
		$this->set ( "PopularArticles", $this->mapper->fetchPopularArticles() );
		$this->set ( "FeaturedArticles", $this->mapper->fetchFeaturedArticles() );
		$this->set ( "LatestArticles", $this->mapper->fetchLatestFiveArticles() );
		$this->set ( "LatestColumnArticles", $this->mapper->fetchLatestFiveColunArticles() );
		$this->set ( "LatestReviews", $this->mapper->fetchLatestFiveReviews() );
	}
}