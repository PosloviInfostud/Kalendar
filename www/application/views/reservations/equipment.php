<div class="jumbotron">
    <form id="reservation_equip_form" class="border border-warning rounded p-3" action="/reservations/submit_reservation_equip_form" method="POST">
        <div class="form-group">
            <p>What do you want to reserve?</p>
            <?php 
            $i=1; 
            foreach($equips as $equip) {   ?>

                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input radio_equipment" id="customRadio<?= $i; ?>" name="equipment_type" value="<?= $equip['id'] ?>">
                    <label class="custom-control-label" for="customRadio<?= $i; ?>"><?= $equip['name'] ?></label>
                </div>

            <?php  
            $i++;
            } ?>
        </div>
        <div class="form-group">
            <p>When?</p>
            <p>from <input type="text" name="start_time" id="item_datetime_start" placeholder="start datetime" class="text-center">
                to <input type="text" name="end_time" id="item_datetime_end" placeholder="end datetime" class="text-center">
        </p>
        </div>
        <button id="search_equipment" class="btn btn-outline-info">Search</button>
    <div id="show_errors"><?php echo validation_errors(); ?></div>
    <div id="rest"></div>
    </form>
</div>



<script src="/js/reservations.js"></script>
