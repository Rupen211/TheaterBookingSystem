<?php
	function myconnect()
	{
	$host = 'localhost';
	$dbname = 'theater_booking_system';
	$user = 'root';
	$pwd = 'Que21163683!';
	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ($conn)
		{
		//echo 'Connected to '.$dbname;
			return $conn;

		} else
		{
			//$conn = null;
			//return $conn;
			echo 'Failed to connect';
		}
	} catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
  }


?>
