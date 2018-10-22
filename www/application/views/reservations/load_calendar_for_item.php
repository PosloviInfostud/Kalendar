    <p>/mesto za kalendar/</p>
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
         
<script src="/js/reservations.js"></script>

