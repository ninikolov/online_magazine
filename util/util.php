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


