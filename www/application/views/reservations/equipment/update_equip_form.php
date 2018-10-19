<p>/mesto za kalendar/</p>
    <div id="show_errors"><?php echo validation_errors(); ?></div>

    <div class="form-froup">
        <p>When?</p>
        From <input type="text" name="start_time" id="item_datetime_start" class="text-center" data-default-date="<?= $equipment['starttime'] ?>"> 
        to <input type="text" name="end_time" id="item_datetime_end" class="text-center" data-default-date="<?= $equipment['endtime'] ?>">
    </div>
              
    <div class="form-group">
        <label for="description">Why do you need it?</label>
        <textarea class="form-control" name="description" id="reservation_description"><?= $equipment['description'] ?></textarea>
    </div>
        <input type="hidden" name="res_id" id="res_id" value="<?= $equipment['id'] ?>">
        <input type="hidden" name="equip_id" id="equip_id" value="<?= $equipment['equipment_id'] ?>">
        <input type="submit" name="submit" id="update_equipment_submit" class="btn btn-block btn-success" value="Reserve!">
         
<script src="/js/reservations.js"></script>
<script>
/* Flatpickr */

// Load flatpickr for equipment reservations
let fpItemStartDate = $("#item_datetime_start").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    // defaultDate: new Date(),
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

</script>