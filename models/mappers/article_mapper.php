<?php
require_once 'db_connect.php';
function fixEncoding($str) {
	$junk = array (
			"’" => "'",
			"“" => "\"",
			"”" => "\"" 
	);
	foreach ( $junk as $key => $value ) {
		$str = str_replace ( $key, $value, $str );
	}
	return mb_convert_encoding ( $str, 'UTF-8', 'UTF-8' );
}
class Article {
	private $id;
	private $title;
	private $body;
	private $image_path;
	private $likes_count;
	private $date;
	private $status;
	private $type;
	private $writers;
	private $featured;
	public function getId() {
		return $this->id;
	}
	public function getTitle() {
		return $this->title;
	}
	public function getBody() {
		return $this->body;
	}
	public function getImage() {
		return $this->image_path;
	}
	public function getLikesCount() {
		return $this->likes_count;
	}
	public function getDate() {
		return $this->date;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getWriter() {
		return $this->writers;
	}
	function getType() {
		return $this->type;
	}
	function getFeatured() {
		return $this->featured;
	}
	public function __construct($row) {
		// var_dump($row);
		$class_vars = get_class_vars ( get_class ( $this ) );
		// var_dump($class_vars);
		foreach ( array_keys ( $class_vars ) as $value ) {
			if (array_key_exists ( $value, $row )) {
				$this->$value = fixEncoding ( $row [$value] );
			} else {
				throw new ArticleException ( "No row " . $value . " returned from query or wrong article model." );
			}
		}
	}
}
class Review extends Article {
	function Review() {
		;
	}
}
class ArticleException extends Exception {
}
class ArticleMapper extends DBConnect {
	function __construct() {
		$this->connect ();
	}
	public function fetchAll() {
		$result = $this->selectAllFrom ( "global_articles_view" );
		$output = [ ];
		while ( $row = $result->fetch () ) {
			array_push ( $output, new Article ( $row ) );
		}
		return $output;
	}
	public function updateArticle($article) {
		;
	}
	public function getArticle($id) {
		$response = $this->selectById ( "global_articles_view", $id );
		try {
			$ar = $response->fetch ();
			return new Article ( $ar );
		} catch ( ArticleException $e ) {
			return null;
		}
	}
	public function submitNewArticle($data) {
		$sql = $this->_buildInsertQuery ( $data, "articles" );
		$this->query ( $sql );
	}
	public function getUserArticles($user) {
		$result = $this->selectAllFromWhere ( "global_articles_view", "writers like '" . $user->getName () . "'" );
		$output = [ ];
		while ( $row = $result->fetch () ) {
			array_push ( $output, new Article ( $row ) );
		}
		return $output;
	}
	public function likeArticle($id) {
		$sql = "update `articles` set likes_count = likes_count + 1 where id = " . $id;
		$this->query ( $sql );
	}
	
	public function getArticleComments($id) {
		
	}
}
class ObjectMap {
	public function __construct($row) {
		// var_dump($row);
		$class_vars = get_class_vars ( get_class ( $this ) );
		// var_dump($class_vars);
		foreach ( array_keys ( $class_vars ) as $value ) {
			if (array_key_exists ( $value, $row )) {
				$this->$value = fixEncoding ( $row [$value] );
			} else {
				throw new ArticleException ( "No row " . $value . " returned from query or wrong article model." );
			}
		}
	}
}

