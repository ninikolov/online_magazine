<?php

/**
 * The DBConnect class provides access to the database, as well as providing
 * some useful function for building and executing queries. 
 */
class DBConnect {
	// The PDO Object
	protected $_database;
	/**
	 * Initialize the connection to the database.
	 */
	function connect() {
		try {
			$this->_database = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$this->_database->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	}
	/**
	 * Disconnect
	 */
	function disconnect() {
		$this->_database = null;
	}
	/**
	 * Send a query to the database through the PDO object
	 *
	 * @param unknown $sql
	 *        	the sql string
	 * @param unknown $input_parameters
	 *        	parameters to be bound to the statement
	 * @return boolean PDOStatement executed statement if success, false otherwise.
	 */
	function query($sql, $input_parameters = array()) {
		try {
			$stmt = $this->_database->prepare ( $sql );
			// var_dump($input_parameters);
			if (! empty ( $input_parameters )) {
				if (! $stmt->execute ( $input_parameters )) {
					return false;
				}
				// echo $stmt->queryString;
			} else {
				if (! $stmt->execute ()) {
					return false;
				}
			}
			return $stmt;
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	}
	/**
	 * Select statement on all elements from a table.
	 *
	 *
	 * @param unknown $table
	 *        	the target table
	 * @return Ambigous <boolean, PDOStatement> the result from the query
	 */
	function selectAllFrom($table) {
		return $this->query ( "select * from " . $table );
	}
	/**
	 * Select statement on all elements with where clause.
	 *
	 *
	 * @param unknown $table
	 *        	the target table.
	 * @param unknown $where_clause
	 *        	the where clause
	 * @param unknown $input_parameters
	 *        	binding parameters to be sent to query
	 * @return Ambigous <boolean, PDOStatement> the result from query
	 */
	function selectAllFromWhere($table, $where_clause, $input_parameters = array()) {
		$sql = "select * from `" . $table . "` where " . $where_clause;
		return $this->query ( $sql, $input_parameters );
	}
	/**
	 * Select statement on all elements with an id constraint.
	 *
	 *
	 * @param unknown $table
	 *        	the target table
	 * @param unknown $id
	 *        	the id to be matched
	 * @param string $id_column
	 *        	the column which stores the id in the table
	 * @return Ambigous <boolean, PDOStatement> the result from query
	 */
	function selectById($table, $id, $id_column = "id") {
		return $this->query ( "select * from `" . $table . "` where `" . $id_column . "` = :id", array (
				":id" => $id 
		) );
	}
	/**
	 * Builds, prepares and sends an insert query.
	 *
	 *
	 * @param unknown $array
	 *        	array of column valued pairs to be used in the building of the query
	 * @param unknown $table
	 *        	the target table
	 * @param unknown $on_duplicate
	 *        	array of column valued pairs to be used when building the ON UPDATE clause
	 * @return Ambigous <boolean, PDOStatement>
	 */
	function _buildInsertQuery($array, $table, $on_duplicate = array()) {
		$sql = "insert into " . $table . " (";
		$sql_keys = array ();
		foreach ( array_keys ( $array ) as $column ) {
			$sql = $sql . " " . $column . ",";
			array_push ( $sql_keys, ":" . $column );
		}
		$sql = rtrim ( $sql, "," ) . ") values (";
		foreach ( array_keys ( $array ) as $column ) {
			$sql = $sql . ":" . $column . ",";
		}
		$input_params = array_combine ( array_values ( $sql_keys ), array_values ( $array ) );
		$sql = rtrim ( $sql, "," ) . ")";
		if (! empty ( $on_duplicate )) {
			$sql = $sql . " ON DUPLICATE KEY UPDATE ";
			foreach ( $on_duplicate as $key => $value ) {
				$sql = $sql . $key . "=" . $value;
			}
		}
		// echo $sql;
		// var_dump ( $input_params );
		return $this->query ( $sql, $input_params );
	}
	/**
	 * Build, prepare and execute an update query.
	 *
	 *
	 * @param unknown $array
	 *        	array of column valued pairs to be used in the building of the query
	 * @param unknown $table
	 *        	the target table
	 * @param unknown $where
	 *        	array of column valued pairs used in building the where clause of the update query
	 * @return Ambigous <boolean, PDOStatement>
	 */
	function _buildUpdateQuery($array, $table, $where) {
		$sql = "update " . $table . " set ";
		$params = array ();
		foreach ( $array as $column => $value ) {
			$sql = $sql . $column . "=:" . $column . ",";
			$params [":" . $column] = $value;
		}
		$sql = rtrim ( $sql, "," ) . " where ";
		foreach ( $where as $column => $value ) {
			$sql = $sql . $column . "=:" . $column . ",";
			$params [":" . $column] = $value;
		}
		$sql = rtrim ( $sql, "," ) . ";";
		echo $sql;
		return $this->query ( $sql, $params );
	}
	/**
	 * Build, prepare and execute a delete query.
	 *
	 *
	 * @param unknown $table
	 *        	the target table
	 * @param unknown $where_arr
	 *        	array of column valued pairs used in building the where clause of the delete query
	 * @return Ambigous <boolean, PDOStatement>
	 */
	function deleteStatement($table, $where_arr) {
		$sql = "delete from `" . $table . "` where ";
		$input_params = array ();
		foreach ( array_keys ( $where_arr ) as $key ) {
			$sql = $sql . "`" . $key . "`=:" . $key;
			array_push ( $input_params, ":" . $key );
		}
		return $this->query ( $sql, array_combine ( array_values ( $input_params ), array_values ( $where_arr ) ) );
	}
	/**
	 * Gets the id created from the last insert statement.
	 *
	 * @return string the id
	 */
	function lastInsertId() {
		return $this->_database->lastInsertId ();
	}
	/**
	 * Checks if a response was empty.
	 *
	 *
	 * @param unknown $response
	 *        	a PDO prepared statement
	 * @return boolean true if there are no rows in response from server
	 */
	function responseIsEmpty($response) {
		if ($response->rowCount () > 0) {
			return false;
		}
		return true;
	}
}