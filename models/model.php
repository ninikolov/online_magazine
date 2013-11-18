<?php


class Model {

	private $_view;
	function __construct($view) {				
		$this->_view = new $view ();
	}
	
	function set($name, $value) {
		$this->_view->set ( $name, $value );
	}
	
	function __destruct() {
		$this->_view->render ();
	}
	
	function setTemplate($template) {
		$this->_view->setTemplate($template);
	}
}