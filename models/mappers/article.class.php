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
		// var_dump($this->likes_count);
		if ($this->likes_count == "") {
			return '0';
		} else {
			return $this->likes_count;
		}
	}
	public function getKeyWords() {
		return $this->keywords;
	}
	public function getDate() {
		return (new DateTime ( $this->date ))->format ( 'Y-m-d' );
	}
	public function getDateTime() {
		return (new DateTime ( $this->date ))->format ( 'Y-m-d @ H:i:s' );
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
		$user = getCurrUsername();
		if ($user) {
			return strpos ( $this->getWriter (), $user ) !== false;
		} else {
			return false;
		}
	}
	public function getFormattedStatus() {
		switch ($this->getStatus ()) {
			case "submitted" :
				return "Submitted";
			
			case "awaiting_changes" :
				return "Awaiting changes";
			
			case "under_review" :
				return "Under review";
			
			case "published" :
				return "Published";
			case "rejected" :
				return "Rejected";
		}
	}
	public function visibleArticle() {
		return $this->isPublished () || ($this->isAwaitingChanges () && $this->checkIfWriter ());
	}
	public function isSubmitted() {
		return $this->getStatus () == "submitted";
	}
	public function isUnderReview() {
		return $this->getStatus () == "under_review";
	}
	public function isAwaitingChanges() {
		return $this->getStatus () == "awaiting_changes";
	}
	public function isRejected() {
		return $this->getStatus () == "rejected";
	}
	public function isPublished() {
		return $this->getStatus () == "published";
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