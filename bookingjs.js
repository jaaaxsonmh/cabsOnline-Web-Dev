/*
    Jack Hosking 16932920
    bookingjs.js
    Using POST to send the booking requests through XHR.
*/
var xhr = createRequest();

function booking(dataSource, ID) {
    if (xhr) {

        var name = document.getElementById("nameInput")
        var phone = document.getElementById("mobileInput")
        var date = document.getElementById("bookingDate")
        var time = document.getElementById("bookingTime")
        var unit = document.getElementById("Unit")
        var sNumber = document.getElementById("sNumber")
        var sName = document.getElementById("sName")
        var delivery = document.getElementById("delivery")

        var obj = document.getElementById(ID);
        // Send data booking.php file using POST method
        var requestbody = "name=" + encodeURIComponent(name.value)
            + "&phone=" + encodeURIComponent(phone.value)
            + "&date=" + encodeURIComponent(date.value)
            + "&time=" + encodeURIComponent(time.value)
            + "&unit=" + encodeURIComponent(unit.value)
            + "&streetNumber=" + encodeURIComponent(sNumber.value)
            + "&streetName=" + encodeURIComponent(sName.value)
            + "&destination=" + encodeURIComponent(delivery.value);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // Response on ready state
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                obj.innerHTML = "<span style='color:black'>" + xhr.responseText + "</span>";
            }
        }
        xhr.send(requestbody);
    }
}