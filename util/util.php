<?php

function loggedIn() {
	return (! empty ( $_SESSION ['LoggedIn'] ) && ! empty ( $_SESSION ['Username'] ));
}

function isSubscriber() {
	return  loggedIn() && in_array($_SESSION ['UserType'], unserialize(SUBSCRIBERS));
}

function isWriter() {
	return  loggedIn() && in_array($_SESSION ['UserType'], unserialize(WRITERS));
}

function isEditor() {
	return loggedIn() && in_array($_SESSION ['UserType'], unserialize(EDITORS));
}

function isPublisher() {
	return loggedIn() && $_SESSION ['UserType'] == PUBLISHER;
}
