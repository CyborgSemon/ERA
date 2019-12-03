<?php

/*
*
* @params: $conn          mysqli_connect  – The conection to the database
*		   $sql           String 		  – The SQL query that will be run
*		   $value_type    String 		  – The string that sets the prepared statment to the correct variable types
*		   $values        Array  		  – The values that will be used with the prepared statment
*/

function prep_stmt($conn, $sql, $value_type = null, $values = null){
	if ($value_type == null) {
		$result = mysqli_query($conn, $sql);
		return $result;
	} else {
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			die('Databse error. There was an issue with the SQL statment');
		} else {
			$safeValues = [];
			$sqlType = explode(' ', trim($sql))[0];
			if ($sqlType == "INSERT" || $sqlType == "UPDATE") {
				for ($i=0; $i < count($values); $i++) {
					if (is_string($values[$i])) {
						$test = json_decode($values[$i]);
						if (json_last_error() === 0) {
							array_push($safeValues, $values[$i]);
						} else {
							array_push($safeValues, htmlentities($values[$i]));
						}
					} else {
						array_push($safeValues, $values[$i]);
					}
				}
			} else {
				$safeValues = $values;
			}

			mysqli_stmt_bind_param($stmt, $value_type, ...$safeValues);
			mysqli_stmt_execute($stmt);

			if ($sqlType == "INSERT") {
				$return = mysqli_stmt_insert_id($stmt);
			} elseif ($result = mysqli_stmt_get_result($stmt)) {
				$return = $result;
			}
			mysqli_stmt_close($stmt);
			if (isset($return)) {
				return $return;
			}
		}
	}
}

?>