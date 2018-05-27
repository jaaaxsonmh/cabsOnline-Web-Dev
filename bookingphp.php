<?php

/*
    Jack Hosking 16932920
    bookingphp.php
    Validate all form data from the user, then update database with new booking.
    function to create unique booking number using time as a randomizer.
*/

//receive and set variables from the form data. Using POST Method
$name = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$unit = $_POST['unit'];
$streetNumber = $_POST['streetNumber'];
$streetName = $_POST['streetName'];
$destination = $_POST['destination'];


//create returnable message to booking.html (display)
$msg = "";
$counter = 0;

$msg = "unit:" . $unit . "<br>";

//validate name is entered with only alpha chars, not numbers or special chars using patterns and empty
if (empty($name) || !preg_match('/[a-zA-Z]/', $name)) {
    $msg = $msg . "Name is incorrect. <br>";
    $counter++;

}

//validate contact number is only numbers and at least 7 numbers in length (NZ cell -> homeline)
if (empty($phone) || !preg_match('/[0-9]/', $phone) || strlen($phone) < 7) {
    $msg = $msg . "Contact number is incorrect <br>";
    $counter++;

}

//validate street number and unit is only number
if (empty($streetNumber) || !preg_match('/[0-9]/', $streetNumber)) {
    $msg = $msg . "Street number is incorrect <br>";
    $counter++;

}
if (empty($unit) || !preg_match('/[0-9]/', $unit)) {
    $msg = $msg . "Unit number is incorrect <br>";
    $counter++;

}

//validate street name does not contain numbers.
if (empty($streetName) || !preg_match('/[a-zA-Z]/', $streetName)) {
    $msg = $msg . "Street Name is incorrect <br>";
    $counter++;

}

//validate destination does not contain numbers
if (empty($destination) || !preg_match('/[a-zA-Z]/', $destination)) {
    $msg = $msg . "Destination is incorrect <br>";
    $counter++;
}

//date and time are validated to be correct against current date for the area
// timezone used instead of data objects as if someone is booking taxi in different timezone for when they arrive to NZ could be problematic
date_default_timezone_set("Pacific/Auckland");
$datetimeInput = strtotime($date . " " . $time);
$requestedDateTime = date('Y-m-d H:i', $datetimeInput);
$currentDateTime = date('Y-m-d H:i');

if (empty($date) || empty($time) || !preg_match('/:[0-9]/', $time) || !preg_match('/-[0-9]/', $date) || $requestedDateTime < $currentDateTime) {
    $msg = $msg . "Requested pickup time and date are incorrect <br>";
    $counter++;
}

// generate booking number, create pickup address, check unique booking number and insert into table the details, then close and set msg.
// msg will be empty if no errors in the validation!
if ($counter === 0) {
    include('db.php');

    $msg = $msg . "In if";

    $bookingNumber = unique_code_generator();
    $pickupLocation = $streetNumber . " " . $streetName;
    //if no rows are returned from query then bookingNumber is empty and able to be used.
    $checkBookingNumber = "SELECT * FROM cabsOnline WHERE BookingNumber = '$bookingNumber'";
    $query = @mysqli_query($conn, $checkBookingNumber) or die ("Error,<br>" . mysqli_error($conn));
    $rows = @mysqli_num_rows($query);
    // Check if booking Number Exists
    if (!empty($rows)) {
        $bookingNumber = unique_code_generator();
    }

    $msg = $msg . "In if2";

    $insertQuery = "INSERT INTO 

cabsOnline(BookingNumber, BookingDate, BookingStatus, CustomerName, CustomerPhone, CustomerAddress, BookingPickupDate, BookingDestination) 
VALUES ('$bookingNumber', '$currentDateTime', 'unassigned', '$name', '$phone', '$pickupLocation', '$requestedDateTime', '$destination')";
    $query = @mysqli_query($conn, $insertQuery) or die ("Error,<br>" . mysqli_error($conn));

    mysqli_close($conn);
    $msg = "Thank you! <br> Your booking number is $bookingNumber <br> Your taxi will arrive at $time on $date <br>";
}

function unique_code_generator()
{
    $code = time();
    // 1 in 5000 chance that two people book at same time get same number (high odds)
    return (rand(0000, 5000));
}

echo $msg;
?>