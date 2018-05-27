<?php
/*
    Jack Hosking 16932920
    db.php
    Establish connection and create table if it does not exist.
*/

// select the cabsOnline table and establish connection
$conn = mysqli_connect("cmslamp14.aut.ac.nz", "jpm8993", "abc12345");
$db_selected = mysqli_select_db($conn, "jpm8993");

// Create the cabsOnline table if it does not exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS cabsOnline
	(
		BookingNumber INT NOT NULL,
		BookingDate DateTime NOT NULL,
		BookingStatus VARCHAR(25) NOT NULL,
		CustomerName VARCHAR(25) NOT NULL,
		CustomerPhone INT(14) NOT NULL,
		CustomerAddress VARCHAR(255) NOT NULL,
		BookingPickupDate DateTime NOT NULL,
		BookingDestination VARCHAR(40) NOT NULL,
		PRIMARY KEY(BookingNumber)
	)";
echo mysqli_error($conn) . "<br>";
mysqli_query($conn, $sqlCreateTable);
?>