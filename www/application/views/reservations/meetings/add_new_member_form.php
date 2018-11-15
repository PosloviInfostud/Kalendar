<h3 class="pl-2 py-1 font-light text-lg sm:text-xl border-l-4 mb-6 border-primary">Koga želite da pozovete na sastanak?</h3>
<form id="add_new_member_form">
    <div class="form-group">
        <select class="js-example-basic-multiple w-full my-2 rounded" name="members[]" id="members" multiple="multiple">
        <?php if(empty($users)) { ?>
            No results
        <?php } else { ?> 
            <?php foreach($users as $user) { ?>
            <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?> 
        <?php } ?>

        </select>
    </div>
    <input type="hidden" name="res_id" id="res_id" value="<?= $res_id ?>">
</form>
<button type="submit" form="add_new_member_form" value="Submit" class="bg-primary hover:bg-primary-dark text-grey-darkest text-white w-full py-2 mt-2 border border-primary-light rounded">
    Pozovi
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