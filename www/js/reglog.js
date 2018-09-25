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
            "name" : $("#name").val(),
            "email" : $("#email").val(),
            "password" : $("#password").val(),
            "password_confirm" : $("#password_confirm").val()
        }
    })
    .done(function(response){
    })
})