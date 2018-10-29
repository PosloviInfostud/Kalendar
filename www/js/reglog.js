// Mobile menu
$("#phone_menu_btn").on("click", function () {
    $("#secondary_nav").slideToggle();
});

// Modal function
$("#load-modal, #close-modal").on('click', function () {
    $("#modal").toggle('slow');
});

// Show register form
$('*[data-link="register"]').click(function() {
    $("#alert_box").hide();
    $('*[data-section="login"]').addClass("hidden");
    $('*[data-section="forgot"]').addClass("hidden");
    $('*[data-section="register"]').removeClass("hidden");
})

// Show login form
$('*[data-link="login"]').click(function() {
    $("#alert_box").hide();
    $('*[data-section="register"]').addClass("hidden");
    $('*[data-section="forgot"]').addClass("hidden");
    $('*[data-section="login"]').removeClass("hidden");
})

// Show forgot password form
$('*[data-link="forgot"]').click(function() { 
    $("#alert_box").hide();
    $('*[data-section="register"]').addClass("hidden");
    $('*[data-section="login"]').addClass("hidden");
    $('*[data-section="forgot"]').removeClass("hidden");
})

// Close the alert box
$("#close_alert").on('click', function () {
    $("#alert_box").fadeToggle('slow');
});

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
            $("#alert_box").hide();

            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#register_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
                $("#alert_box").fadeToggle();
            }
        })
})

//Login user
$("#login_form").submit(function (e) {
    e.preventDefault();
    $(".error_box").empty();
    $("#alert_box").hide();
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
            if (response['status'] == 'success') {
                window.location.href = "/dashboard";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#login_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
                $("#alert_box").fadeToggle();
            }
        })
})

//Send forgot password mail
$("#forgot_form").submit(function (e) {
    $(".error_box").empty();
    $("#alert_box").hide();
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
            $("#alert_box").hide();
            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#forgot_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
                $("#alert_box").fadeToggle();
            }
        })
})

//Reset password form submit
$("#form_reset_password").submit(function (e) {
    $(".error_box").empty();
    $("#alert_box").hide();
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
            $(".error_box").empty();
            $("#alert_box").hide();
            if (response['status'] == 'success') {
                window.location.href = "/login";
            } else if (response['status'] == 'form_error') {
                for (var key in response['errors']) {
                    $("#reset_" + key + "_err").html(response['errors'][key])
                }
            } else {
                $("#messages").html(response['errors']);
                $("#alert_box").fadeToggle();
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

// Edit user notifications checkboxes
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

