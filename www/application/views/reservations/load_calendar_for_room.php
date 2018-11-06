<script>
var current_reservations = <?= $current_reservations; ?>;
var background = "<?= $background; ?>";
</script>

    <div class="form-froup flatpickr">
    <div id="calendar"></div>
        <p>When?</p>
        From <input type="text" data-input name="start_time" id="datetime_start" placeholder="start time" class="text-center" value=""> 
        to <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="text-center" data-default-date="">
    </div>
    <div id="show_errors"><?php echo validation_errors(); ?></div>

    <div class="form-group">
        <label for="res_frequency">Frequency</label>
        <select class="form-control" id="res_frequency">
            <?php foreach($frequencies as $freq) { ?>
                <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">What is the Name od the Event?</label>
        <input type="text" class="form-control" name="title" id="reservation_name">
    </div>
                
    <div class="form-group">
        <label for="description">Describe it to the Attendants</label>
        <textarea class="form-control" name="description" id="reservation_description"></textarea>
    </div>

    <div class="form-group">
        <p>Who do you want to invite?</p>

        <select class="js-example-basic-multiple form-control" name="members[]" id="members" multiple="multiple">

        <?php foreach($users as $user) { ?>
            <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?> 

        </select>
    </div>
    <input type="submit" name="submit" id="reservation_room_submit_by_room" class="btn btn-block btn-success" value="Reserve!">

            
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="room_reservation_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirm Room Reservation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="reservation_room_submit_by_room_modal-btn-yes">Yes</button>
        <button type="button" class="btn btn-default" id="reservation_room_submit_by_room_modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>      
<script src="/js/calendar_for_room.js"></script>
<script src="/js/flatpickr_rooms.js"></script>