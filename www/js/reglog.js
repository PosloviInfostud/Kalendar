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
$("#register_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
            method: "POST",
            url: "/reg_log/register",
            data: {
                "name": $("#register_name").val(),
                "email": $("#register_email").val(),
                "password": $("#register_password").val(),
                "password_confirm": $("#register_password_confirm").val()
            }
        })
        .done(function (response) {
            $(".error_box").empty();
            $("#messages").empty();
            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#register_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
            }
        })
})

//Login user
$("#login_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
            method: "POST",
            url: "/reg_log/login",
            data: {
                "email": $("#login_email").val(),
                "password": $("#login_password").val()
            }
        })
        .done(function (response) {
            $(".error_box").empty();
            $("#messages").empty();
            if (response['status'] == 'success') {
                window.location.href = "/dashboard";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#login_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
            }
        })
})

//Show Forgot Password form (to enter e-mail to send form for password reset)
$("#forgot_button").click(function () {
    $("#login_form").addClass("hide");
    $("#register_form").addClass("hide");
    $("#forgot_form").removeClass("hide");
    $("#welcome").addClass("hide");
})

//Send forgot password mail
$("#forgot_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
            method: "POST",
            url: "/reg_log/send_forgot_password_mail",
            data: {
                "email": $("#forgot_email").val()
            }
        })
        .done(function (response) {
            $(".error_box").empty();
            $("#messages").empty();
            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#forgot_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
            }
        })
})

//Reset password form submit
$("#form_reset_password").submit(function (e) {
    e.preventDefault();
    $.ajax({
            method: "POST",
            url: "/reg_log/reset_password",
            data: {
                "email": $("#reset_password_email").val(),
                "password": $("#reset_password_password").val(),
                "confirm": $("#reset_password_confirm").val(),
                "code": $("#reset_password_code").val()
            }
        })
        .done(function (response) {
            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#reset_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
            }
        })
})

// Register user
$("#register_by_invite_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
            method: "POST",
            url: "/reg_log/register_by_invitation",
            data: {
                "name": $("#register_name").val(),
                "email": $("#register_email").val(),
                "password": $("#register_password").val(),
                "password_confirm": $("#register_password_confirm").val(),
                "token": $("#token").val()
            }
        })
        .done(function (response) {
            if (response === 'success') {
                window.location.href = "/login"
            } else {
                $("#messages").html(response);
            }
        })
})

//edit user notifications checkboxes

$(".notify").change(function(){
    if($(this).is(":checked")) {
        value = 1;
    } else {
        value = 0;
    }
    $.ajax({
        method: "POST",
        url: "/users/change_notifications",
        data: {
            column: $(this).attr("name"),
            value: value,
            user_id: $(this).attr("data-user")
        }
    }).done(function(response){
        console.log(response);
    })
})

