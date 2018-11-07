<div class="jumbotron">
    <form action="/reservations/submit_reservation_form" method="POST">
        <div class="form-group col-9 text-center">
            <h3 class="text-center p-2">Which room do you want to reserve?</h3>
            <select name="room" id="room_select" class="js-example-basic-single form-control select_room">
                <option selected="true" disabled="disabled">Choose room</option> 
                <?php foreach ($rooms as $room) { ?>
                    <option value="<?= $room['id']; ?>" data-room_name="<?= $room['name']; ?>"><?= $room['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div id="show"></div>
    </form>
</div>
<script src="/js/reservations.js"></script>
