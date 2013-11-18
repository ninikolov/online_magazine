<?php

require_once 'control/controller.php';
class ArticleController extends Controller {
	
	function view($id) {
		$id = str_replace("/", "", $id);
		$id = ltrim($id, '0');
		$this->_model->fetchArticleById($id);
	}	
	
}