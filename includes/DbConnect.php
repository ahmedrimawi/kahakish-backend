<?php

class DbConnect
{
	// Variable to store database link
	private $con;

	function __construct()
	{

	}

	function connect()
	{
		//including the constrants.php file to get the database constants
		include_once dirname(__FILE__) . '/Constants.php';

        //connecting to mysql databae
		$this->con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

		//Cehcking if any error occured while connecting
		if(mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL" . mysqli_connect_error();
			return null;
		}

		//Finaly returning the connection link
		return $this->con;
	}
}
 
?>