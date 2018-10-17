    <div id="show_errors"><?php echo validation_errors(); ?></div>
    <p>Which room do you want to reserve? These ones are available: </p>
    <?php 
    if(empty($rooms)) { ?>
        <p class="bg-danger">No free rooms for this time. Try again. </p>
        <?php
    } else {
        $i=1; 
        foreach($rooms as $room) { ?>
    
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio<?= $i; ?>" name="room" value="<?= $room['id'] ?>" class="custom-control-input room_radio" enabled>
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

    
            <div class="form-group">
                <select class="js-example-basic-multiple form-control" name="members[]" id="members" multiple="multiple">

                <?php foreach($users as $user) { ?>
                    <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
                <?php  } ?> 

                </select>
            </div>
    
        
            </div>
            <input type="submit" name="submit" id="reservation_room_submit_by_date" class="btn btn-block btn-success" value="Reserve!">

    <?php 
    }
    ?>
    <script type="text/javascript">

    $(document).ready(function() {
    $('.js-example-basic-multiple').select2(
        {
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                var count = 0
                var existsVar = false;
                //check if there is any option already
                if($('#keywords option').length > 0){
                    $('#keywords option').each(function(){
                        if ($(this).text().toUpperCase() == term.toUpperCase()) {
                            existsVar = true
                            return false;
                        }else{
                            existsVar = false
                        }
                    });
                    if(existsVar){
                        return null;
                    }
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
                //since select has 0 options, add new without comparing
                else{
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
            },
            maximumInputLength: 50, // only allow terms up to 20 characters long
            closeOnSelect: true
        }
    );
});


</script>
