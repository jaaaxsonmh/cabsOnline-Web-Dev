/*
    Jack Hosking 16932920
    adminjs.js
    Using POST method for XHR
    function booking (set taxi driver).
    function assignment (view un-assigned bookings).
*/
var xhr = createRequest();

function booking(dataSource, displayID, BookingNumber) {
    if (xhr) {
        var obj = document.getElementById(displayID);
        // Send data manage.php file using POST method
        var requestbody = "BookingNumber=" + encodeURIComponent(BookingNumber);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // Response on ready state
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                obj.innerHTML = "<span>" + xhr.responseText + "</span>";
            } // end if
        } // end anonymous call-back function
        xhr.send(requestbody);
    } // end if
}

function assignment(dataSource, displayID, date) {
    if (xhr) {
        var obj = document.getElementById(displayID);
        // Send data manage.php file using POST method
        var requestbody = "date=" + encodeURIComponent(date);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // Response on ready state
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                obj.innerHTML = "<span>" + xhr.responseText + "</span>";
            } // end if
        } // end anonymous call-back function
        xhr.send(requestbody);
    } // end if
}