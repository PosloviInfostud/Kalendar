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
$("#register_form").submit
(function(e){
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

    })
})