
<!DOCTYPE html>

<html>
	<title>Performances</title>
	<link rel="shortcut icon" type="image/png" href="../images/mega.png"> <!--  tab icon(logo) display in browser -->

	<link href="../styles/mystyles.css" type="text/css" rel="stylesheet">
<head>

	<h1 align="center">MEGA THEATER</h1>
		<meta charset="UTF-8">

	<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>

	<?php

		require ('connect.php');  // connects to the server.
		$conn = myconnect();

		session_start();

	  $Name = htmlspecialchars($_GET['Name']);  // variable for injection attack.
		$_SESSION['Person'] = $Name;  // Global variable to store User Name.
		$_SESSION['Email'] = $_GET['email'];  // Global variable to store user Email.

		echo "<p align='center'> Welcome to Mega Threater, <u>".$_SESSION['Person']."</u>! Please select the Performances below : </p>";

		$sql = "SELECT * FROM Performance p JOIN Production r ON p.Title=r.Title";  // sql query to display datas from the database server.
		$handle = $conn->prepare($sql);
		$handle->execute();
		$conn = null;
		$res = $handle->fetchAll();
			// table to show Performances detail
			echo "<table align='center' class='tableX'>
								<tr>
									<th>Title</th>
									<th>Date</th>
									<th>Time</th>
									<th>Availability</th>
								</tr>";

								foreach($res as $row) /* this loop will performances deatil in table formate. */
								{
									echo "<form action='seats.php' method='GET'>
								        <tr>
								          <td class='titleX'>".$row['Title']."
													<input type='hidden' name='ChosenTitle' value=".$row['Title'].">
													</td>

										  		<td>".$row['PerfDate']."
													<input type='hidden' name='ChosenDate' value=".$row['PerfDate'].">
													</td>

										  		<td>".$row['PerfTime']."
													<input type='hidden' name='ChosenTime' value=".$row['PerfTime'].">
													</td>

													<input type='hidden' name='ChosenPrice' value=".$row['BasicTicketPrice'].">

													<td class='seeAV'><input type='submit' value='See Availability'> </td>
								        </tr>
												</form>";
								}
				echo '</table>';
	?>

</body>

</html>
