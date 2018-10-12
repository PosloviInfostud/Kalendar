<div id="show_errors"><?php echo validation_errors(); ?></div>

        <div class="form-group">
            <p>Which one do you want to reserve?</p>
            <?php
            $i = 99999;
            foreach($items as $item) { ?>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio<?= $i; ?>" name="equipment_id" value="<?= $item['id'] ?>" class="custom-control-input radio_equipment_id" enabled>
                    <label for="customRadio<?= $i; ?>" class="custom-control-label">
                        <h6><?= $item['name']; ?></h6>
                        <small> (Code: <?= $item['barcode']; ?>)</small><br>
                        <?= $item['description']; ?>
                    </label>
                </div>

            <?php
            $i++;
            } ?>
        
        </div>
        <div class="form-group">
            <label for="description">Why do you need it?</label>
            <textarea class="form-control" name="description" id="reservation_description"></textarea>
        </div>
        <input type="submit" name="submit" id="reservation_equipment_submit" class="btn btn-block btn-success" value="Reserve!">

