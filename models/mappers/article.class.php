<?php

require_once 'util/util.php';
require_once 'object_map.class.php';

/**
 * Class representation of an Article. 
 */
class Article extends ObjectMap {
	protected $id;
	protected $title;
	protected $body;
	protected $image_path;
	protected $likes_count;
	protected $keywords;
	protected $date;
	protected $status;
	protected $type;
	protected $writers;
	protected $featured;
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
	public function getKeyWords() {
		return $this->keywords;
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
}
/**
 * Column
 */
class Column extends Article {
	protected $column_name;
	function getColumnName() {
		return $this->column_name;
	}
}
/**
 * Review
 */
class Review extends Article {
	protected $rating;
	function getRating() {
		return $this->rating;
	}
}