<?php

require_once 'controller.php';

class HomeController extends Controller {
	
	function __construct($view, $model) {
		parent::__construct($view, $model);				
		$this->set ( "test_action", "orignal" );
	}
	
	function test() {
		$this->set ( "test_action", "updated");
	}
}