<div class="jumbotron">
    <form id="reservation_equip_form" class="border border-warning rounded p-3" action="/reservations/submit_reservation_equip_form" method="POST">
        <div class="form-group">
            <p>What do you want to reserve?</p>
            <?php 
            $i=1; 
            foreach($equips as $equip) {   ?>

                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="customRadio<?= $i; ?>" name="item" value="<?= $equip['id'] ?>">
                    <label class="custom-control-label" for="customRadio<?= $i; ?>"><?= $equip['name'] ?></label>
                </div>

            <?php  
            $i++;
            } ?>         
        </div>
        <button id="search_equipment" class="btn btn-outline-info">Search</button>
    <div id="rest"></div>
    </form>
</div>



<script src="/js/reservations.js"></script>
