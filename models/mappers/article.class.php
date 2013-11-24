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
		//var_dump($this->likes_count);
		if ($this->likes_count  == "") {
			return '0';
		} else {
			return $this->likes_count;
		}
	}
	public function getKeyWords() {
		return $this->keywords;
	}
	public function getDate() {
		return (new DateTime($this->date))->format ( 'Y-m-d' );
	}
	public function getDateTime() {
		return new DateTime($this->date);
	}
	public function getStatus() {
		return $this->status;
	}
	public function getWriter() {
		return $this->writers;
	}
	public function getType() {
		return $this->type;
	}
	public function getFeatured() {
		return $this->featured;
	}
	public function checkIfWriter() {
		return strpos($this->getWriter(), $_SESSION ['Username']) !== false;
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