$(document).ready(function() {
    /* Flatpickr */
    
    // Load flatpickr for equipment reservations
    let fpItemStartDate = $("#update_item_datetime_start").flatpickr({
        dateFormat: "Y-m-d H:i",
        // minDate: new Date(),
        defaultDate: new Date(),
        enableTime: true,
        time_24hr: true,
        altInput: true,
        altInputClass: '',
        altFormat: "d/m/y @ H:i",
        onOpen: [function(dateStr, dateObj) {
            this.set("defaultDate", new Date());
        }],
        onClose: [function(dateStr, dateObj) {
            fpItemEndDate.clear();
            fpItemEndDate.set("minDate", dateObj);
        }]
    });
    
    let fpItemEndDate = $("#update_item_datetime_end").flatpickr({
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
        enableTime: true,
        time_24hr: true,
        altInput: true,
        altInputClass: '',
        altFormat: "d/m/y @ H:i",
    });
});