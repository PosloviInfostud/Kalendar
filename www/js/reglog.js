// Show registration form
$("#register_button").click(function () {
    $("#login_form").addClass("hide");
    $("#register_form").removeClass("hide");
})

// Show login form
$("#login_button").click(function () {
    $("#register_form").addClass("hide");
    $("#login_form").removeClass("hide");
})

// Register user
$("#register_form").click(function(e){
    e.preventDefault();
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
    })
})