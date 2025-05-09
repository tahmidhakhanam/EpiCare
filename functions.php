<?php
	//Function to connect to database
	function getConnection() {
		try {
			$connection = new PDO("mysql:host=localhost;dbname=unn_w17017369",
						"unn_w17017369", "Sensations2333");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $connection;
		} 
		catch (Exception $e) {
			throw new Exception("Connection error ". $e->getMessage(), 0, $e);
		}
	}

	//Function to save session variable
	function set_session($key, $value) {
		$_SESSION[$key] = $value;
		return true;
	}

	//Function to read session variable
	function get_session($key = 'false') {
		//Check if seesion element 'key' exists
		if (isset($_SESSION[$key])) {
			//Read the session’s value from the $_SESSION array 
			$value = $_SESSION[$key];
			//Return session's value
			return $value;
		}
	}

	function check_login() {
		//Calls get_session()
		get_session();
		//Check if session variable 'logged-in' is true
		if (isset( $_SESSION[ 'logged-in' ] ) && $_SESSION[ 'logged-in' ] == true) {
			//If so return true
			return true;
		} else {
			//If not return false
			return false;
		}
	}
	
	
	//Global exception handler that will fire if no catch block is found
	function exceptionHandler ($e) {
		echo "<p><strong>Problem occured</strong></p>";
		log_error($e);
	}
	//Set the php exception handler to be the one above
	set_exception_handler('exceptionHandler');

	//Global exception handler that will convert errors into exceptions
	function errorHandler ($errno, $errstr, $errfile, $errline) {
	  //Check error isn’t excluded by server settings
	  if(!(error_reporting() & $errno)) { 
		  return; 
	  }
	  throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
	}
	//Set the php error handler to be the one above 
	set_error_handler('errorHandler');

	function log_error($e) {
		//Open file
		$fileHandle = fopen("error_log_file.log", "ab");
		
		//Store date and time error occured
		$errorDate = date('D M j G:i:s T Y');
		//Store error details from $->getMessage()
		$errorMessage = $e->getMessage();
		//Remove line breaks
		$toReplace = array("\r\n", "\n", "\r"); 
		//chars to replace
		$replaceWith = '';
		$errorMessage = str_replace($toReplace, $replaceWith, $errorMessage);

		fwrite($fileHandle, "$errorDate|$errorMessage".PHP_EOL);
		//Close file
		fclose($fileHandle);
	}
?>