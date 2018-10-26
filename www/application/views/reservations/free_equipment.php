<?php if(empty($items)) { ?>
    <div class="alert alert-warning">Sorry, nothing is available at the moment! Check again!</div>
<?php }  else { ?>
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
        <input type="submit" name="submit" id="reservation_equipment_submit_by_date" class="btn btn-block btn-success" value="Reserve!">
<?php }     ?>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="equip_reservation_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirm Update</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="reservation_equipment_submit_by_date_modal-btn-yes">Yes</button>
        <button type="button" class="btn btn-default" id="reservation_equipment_submit_by_date_modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<script src="/js/reservations.js"></script>
