<?php
require_once 'object_map.class.php';
class Comment extends ObjectMap {
	protected $id;
	protected $date;
	protected $user_id;
	protected $body;
	protected $articles_id;
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
}