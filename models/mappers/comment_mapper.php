<?php
require_once 'db_connect.php';
require_once 'comment.class.php';

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
		$this->query ( $sql );
	}
}