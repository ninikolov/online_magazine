<?php
require_once 'db_connect.php';
require_once 'article_mapper.php';
class Comment {
	private $id;
	private $date;
	private $user_id;
	private $body;
	private $articles_id;
	public function getId() {
		return $this->id;
	}
	public function getDate() {
		return $this->date;
	}
	public function getUserId() {
		return $this->user_id;
	}
	public function getBody() {
		return $this->body;
	}
	public function getArticleId() {
		return $this->articles_id;
	}
	public function __construct($row) {
		//var_dump ( $row );
		$class_vars = get_class_vars ( get_class ( $this ) );
		//var_dump ( $class_vars );
		foreach ( array_keys ( $class_vars ) as $value ) {
			if (array_key_exists ( $value, $row )) {
				$this->$value = fixEncoding ( $row [$value] );
			} else {
				throw new Exception ( "No row " . $value . " returned from query or wrong article model." );
			}
		}
	}
	public function serialize() {
		$output = array ();
		$class_vars = get_class_vars ( get_class ( $this ) );
		foreach ( array_keys ( $class_vars ) as $name ) {
			if($this->$name != null) {
				$output [$name] = $this->$name;
			}
		}
		return $output;
	}
}
class CommentMapper extends DBConnect {
	function __construct() {
		$this->connect ();
	}
	public function getCommentsByArticleId($id) {
		$response = $this->selectById ( "comments", $id, "articles_id" );
		$output = [ ];
		while ( $row = $response->fetch () ) {
			try {
				array_push ( $output, new Comment ( $row ) );
			} catch ( Exception $e ) {
				echo $e->getMessage ();
			}
		}
		// var_dump($output);
		return $output;
	}
	public function submitComment($comment) {
		$sql = $this->_buildInsertQuery ( $comment->serialize(), "comments" );
		//echo $sql;
		$this->query ( $sql );
	}
}