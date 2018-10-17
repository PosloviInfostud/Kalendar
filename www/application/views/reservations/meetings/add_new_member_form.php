<div class="container">
    <form id="add_new_member_form">
            <p>Who do you want to invite?</p>
            <div class="form-group">
            <select class="js-example-basic-multiple form-control" name="members[]" id="members" multiple="multiple">

            <?php foreach($users as $user) { ?>
                <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
            <?php  } ?> 

            </select>
        </div>
    </form>
</div>
<script>
//load select2 plugin - multiple
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
            maximumInputLength: 50, // only allow terms up to 50 characters long
            closeOnSelect: true
        }

    );

});

</script>