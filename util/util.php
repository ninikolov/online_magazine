<?php
function loggedIn() {
	return (! empty ( $_SESSION ['LoggedIn'] ) && ! empty ( $_SESSION ['Username'] ));
}
function isSubscriber() {
	return loggedIn () && in_array ( $_SESSION ['UserType'], unserialize ( SUBSCRIBERS ) );
}
function isWriter() {
	return loggedIn () && in_array ( $_SESSION ['UserType'], unserialize ( WRITERS ) );
}
function isEditor() {
	return loggedIn () && in_array ( $_SESSION ['UserType'], unserialize ( EDITORS ) );
}
function isPublisher() {
	return loggedIn () && $_SESSION ['UserType'] == PUBLISHER;
}
function isValidColumn($column) {
	return in_array ( $column, unserialize ( COLUMNS ) );
}
function fixEncoding($str) {
	$junk = array (
			"’" => "'",
			"“" => "\"",
			"”" => "\"" 
	);
	foreach ( $junk as $key => $value ) {
		$str = str_replace ( $key, $value, $str );
	}
	return mb_convert_encoding ( $str, 'UTF-8', 'UTF-8' );
}
function displayMessage($ignore_request = array()) {
	if (empty ( $_SESSION ['error_messages'] ) || ! isset ( $_SESSION ['error_messages'] )) {
		return;
	} else {
		if (! empty ( $ignore_request )) {
			var_dump ( $ignore_request );
			$expl = explode ( "/", $_SERVER ['REQUEST_URI'] );
			$ind = count ( $expl ) - 2;
			var_dump($expl);
			echo $expl [$ind];
			foreach ( $ignore_request as $action ) {
				if (endsWith ( $_SERVER ['REQUEST_URI'], $action ) || $expl [$ind] == $action) {
					return;
				}
			}
		}
		foreach ( $_SESSION ['error_messages'] as $key => $value ) {
			echo '<script type="text/javascript">', 'alert_' . $key . '_message("' . $value . '");', '</script>';
		}
		$_SESSION ['error_messages'] = array ();
	}
}
function addMessage($type, $message) {
	if (! isset ( $_SESSION ['error_messages'] )) {
		$_SESSION ['error_messages'] = array ();
	}
	$_SESSION ['error_messages'] [$type] = $message;
}
function endsWith($target_str, $search) {
	return substr ( $target_str, - strlen ( $search ) ) == $search;
}
