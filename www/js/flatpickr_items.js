$(document).ready(function() {
    /* Flatpickr */
    
    // Load flatpickr for equipment reservations
    let fpItemStartDate = $("#item_datetime_start").flatpickr({
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
        defaultDate: new Date(),
        enableTime: true,
        time_24hr: true,
        altInput: true,
        altInputClass: '',
        altFormat: "d/m/y @ H:i",
        onOpen: [function(dateStr, dateObj) {
            this.set("defaultDate", new Date());
        }],
        onChange: [function(dateStr, dateObj) {
                fpItemEndDate.set("minDate", dateObj);
        }]
    });
    
    let fpItemEndDate = $("#item_datetime_end").flatpickr({
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
        enableTime: true,
        time_24hr: true,
        altInput: true,
        altInputClass: '',
        altFormat: "d/m/y @ H:i",
    });
});