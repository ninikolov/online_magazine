<?php
class View {
	protected $_variables = array ();
	protected $_template;
	
	public function set($name, $value) {
		$this->_variables [$name] = $value;
	}
	public function render() {
		extract ( $this->_variables );
		include 'templates/header.php';
		include ($this->template);
		include 'templates/footer.php';
	}
	
	function setTemplate($template) {
		$this->template = $template;
	}
}