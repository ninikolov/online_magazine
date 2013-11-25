<?php
require_once 'db_connect.php';
require_once 'article.class.php';
/**
 * Provides a mapping for creating and updating article data.
 */
class ArticleMapper extends DBConnect {
	function __construct() {
		$this->connect ();
	}
	
	// Internal
	/**
	 *
	 * @param unknown $result        	
	 * @param string $class        	
	 * @return multitype:
	 */
	private function _mapResultsToArticles($result, $class = "Article") {
		$output = [ ];
		while ( $row = $result->fetch () ) {
			array_push ( $output, new $class ( $row ) );
		}
		return $output;
	}
	
	// GET methods
	public function fetchAll($table = "global_published_articles_view", $class = "Article") {
		$result = $this->selectAllFrom ( $table );
		return $this->_mapResultsToArticles ( $result, $class );
	}
	public function fetchAllWhere($where_clause, $table = "global_articles_view", $class = "Article") {
		$result = $this->selectAllFromWhere ( $table, $where_clause );
		return $this->_mapResultsToArticles ( $result, $class );
	}
	function fetchAllSubmitted() {
		return $this->fetchAll ( "submitted_articles_view" );
	}
	function fetchPopularArticles() {
		return $this->fetchAll ( "popular_articles_view" );
	}
	function fetchFeaturedArticles() {
		return $this->fetchAll ( "recently_highlighted_articles_view" );
	}
	function fetchAllLatest() {
		return $this->fetchAll ( "global_latest_articles_view" );
	}
	function fetchLatestFiveArticles() {
		return $this->fetchAll ( "latest_articles_view" );
	}
	function fetchLatestFiveReviews() {
		return $this->fetchAll ( "latest_reviews_view" );
	}
	function fetchLatestFiveColunArticles() {
		return $this->fetchAll ( "latest_column_articles_view" );
	}
	function fetchAllColumnArticles($column) {
		$result = $this->selectAllFromWhere ( "global_column_articles_view", "column_name=:column_name", array (
				":column_name" => $column 
		) );
		return $this->_mapResultsToArticles ( $result, "Column" );
	}
	function fetchAllReviews() {
		return $this->fetchAll ( "global_reviews_view", "Review" );
	}
	public function getArticle($id) {
		$response = $this->selectById ( "global_articles_view", $id );
		try {
			$ar = $response->fetch ();
			switch ($ar ["type"]) {
				case "column_article" :
					$ar ['column_name'] = $this->getColumnOfArticle ( $id );
					return new Column ( $ar );
					break;
				
				case "review" :
					$ar ['rating'] = $this->getRatingOfArticle ( $id );
					return new Review ( $ar );
					break;
				
				default :
					return new Article ( $ar );
					break;
			}
		} catch ( Exception $e ) {
			return null;
		}
	}
	public function getUserArticles($user) {
		$result = $this->selectAllFromWhere ( "global_articles_view", "writers like :wname", array (
				":wname" => "%" . $user->getName () . "%" 
		) );
		return $this->_mapResultsToArticles ( $result );
	}
	function getColumnOfArticle($article_id) {
		$result = $this->selectAllFromWhere ( "column_article", "article_id=:article_id", array (
				":article_id" => $article_id 
		) );
		$row = $result->fetch ();
		return $row ["column_name"];
	}
	function getRatingOfArticle($article_id) {
		$result = $this->selectAllFromWhere ( "ratings", "article_id=:article_id", array (
				":article_id" => $article_id 
		) );
		$row = $result->fetch ();
		return $row ["rating"];
	}
	function getEditHistoryOf($user_id) {
		$result = $this->selectAllFromWhere ( "edits_view", "user_id=:user_id", array (
				":user_id" => $user_id 
		) );
		return $this->_mapResultsToArticles ( $result );
	}
	
