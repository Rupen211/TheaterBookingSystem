<?php
	function myconnect()
	{
	$host = 'dragon.ukc.ac.uk';
	$dbname = 'rk426';
	$user = 'rk426';
	$pwd = 'esindgl';
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
