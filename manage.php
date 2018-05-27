<?php
/*
    Jack Hosking 16932920
    manage.php
    Receive booking number check for existence and if already assigned, then assign a driver if it is not assigned.
*/

//php file used to compare booking numbers and set the booking to assigned.
$number = $_POST['BookingNumber'];
include('db.php');
$msg = "";

//check booking number is in the table.
$sqlQuery = "SELECT * FROM cabsOnline WHERE BookingNumber = '$number'";
$searchQuery = @mysqli_query($conn, $sqlQuery) or die ("Error, 1 <br>" . mysqli_error($conn));
$rows = @mysqli_num_rows($searchQuery);

if ($rows > 0) {
    //check taxi has NOT been assigned
    $sqlQuery = "SELECT * FROM cabsOnline WHERE BookingNumber = '$num' AND BookingStatus = 'assigned'";
    $searchQuery = @mysqli_query($conn, $sqlQuery) or die ("Error, 2<br>" . mysqli_error($conn));
    $rows = @mysqli_num_rows($searchQuery);
    if ($rows > 0) {
        $msg = "A taxi has already been assigned.";
    } else {
        // update bookingstatus to be assigned for that booking number
        $sqlQuery = "UPDATE cabsOnline SET BookingStatus = 'assigned' WHERE BookingNumber = '$number'";
        $searchQuery = @mysqli_query($conn, $sqlQuery) or die ("Error, 3<br>" . mysqli_error($conn));

        $msg = "The booking number: $number has been assigned a taxi driver.";
    }
} else {
    $msg = "Incorrect booking Number, please recheck the booking number by requesting booking.";
}

echo $msg;
?>