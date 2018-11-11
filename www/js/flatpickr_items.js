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
        curTime.setDate(curTime.getDate() + 1); // add a day
    // Check if we are before mintime
    } else if(curTime.getHours() < 8) {
        curTime.setHours(8,0,0); // set time to 08:00:00
    };
    // Load flatpickr for equipment reservations
    let fpItemStartDate = $("#item_datetime_start").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: curTime,
        defaultDate: curTime,
        enableTime: true,
        time_24hr: true,
        defaultHour: "8",
        altInput: true,
        altInputClass: '',
        altFormat: "d.m.Y @ H:i",
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
                fpItemEndDate.set("minDate", dateObj);
        }]
    });
    
    let fpItemEndDate = $("#item_datetime_end").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: curTime,
        enableTime: true,
        time_24hr: true,
        defaultHour: "8",
        altInput: true,
        altInputClass: '',
        altFormat: "d.m.Y @ H:i",
    });
});