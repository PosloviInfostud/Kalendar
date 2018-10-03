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

// Update user
$("#update_user").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/update",
        data: {
            "id" : $("#user_id").val(),
            "name" : $("#user_name").val(),
            "email" : $("#user_email").val(),
            "role_id" : $("#user_role").val(),
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