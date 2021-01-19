<!DOCTYPE html>

<html>
	<title>Booking</title>
	<link rel="shortcut icon" type="image/png" href="../images/mega.png"> <!--  tab icon(logo) display in browser -->

	<link href="../styles/mystyles.css" type="text/css" rel="stylesheet">
<head>
	<h1 align="center">MEGA THEATER</h1>
		<meta charset="UTF-8">

	<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>
	<?php

		require ('connect.php');
		$conn = myconnect();

		session_start();

	  $_SESSION['tValue'] = $_POST['confirmV'];  /* Golbal variable for total value of the selected Seats*/
		$_SESSION['displaySeats'] = $_POST['confirmS'];	/* Golobal variable for Selected Seats in array form*/

		$seats = explode(",", $_SESSION['displaySeats']);

		foreach($seats as $ind_seat)		/* loop to Insert the quaries to database for each indivisual seats and its details*/
		{

			$sql = "INSERT INTO Booking			/* sql insertion with Injection attack security*/
	 						VALUES (:e,:d,:t,:s);";
							$handle = $conn->prepare($sql);
							$handle->execute(array(':e'=>$_SESSION['Email'], ':d'=>$_SESSION['Date'], ':t'=>$_SESSION['time'],':s'=>$ind_seat));
		}

		$conn = null;

		echo "<p align='center' class= 'info'> Hello <u>".$_SESSION['Person']."</u>, thank you for your purchase. Booking summary for :</p>";

		echo "<p class= 'info' align='center'> Seats for '<u>".$_SESSION['title']."'</u> on '<u>".$_SESSION['Date']."</u>' at '<u>".$_SESSION['time']."</u>'</p>";

		echo "<p class= 'info' align='center'> Seats Selected = <span id='valueX'>".$_SESSION['displaySeats']." (Successfully Booked.)</span></p>";
		echo "<p class= 'info' align='center'> Total paid = <span id='valueX'> £".$_SESSION['tValue']."</span></p>";

		echo "<p class= 'info' align='center'> Confirmantion e-mail has been sent to you at <u>".$_SESSION['Email']."</u></p>";

		echo "<div align='center'><form action='../index.html'><input class='buttons' type='submit' value='Back to Home' onclick='session_destroy()'></form></div>";
 ?>
</body>
