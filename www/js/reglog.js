// Show registration form
$("#register_button").click(function () {
    $("#messages").empty();
    $("#login_form").addClass("hide");
    $("#register_form").removeClass("hide");
    $("#forgot_form").addClass("hide");
    $("#welcome").addClass("hide");


})

// Show login form
$("#login_button").click(function () {
    $("#messages").empty();
    $("#register_form").addClass("hide");
    $("#login_form").removeClass("hide");
    $("#forgot_form").addClass("hide");
    $("#welcome").addClass("hide");

})

// Register user
$("#register_form").submit(function(e){
    e.preventDefault();
    console.log("submitted");
    $.ajax({
        method: "POST",
        url: "/reg_log/register",
        data: {
            "name" : $("#register_name").val(),
            "email" : $("#register_email").val(),
            "password" : $("#register_password").val(),
            "password_confirm" : $("#register_password_confirm").val()
        }
    })
    .done(function(response){
        msg = JSON.parse(response);
        if(msg.success === 'success') {
            window.location.href = "/login"
        } else {
            $("#messages").html(msg.error);
        }
    })
})

//Login user
$("#login_form").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reg_log/login",
        data: {
            "email" : $("#login_email").val(),
            "password" : $("#login_password").val()
        }
    })
    .done(function(response){
        if(response == "success") {
            window.location.href = "/dashboard";

        } else {
            $("#messages").html(response);
        }
    })
})

//Show Forgot Password form (to enter e-mail to send form for password reset)
$("#forgot_button").click(function(){
    $("#login_form").addClass("hide");
    $("#register_form").addClass("hide");
    $("#forgot_form").removeClass("hide");
        $("#welcome").addClass("hide");

})

//Send forgot password mail

$("#forgot_form").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reg_log/send_forgot_password_mail",
        data: {
            "email" : $("#forgot_email").val()
        }
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#forgot_messages").html(msg.error);
        }
        if(msg.success) {
            $("#forgot_messages").html(msg.success);
            $("#forgot_input").addClass("hide");
            }

     })
})

//Reset password form submit

$("#form_reset_password").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reg_log/reset_password",
        data: {
            "email" : $("#reset_password_email").val(),
            "password" : $("#reset_password_password").val(),
            "confirm" : $("#reset_password_confirm").val(),
            "code" : $("#reset_password_code").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            window.location.href = "/login"
        } else {
            $("#msgs").html(response);
        }

    })
})

// Register user
$("#register_by_invite_form").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reg_log/register_by_invitation",
        data: {
            "name" : $("#register_name").val(),
            "email" : $("#register_email").val(),
            "password" : $("#register_password").val(),
            "password_confirm" : $("#register_password_confirm").val(),
            "token" : $("#token").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            window.location.href = "/login"
        } else {
            $("#messages").html(response);
        }
    })
})

//edit user notifications show form modal

$("body").on('click', '#change_notification', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/show_change_notifications_form",
        data: {
            'id': $(this).attr("data-user"),
            'notify' : $(this).attr("data-notify")
        }
    }).done(function(response){
        $('#notify_modal_body').html(response);
        // show modal
        $('#notifyModal').modal('show');   
    })
})

//edit user notifications form submit

$("body").on('submit','#update_notifications_form', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/change_notifications",
        data: {
            "notify": $("#update_notifications_form_notify").val(),
            "user_id" : $("#update_notifications_form_user_id").val()
        }

    }).done(function(response){
        location.reload();
    })
})