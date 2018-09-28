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
        url: "/users/register",
        data: {
            "name" : $("#register_name").val(),
            "email" : $("#register_email").val(),
            "password" : $("#register_password").val(),
            "password_confirm" : $("#register_password_confirm").val()
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

//Login user
$("#login_form").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/login",
        data: {
            "email" : $("#login_email").val(),
            "password" : $("#login_password").val()
        }
    })
    .done(function(response){
        if(response == "success") {
            $("#register_form").addClass("hide");
            $("#login_form").addClass("hide");
            $("#forgot_form").addClass("hide");
            window.location.href = "/users";

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
        url: "/users/send_forgot_password_mail",
        data: {
            "email" : $("#forgot_email").val()
        }
    })
    .done(function(response){
        $("#messages").html(response);   
     })
})

//Reset password form submit

$("#form_reset_password").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/reset_password",
        data: {
            "email" : $("#reset_password_email").val(),
            "password" : $("#reset_password_password").val(),
            "confirm" : $("#reset_password_confirm").val(),
            "code" : $("#reset_password_code").val()
        }
    })
    .done(function(response){
        $("#msgs").html(response);
    })
})