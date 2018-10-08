    <p>Which room do you want to reserve? These ones are available: </p>
    <?php 
    $i=1; 
    foreach($rooms as $room) {   ?>

        <div class="custom-control custom-radio">
            <input type="radio" id="customRadio<?= $i; ?>" name="room" value="<?= $room['id'] ?>" class="custom-control-input" enabled>
            <label for="customRadio<?= $i; ?>" class="custom-control-label"><?= $room['name'] ?></label>
        </div>

    <?php  
    $i++;
    } ?> 
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
            <?php 
    $i=1; 
    foreach($users as $user) {   ?>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck<?= $i; ?>" name="members[]" value="<?= $user['id'] ?>">
            <label class="custom-control-label" for="customCheck<?= $i; ?>"><?= $user['name'] ?></label>
        </div>

    <?php  
    $i++;
    } ?>         
        </div>
        <input type="submit" name="submit" id="reservation_submit" class="btn btn-block btn-success" value="Reserve!">
