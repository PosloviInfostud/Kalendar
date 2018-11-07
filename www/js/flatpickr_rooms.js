$(document).ready(function() {
// Load flatpickr for room reservations
    var fpRoomStartDate = $("#datetime_start").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
        defaultDate: new Date(),
        enableTime: true,
        time_24hr: true,
        minTime: "08:00",
        maxTime: "18:00",
        // wrap: true,
        altInput: true,
        altInputClass: '',
        altFormat: "D @ H:i (d/n)",
        onOpen: [function(dateStr, dateObj) {
            this.set("defaultDate", new Date());
        }],
        onChange: [function(dateStr, dateObj) {
                fpRoomEndDate.set("minDate", dateObj);
        }]
    });
    
    var fpRoomEndDate = $("#datetime_end").flatpickr({
        disableMobile: "true",
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
        // defaultDate: end_time,
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        minTime: "08:00",
        maxTime: "18:00",
        altInput: true,
        altInputClass: '',
        altFormat: "H:i",
    });
});