<?php
require_once 'view/view.php';
require_once 'models/model.php';
class Controller {
	protected $_model;
	function __construct($view, $model) {
		$this->_model = new $model($view);		
	}
	function set($name, $value) {
		$this->_model->set ( $name, $value );
	}

	function setTemplate($template) {
		$this->_model->setTemplate($template);
	}

}