// Add new item
$("#new_item_btn").click(function(e){
    e.preventDefault();
    console.log("submitted");
    $.ajax({
        method: "POST",
        url: "/items/create",
        data: {
            "name" : $("#item_name").val(),
            "type" : $("#item_type").val(),
            "description" : $("#item_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> New item created.</div>');
            $('.modal-backdrop').remove();
        } else {
            $("#messages").html(response);
        }
    })
})

// Load item edit view
$(".item-edit").click(function()
{
    console.log($(this).attr("data-id"));
    $.ajax({
        method: "POST",
        url: "/items/edit",
        data: {
            "item_id" : $(this).attr("data-id")
        }
    })
    .done(function(response) {
        $("#table").html(response);
    });
})

// Edit exisitng item