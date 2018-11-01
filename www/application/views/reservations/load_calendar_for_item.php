<script>
var current_reservations = <?= $current_reservations; ?>;
</script>

<div id="calendar"></div>
    <div id="show_errors"><?php echo validation_errors(); ?></div>

    <div class="form-froup">
        <p>When?</p>
        From <input type="text" name="start_time" id="item_datetime_start" placeholder="start datetime" class="text-center"> 
        to <input type="text" name="end_time" id="item_datetime_end" placeholder="end datetime" class="text-center">
    </div>
              
    <div class="form-group">
        <label for="description">Why do you need it?</label>
        <textarea class="form-control" name="description" id="reservation_description"></textarea>
    </div>

        <input type="submit" name="submit" id="reservation_equipment_submit_by_item" class="btn btn-block btn-success" value="Reserve!">

        
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="equip_reservation_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirm Update</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="reservation_equipment_submit_by_item_modal-btn-yes">Yes</button>
        <button type="button" class="btn btn-default" id="reservation_equipment_submit_by_item_modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<script src="/js/calendar_for_item.js"></script>

