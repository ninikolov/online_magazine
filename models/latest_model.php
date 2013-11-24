<?php

require_once 'mappers/article_mapper.php';
require_once 'models/model.php';

class LatestModel extends Model {
	
	function __construct($view) {
		parent::__construct($view);
		$this->mapper = new ArticleMapper();		
	}
	
	function prepareAll() {
		$this->set ( "LatestData", $this->mapper->fetchAllLatest() );
	}
	
	function prepareColumnData($column) {
		$column_articles = $this->mapper->fetchAllColumnArticles($column);
		$this->set ( "ColumnData",  $column_articles);
		$this->set ( "Column",  $column);
	}
	
	function prepareReviewData() {
		$reviews = $this->mapper->fetchAllReviews();
		$this->set ( "ReviewsData",  $reviews);
	}
}