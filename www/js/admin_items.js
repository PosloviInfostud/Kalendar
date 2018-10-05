// Add new item
$("#new_item_btn").click(function(e){
    e.preventDefault();
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
    $(this).unbind('click');
})

// Load item edit view (non-modal solution)

// $(".item-edit").click(function()
// {
//     console.log($(this).attr("data-id"));
//     $.ajax({
//         method: "POST",
//         url: "/items/edit",
//         data: {
//             "item_id" : $(this).attr("data-id")
//         }
//     })
//     .done(function(response) {
//         $("#table").html(response);
//     });
// })

// Load item edit modal
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
            $('#edit_item_modal_body').html(response);

            // show modal
            $('#editItemModal').modal('show');
    });
})

// Update exisitng item
$("#update_item_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update",
        data: {
            "id" : $("#update_item_id").val(),
            "name" : $("#update_item_name").val(),
            "type" : $("#update_item_type").val(),
            "description" : $("#update_item_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> Item updated.</div>');
            $('.modal-backdrop').remove();
        } else {
            $("#messages").html(response);
        }
    })
    // $(this).unbind('submit');
})