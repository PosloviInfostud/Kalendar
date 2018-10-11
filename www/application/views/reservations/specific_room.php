<form action="/reservations/submit_reservation_form" method="POST">
    <div class="form-group col-9 text-center">
        <h3 class="text-center p-2">Which room do you want to reserve?</h3>
        <select name="room" id="room" class="js-example-basic-single form-control select_room">
            <?php foreach ($rooms as $room) { ?>
                <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="show">

    </div>

</form>

<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();

});


</script>
<script src="/js/reservations.js"></script>