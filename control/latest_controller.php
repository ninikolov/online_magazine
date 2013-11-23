<?php
require_once 'control/controller.php';
class LatestController extends Controller {
	function all() {
		$this->_model->prepareAll();
	}
	function column($column) {
		if (! isValidColumn ( $column )) {
			header ( 'Location: ' . ROOT . "/control/pagenotfound.php" );
		}
		$this->_model->prepareColumnData ( $column );
		$this->setTemplate ( "templates/column.php" );
	}
	
	function reviews() {
		$this->_model->prepareReviewData ( );
		$this->setTemplate ( "templates/reviews.php" );
	}
}