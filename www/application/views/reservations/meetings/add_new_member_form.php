<h3 class="font-light mb-2">Who do you want to invite?</h3>
<form id="add_new_member_form">
    <div class="form-group">
        <select class="js-example-basic-multiple w-full p-2 my-2 rounded" name="members[]" id="members" multiple="multiple">

        <?php foreach($users as $user) { ?>
            <option class="d-block" value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?> 

        </select>
    </div>
    <input type="hidden" name="res_id" id="res_id" value="<?= $res_id ?>">
</form>
<button type="submit" form="add_new_member_form" value="Submit" class="bg-primary-light hover:bg-primary text-grey-darkest text-white font-bold w-full py-2 mt-2 border border-primary-light rounded">
    Invite
</button>

<script>
//load select2 plugin - multiple
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
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
    });
});
</script>