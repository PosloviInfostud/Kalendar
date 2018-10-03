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
            "name" : $("#user_name").val(),
            "email" : $("#user_email").val(),
            // "password" : $("#register_password").val(),
            // "password_confirm" : $("#register_password_confirm").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            window.location.href = "/users"
        } else {
            $("#messages").html(response);
        }
    })
})