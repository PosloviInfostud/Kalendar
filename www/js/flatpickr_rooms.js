$(document).ready(function() {
    var curTime = new Date();  
    // Handle weekends
    if(curTime.getDay() === 5) {
        curTime.setHours(8,0,0);
        curTime.setDate(curTime.getDate() + 3); // add 3 days
    } else if(curTime.getDay() === 6) {
        curTime.setHours(8,0,0);
        curTime.setDate(curTime.getDate() + 2); // add 2 days
    } else if(curTime.getDay() === 0) {
        curTime.setHours(8,0,0);
        curTime.setDate(curTime.getDate() + 1); // add 2 days
    }
    // Check if we are over maxtime
    if(curTime.getHours() > 18) {
        curTime.setHours(8,0,0);
        curTime.setDate(curTime.getDate() + 1); // add a day
    // Check if we are before mintime
    } else if(curTime.getHours() < 8) {
        curTime.setHours(8,0,0); // set time to 08:00:00
    };
    // Load flatpickr for room reservations
    var fpRoomStartDate = $("#datetime_start").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: curTime,
        defaultDate: curTime,
        enableTime: true,
        time_24hr: true,
        minTime: "08:00",
        maxTime: "18:00",
        defaultHour: "8",
        // wrap: true,
        altInput: true,
        altInputClass: '',
        altFormat: "H:i (d.m.Y)",
        "disable": [
            function(date) {
                // return true to disable
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ],
        "locale": {
            "firstDayOfWeek": 1 // start week on Monday
        },
        onChange: [function(dateStr, dateObj) {
                fpRoomEndDate.set("minDate", dateObj);
        }]
    });
    
    var fpRoomEndDate = $("#datetime_end").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: curTime,
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        minTime: "08:00",
        maxTime: "18:00",
        defaultHour: "8",
        altInput: true,
        altInputClass: '',
        altFormat: "H:i",
    });
});