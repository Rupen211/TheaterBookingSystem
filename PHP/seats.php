<!DOCTYPE html>

<html>
	<title>Availability</title>
	<link rel="shortcut icon" type="image/png" href="../images/mega.png">  <!--  tab icon(logo) display in browser -->

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

	  $_SESSION['title'] = $_GET['ChosenTitle'];		/* Global Variable for selected Title.*/
		$_SESSION['Date'] = $_GET['ChosenDate'];		/* Global variable for selected Date.*/
		$_SESSION['time'] = $_GET['ChosenTime'];		/* Global variable for selected Time.*/
		$_SESSION['TicketPrice'] = $_GET['ChosenPrice'];		/* Global variable for selected Performace price.*/

		echo "<p class= 'info' align='center'> Hello <u>".$_SESSION['Person']."</u>, Please select one or more seats and click 'Confirm Booking'. </p>";
		/* SQL quary for displaying the available seat for the selected Performance.*/
		$sql = "SELECT Seat.RowNumber, ROUND (Zone.PriceMultiplier * '".$_SESSION['TicketPrice']."') AS Price
            FROM Seat JOIN Zone ON Zone.Name=Seat.Zone
            WHERE Seat.RowNumber NOT IN
            (SELECT Booking.RowNumber FROM Booking
            WHERE Booking.PerfTime='".$_SESSION['time']."'
            AND Booking.PerfDate='".$_SESSION['Date']."')
						ORDER BY Seat.RowNumber;";

		$handle = $conn->prepare($sql);
		$handle->execute();
		$conn = null;
		$res = $handle->fetchAll();

			echo "<p align='center'> Seats for ".$_SESSION['title']." on ".$_SESSION['Date']." at ".$_SESSION['time']."</p>";

 ?>

<p> Total : £<span id='valueX'></span></p>


<p> Selected Seats : <br><span align='center' id='seatX'></span>

<script type="text/javascript">

function getRealistic()  // javascript function to store the data of Seats and their prices from the database.
{
	var getSeats = new Array();  // array to store seats details.
	var getValue = new Array();	// array to store seats values.

	var storeArray = document.querySelectorAll('input[type=checkbox]:checked'); //this stores the data of seats and their prices if the box has been checked.

		for (var i=0; i<storeArray.length; i++) //for loop to store the seats and values in their array.
		{
			getSeats.push(storeArray[i].name);
			getValue.push(storeArray[i].value);
		}

	var seatTotal = 0;
		for (var j=0;j<getValue.length;j++)		// stores the total value of the selected seats.
	  {
 	 	 	var seatValue=parseInt(getValue[j]);
		 	seatTotal += seatValue;
		}

	document.getElementById("valueX").innerHTML = seatTotal;
	document.getElementById("seatX").innerHTML = getSeats;
	document.Bookingform.confirmV.value = seatTotal;
	document.Bookingform.confirmS.value = getSeats;

}

function ticketConfirm()		// this function warns user if thy haven't selected any seats. I not then it won't go to another confirm page.
{
		var numConfirm = document.querySelectorAll('input[type=checkbox]:checked');

		if(numConfirm.length == 0)
			{ alert("Please, select atleast one Seat");
		 		return false;}

		else
			{ return true; }
}

</script> </p>

<div class='confirmbutton' align='center'>
	<form name='Bookingform' action='book.php' method='POST'>
				<input type='hidden' name='confirmV' value=''>
				<input type='hidden' name='confirmS' value=''>
				<input class='buttons' type='submit' value='Confirm Booking' onclick='return ticketConfirm()'>

	</form></div>
<br>

 <?php
			echo '<table align="center" class="tableX">
								<tr>
									<th>Seat</th>
									<th>Price (£)</th>
									<th>Check List</th>
								</tr>';

								foreach($res as $row)  // loop to display all the available seats for Booking.
								{

								  echo "<tr>
								          <td class='titleX'>".$row['RowNumber']."</td>
													<input type='hidden' name='ChosenRownumber' id='seatName' value=".$row['RowNumber'].">";
													$SeatName = $row['RowNumber'];

									echo "<td>".$row['Price']."</td>
													<input type='hidden' name='ChosenPrice' id='Cost' value=".$row['Price'].">";
													$SeatValue = $row['Price'];

									echo "<td class='seeAV'>
													<input type='Checkbox' name='$SeatName' value='$SeatValue' onclick='getRealistic()'> </td>
								        </tr>";
								}
						echo "</table>";

	?>
</body>

</html>
