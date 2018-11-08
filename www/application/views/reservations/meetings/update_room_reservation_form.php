<script>
var current_reservations = <?= $current_reservations; ?>;
var background = "<?= $background; ?>";
</script>
<h2 class="text-center p-2">Update reservation "<?= $meeting['title'] ?>"</h2>
<div class="container mt-5">
    <form id="form_update_room_reservation">

        <div class="form-group col-9">
            <label for="room">Select Room</label>
            <select name="room" id="update_room_select" class="js-example-basic-single form-control select_room text-center">
                <?php foreach ($rooms as $room) { ?>
                    <?php if($room['id'] == $meeting['room_id']) { ?>
                        <option value="<?= $room['id']; ?>" selected><?= $room['name']; ?></option>
                    <? } else { ?>
                        <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
                <?php }
                 } ?>
            </select>
        </div>

        <div id="calendar"></div>
        <div id="show_errors"></div>

        <div class="form-group border rounded border-info p-3 m-3">
            <p>When?</p>
            From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center" value="<?= $meeting['starttime'] ?>"> 
            <input type="hidden" name="default_start_time" id="default_datetime_start" value="<?= $meeting['starttime'] ?>">
            to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center" value="<?= $meeting['endtime'] ?>">
            <input type="hidden" name="default_end_time" id="default_datetime_end" value="<?= $meeting['endtime'] ?>">
        </div>

        <div class="form-group border rounded border-info p-3 m-3">
            <label for="title">What is the Name of the Event?</label>
            <input type="text" class="form-control" name="title" id="reservation_name" value="<?= $meeting['title'] ?>">
        </div>
                
        <div class="form-group border rounded border-info p-3 m-3">
            <label for="description">Describe it to the Attendants</label>
            <textarea class="form-control" name="description" id="reservation_description"><?= $meeting['description'] ?></textarea>
        </div>

        <input type="hidden" name="res" id="res" value="<?= $meeting['id'] ?>">
        <input type="hidden" name="parent" id="parent" value="<?= $meeting['parent'] ?>">
        <!-- Check if it's a recurring reservation -->
        <?php if($meeting['recurring'] == 1) { ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="update_all_child_reservations">
                <label class="form-check-label" for="update_all_child_reservations">Update all reservations</label>
            </div>
        <?php } ?>
            
        <div class="form-group mt-3">
            <input type="submit" name="submit" id="form_update_room_reservation_submit" form="form_update_room_reservation" class="btn btn-block btn-success" value="Update">
        </div>

    </form>
</div>