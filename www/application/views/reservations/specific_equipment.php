<div class="jumbotron">
    <form action="/reservations/submit_reservation_form" method="POST">
        <div class="form-group col-9 text-center">
            <h3 class="text-center p-2">Which item do you want to reserve?</h3>
            <select name="room" id="room" class="js-example-basic-single form-control select_item">
                <option selected="true" disabled="disabled">Choose item</option>
                <?php foreach ($equipment as $item) { ?>
                    <option value="<?= $item['id']; ?>"><?= $item['equipment_type_name']; ?>, <?= $item['name']; ?> (<?= $item['barcode']; ?>, <?= $item['description']; ?>)</option>
                <?php } ?>
            </select>
        </div>
        <div id="show"></div>
    </form>
</div>
<script src="/js/reservations.js"></script>