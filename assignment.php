<?php
/*
    Jack Hosking 16932920
    assignment.php
    displayed requested un-assigned bookings.
*/

//increase time by 2hours to display all customers within that range.
$date = $_POST['date'];
date_default_timezone_set("Pacific/Auckland");
$date = date('Y-m-d H:i:s');
$futureDate = date("Y-m-d H:i:s", strtotime('+2 hours'));

include('db.php');
$selectQuery = "SELECT BookingNumber, CustomerName, CustomerPhone, CustomerAddress, BookingDestination, BookingPickupDate FROM cabsOnline WHERE BookingStatus = 'unassigned' AND BookingPickupDate BETWEEN '$date' AND '$futureDate'";
$resultSet = @mysqli_query($conn, $selectQuery) or die ("Error, <br>" . mysqli_error($conn));
$rows = @mysqli_num_rows($resultSet);

//create and display a table based on the query
if ($rows === 0) {
    $msg = "No matching results";
} else {
    $msg = "<table class='table'>
			<thead>
				<tr>
					<th scope='col'>Booking Number
					</th>
					<th scope='col'>Customer Name
					</th>
					<th scope='col'>Customer Phone
					</th>
					<th scope='col'>Pick Up Address
					</th>
					<th scope='col'>Destination
					</th>
					<th scope='col'>Pick Up Date
					</th>
				</tr>
			</thead>
			<tbody>";

    //fill out the table rows with associated results.
    while ($row = mysqli_fetch_array($resultSet)) {
        $msg = $msg . "<tr>";
        for ($i = 0; $i < 6; $i++) {
            $msg = $msg . "<td>";
            $msg = $msg . "<p>" . $row[$i] . "</p>";

        }
        $msg = $msg . "</td>";
        $msg = $msg . "</tr>";
    }
    mysqli_free_result($resultSet);

    mysqli_close($conn);
    $msg = $msg . "</tbody>
		           </table>";
}
echo $msg;
?>