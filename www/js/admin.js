$(".btn-options").click(function()
{
    $(".btn-options").addClass('btn-outline-info').removeClass('btn-info');
    $.ajax({
        method: "POST",
        url: "/admin/show_view",
        data: {
            "name" : $(this).attr("data-name")
        }
    })
    .done(function(response) {
        $("#table").html(response);
    });
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

// Load user edit view
$(".user-edit").click(function()
{
    console.log($(this).attr("data-id"));
    $.ajax({
        method: "POST",
        url: "/users/edit",
        data: {
            "user_id" : $(this).attr("data-id")
        }
    })
    .done(function(response) {
        $("#table").html(response);
    });
})

// Edit exisitng user
$("#update_user").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/update",
        data: {
            "id" : $("#user_id").val(),
            "name" : $("#user_name").val(),
            "email" : $("#user_email").val(),
            "role_id" : $("#select_role").val(),
            "active" : $("#select_active").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> User updated.</div>');
        } else {
            $("#messages").html(response);
        }
    })
})

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