<?php
/**
 * 
 * @author 
 *
 */
class DBConnect {
	protected $_database;
	function connect() {
		try {
			$this->_database = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$this->_database->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	}
	function disconnect() {
		$this->_database = null;
	}
	function query($sql, $input_parameters = array()) {
		try {
			$stmt = $this->_database->prepare ( $sql );
			//var_dump($input_parameters);
			if (! empty ( $input_parameters )) {
				$stmt->execute ( $input_parameters );
				//echo $stmt->queryString;
			} else {
				$stmt->execute ();
			}
			return $stmt;
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	}
	function selectAllFrom($table) {
		return $this->query ( "select * from " . $table );
	}
	function selectAllFromWhere($table, $where_clause, $input_parameters = array()) {
		return $this->query ( "select * from `" . $table . "` where " . $where_clause, $input_parameters );
	}
	function selectById($table, $id, $id_column = "id") {
		return $this->query ( "select * from `" . $table . "` where `" . $id_column . "` = :id", array (
				":id" => $id 
		) );
	}
	function _buildInsertQuery($array, $table) {
		$sql = "insert into " . $table . " (";
		$sql_keys = array();
		foreach ( array_keys ( $array ) as $column ) {
			$sql = $sql . " " . $column . ",";
			array_push($sql_keys, ":".$column);
		}
		$sql = rtrim ( $sql, "," ) . ") values (";
		foreach ( array_keys ( $array ) as $column ) {
			/* if ($value == "NOW()") {
				$sql = $sql . $value . ",";
			} else { */
				$sql = $sql . ":" . $column . ",";
			/* } */
		}
		$input_params = array_combine(array_values($sql_keys), array_values($array));
		$sql =  rtrim ( $sql, "," ) . ")";
		echo $sql;
		var_dump($input_params);
		$this->query($sql, $input_params); 
	}
	function _buildUpdateQuery($array, $table, $where) {
		$sql = "update " . $table . " set ";
		foreach ( $array as $column => $value ) {
			$sql = $sql . $column . "='" . $value . "',";
		}
		$sql = rtrim ( $sql, "," ) . " where ";
		foreach ( $where as $column => $value ) {
			$sql = $sql . $column . "='" . $value . "',";
		}
		echo $sql;
		return rtrim ( $sql, "," ) . ";";
	}
	function lastInsertId() {
		return $this->_database->lastInsertId ();
	}
	function responseIsEmpty($response) {
		if ($response->rowCount () > 0) {
			return false;
		}
		return true;
	}
}