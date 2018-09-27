// Show registration form
$("#register_button").click(function () {
    $("#messages").empty();
    $("#login_form").addClass("hide");
    $("#register_form").removeClass("hide");
    $("#forgot_form").addClass("hide");
})

// Show login form
$("#login_button").click(function () {
    $("#messages").empty();
    $("#register_form").addClass("hide");
    $("#login_form").removeClass("hide");
    $("#forgot_form").addClass("hide");
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
        $("#register_form")[0].reset();
        $("#messages").html(response);
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
        $("#login_form")[0].reset();
        $("#messages").html(response);
    })
})

//Show Forgot Password form (to enter e-mail to send form for password reset
$("#forgot_button").click(function(){
    $("#login_form").addClass("hide");
    $("#register_form").addClass("hide");
    $("#forgot_form").removeClass("hide");
})