<h2 class="text-center p-2">Update reservation "<?= $meeting['title'] ?>"</h2>
<div class="container mt-5">
    <form id="form_update_room_reservation">

        <div class="form-group col-9">
            <label for="room">Select Room</label>
            <select name="room" id="room_select" class="js-example-basic-single form-control select_room text-center">
                <?php foreach ($rooms as $room) { ?>
                    <?php if($room['id'] == $meeting['room_id']) { ?>
                        <option value="<?= $room['id']; ?>" selected><?= $room['name']; ?></option>
                    <? } else { ?>
                        <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
                <?php }
                 } ?>
            </select>
        </div>

        /mesto za kalendar/

        <div class="form-froup border rounded border-info p-3 m-3">
            <p>When?</p>
            From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center" value="<?= $meeting['starttime'] ?>"> 
            to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center" value="<?= $meeting['endtime'] ?>">
        </div>

        <div class="form-froup border rounded border-info p-3 m-3">
            <label for="title">What is the Name od the Event?</label>
            <input type="text" class="form-control" name="title" id="reservation_name" value="<?= $meeting['title'] ?>">
        </div>
                
        <div class="form-froup border rounded border-info p-3 m-3">
            <label for="description">Describe it to the Attendants</label>
            <textarea class="form-control" name="description" id="reservation_description"><?= $meeting['description'] ?></textarea>
        </div>

        <input type="hidden" name="res" id="res" value="<?= $meeting['id'] ?>">
        <input type="submit" name="submit" id="form_update_room_reservation_submit" class="btn btn-block btn-success" value="Update">

    </form>
</div>

<script src="/js/reservations.js"></script>