	// SUBMIT or UPDATE methods
	public function submitNewArticle($data) {
		$writers = $data ["writer"];
		$keywords;
		if (! empty ( $data ["keywords"] )) {
			$keywords = $data ["keywords"];
		}
		unset ( $data ["writer"] );
		unset ( $data ["keywords"] );
		$this->_buildInsertQuery ( $data, "articles" );
		/* echo $sql; */
		/* $this->query ( $sql );  */
		$article_id = $this->lastInsertId ();
		if (! empty ( $keywords )) {
			$this->_submitContentKeywordData ( $article_id, $keywords );
		}
		$this->_submitContentWriterData ( $article_id, $writers );
		return $article_id;
	}
	function updateArticle($data, $article_id) {
		//var_dump ( $data );
		if (! empty ( $data ["keywords"] )) {
			$keywords = $data ["keywords"];
		}
		unset ( $data ["keywords"] );
		$writers = $data ["writer"];
		unset ( $data ["writer"] );
		$this->_buildUpdateQuery ( $data, "articles", array (
				"id" => $article_id 
		) );
		$this->deleteKeywords ( $article_id );
		$this->deleteWriters ( $article_id );
		if (! empty ( $keywords )) {
			$this->_submitContentKeywordData ( $article_id, $keywords );
		}
		$this->_submitContentWriterData ( $article_id, $writers );
		$this->_storeEditInformation ( $article_id, $_SESSION ["UserId"] );
		return $article_id;
	}
	private function _storeEditInformation($article_id, $editor_id) {
		$this->_buildInsertQuery ( array (
				"article_id" => $article_id,
				"user_id" => $editor_id,
				"date_edited" => date ( 'Y-m-d H:i:s' ) 
		), "article_edits", array (
				"date_edited" => ":date_edited" 
		) );
	}
	private function deleteWriters($article_id) {
		$this->deleteStatement ( "article_writers", array (
				"article_id" => $article_id 
		) );
	}
	private function deleteKeywords($article_id) {
		$this->deleteStatement ( "article_keywords", array (
				"article_id" => $article_id 
		) );
	}
	function updateColumnArticle($data, $article_id) {
		$column = $data ["column_article"];
		unset ( $data ["column_article"] );
		$article_id = $this->updateArticle ( $data, $article_id );
		$this->_buildInsertQuery ( array (
				"article_id" => $article_id,
				"column_name" => $column 
		), "column_article", array (
				"column_name" => ":column_name" 
		) );
	}
	function updateReview($data, $article_id) {
		$rating = $data ["rating"];
		unset ( $data ["rating"] );
		$article_id = $this->updateArticle ( $data, $article_id );
		$this->_buildInsertQuery ( array (
				"article_id" => $article_id,
				"rating" => $rating 
		), "ratings", array (
				"rating" => ":rating" 
		) );
	}
	public function likeArticle($id) {
		$response = $this->_buildInsertQuery ( array (
				"article_id" => $id,
				"user_id" => $_SESSION ['UserId'] 
		), "likes" );
	}
	public function unlikeArticle($id) {
		//var_dump ( $_SESSION ['UserId'] );
		$this->deleteStatement ( "likes", array (
				"article_id" => $id,
				"user_id" => $_SESSION ['UserId'] 
		) );
	}
	public function setUnderReview($article_id) {
		$this->updateArticleStatus ( $article_id, "under_review" );
	}
	public function updateArticleStatus($article_id, $status) {
		$sql = $this->_buildUpdateQuery ( array (
				"status" => $status 
		), "articles", array (
				"id" => $article_id 
		) );
	}
	function submitReview($data) {
		//var_dump ( $data );
		$rating = $data ["rating"];
		unset ( $data ["rating"] );
		$article_id = $this->submitNewArticle ( $data );
		$this->_addRating ( $article_id, $rating );
	}
	private function _addRating($article_id, $rating) {
		$sql = $this->_buildInsertQuery ( array (
				"article_id" => $article_id,
				"rating" => $rating 
		), "ratings" );
	}
	function submitColumnArticle($data) {
		// var_dump ( $data );
		$column = $data ["column_article"];
		unset ( $data ["column_article"] );
		$article_id = $this->submitNewArticle ( $data );
		$this->_addColumnData ( $article_id, $column );
	}
	function _addColumnData($article_id, $column) {
		$this->_buildInsertQuery ( array (
				"article_id" => $article_id,
				"column_name" => $column 
		), "column_article" );
	}
	private function _submitContentWriterData($article_id, $writers) {
		foreach ( $writers as $writer ) {
			$sql = $this->_buildInsertQuery ( array (
					"article_id" => $article_id,
					"writer_id" => $writer 
			), "article_writers", array (
					"writer_id" => ":writer_id" 
			) );
		}
	}
	private function _submitContentKeywordData($article_id, $keywords) {
		foreach ( $keywords as $keyword ) {
			$sql = $this->_buildInsertQuery ( array (
					"article_id" => $article_id,
					"keyword" => $keyword 
			), "article_keywords", array (
					"keyword" => ":keyword" 
			) );
		}
	}
	function setFeaturedArticle($article_id) {
		$sql = $this->_buildUpdateQuery ( array (
				"featured" => "1" 
		), "articles", array (
				"id" => $article_id 
		) );
	}
	function unsetFeaturedArticle($article_id) {
		$sql = $this->_buildUpdateQuery ( array (
				"featured" => "0" 
		), "articles", array (
				"id" => $article_id 
		) );
	}
}