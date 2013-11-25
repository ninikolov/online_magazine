<?php
require_once 'object_map.class.php';
class Comment extends ObjectMap {
	protected $id;
	protected $date;
	protected $user_id;
	protected $body;
	protected $articles_id;
	protected $edit_comment;
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
	public function getEditComment() {
		return $this->edit_comment;
	}
	public function isEditComment() {
		if ($this->getEditComment () == 1) {
			return true;
		} else {
			return false;
		}
	}
}