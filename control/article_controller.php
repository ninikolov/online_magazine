<?php
require_once 'control/controller.php';
require_once 'models/mappers/comment_mapper.php';
class ArticleController extends Controller {
	function view($id) {
		$id = str_replace ( "/", "", $id );
		$id = ltrim ( $id, '0' );
		$this->_model->fetchArticleById ( $id );
	}
	function like($id) {
		$id = str_replace ( "/", "", $id );
		$id = ltrim ( $id, '0' );
		$this->_model->likeArticle ( $id );
		header ( 'Location: ' . ROOT . "/article/view/" . $id );
	}
	function unlike($id) {
		$id = str_replace ( "/", "", $id );
		$id = ltrim ( $id, '0' );
		$this->_model->unlikeArticle ( $id );
		header ( 'Location: ' . ROOT . "/article/view/" . $id );
	}
	function comment($id) {
		$body = $_POST ['commentbody'];
		if(isset( $_POST ['internal']) && $_POST ['internal'] == "internal") {
			$internal = 1;
		} else {
			$internal = 0;
		}
		echo $internal;
		// echo $body;
		$data = array (
				"id" => null,
				"date" => date ( 'Y-m-d H:i:s' ),
				"user_id" => $_SESSION ['UserId'],
				"body" => $body,
				"articles_id" => $id, 
				"edit_comment"=> $internal
		);
		try {
			$comment = new Comment ( $data );
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
		// var_dump($comment->serialize());
		$this->_model->submitComment ( $comment );
		header ( 'Location: ' . ROOT . "/article/view/" . $id );
	}
	function toggle_review($article_id) {
		$this->_model->setUnderReview ( $article_id );
		header ( 'Location: ' . ROOT . "/article/view/" . $article_id );
	}
	function update_status($article_id) {
		$new_status = $_POST ["status"];
		$this->_model->updateStatus ( $article_id, $new_status );
		header ( 'Location: ' . ROOT . "/article/view/" . $article_id );
	}
	function feature($article_id) {
		$this->_model->featureArticle ( $article_id );
		header ( 'Location: ' . ROOT . "/article/view/" . $article_id );
	}
	function unfeature($article_id) {
		$this->_model->unFeatureArticle ( $article_id );
		header ( 'Location: ' . ROOT . "/article/view/" . $article_id );
	}
}