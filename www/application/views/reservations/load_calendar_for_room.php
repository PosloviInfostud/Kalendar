    <p>/mesto za kalendar/</p>
    <div id="show_errors"><?php echo validation_errors(); ?></div>

    <div class="form-froup">
        <p>When?</p>
        From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center"> 
        to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
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
            <option value="<?= $user['id'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?> 

        </select>
    </div>
    <input type="submit" name="submit" id="reservation_room_submit_by_room" class="btn btn-block btn-success" value="Reserve!">
         
<script src="/js/reservations.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

    });
</script>
