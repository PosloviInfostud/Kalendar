<div class="jumbotron">
<p>/mesto za kalendar/</p>
    <div id="show_errors"><?php echo validation_errors(); ?></div>
    <?php
        $date = date('Y-m-d h:i:s', time()); ?>
        <div class="form-froup">
        <p>When?</p>
        <?php if($equipment['starttime']< $date) { ?>
            From <input type="text" name="start_time" id="update_item_datetime_start" class="text-center" data-default-date="<?= $equipment['starttime'] ?>"  disabled="disabled"> 
        <?php } else { ?>
            From <input type="text" name="start_time" id="update_item_datetime_start" class="text-center" data-default-date="<?= $equipment['starttime'] ?>"> 
        <?php } ?>
        to <input type="text" name="end_time" id="update_item_datetime_end" class="text-center" data-default-date="<?= $equipment['endtime'] ?>">
    </div>
              
    <div class="form-group">
        <label for="description">Why do you need it?</label>
        <textarea class="form-control" name="description" id="reservation_description"><?= $equipment['description'] ?></textarea>
    </div>
        <input type="hidden" name="res_id" id="res_id" value="<?= $equipment['id'] ?>">
        <input type="hidden" name="equip_id" id="equip_id" value="<?= $equipment['equipment_id'] ?>">
        <input type="submit" name="submit" id="update_equipment_submit" class="btn btn-block btn-success" value="Reserve!">
        </div>
        
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="update_equipment_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirm Update</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modal-btn-yes">Yes</button>
        <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>        
        
<script src="/js/reservations.js"></script>
<script>
// Load flatpickr for update equipment reservations
$("#update_item_datetime_start").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: "<?= $equipment['starttime'] ?>",
    // defaultDate: new Date(),
    enableTime: true,
    time_24hr: true,
    altInput: true,
    altInputClass: '',
    altFormat: "d/m/y @ H:i",
});

$("#update_item_datetime_end").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    enableTime: true,
    time_24hr: true,
    altInput: true,
    altInputClass: '',
	altFormat: "d/m/y @ H:i",
});
</script>