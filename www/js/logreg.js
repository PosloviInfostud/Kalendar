$("#register_btn").click(function() {
    $("#login_form").addClass("hide");
    $("#register_form").removeClass("hide");
});
$("#login_btn").click(function() {
    $("#register_form").addClass("hide");
    $("#login_form").removeClass("hide");
});

$("#register_form").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
        method: "POST",
        url: "LoginRegister/register",
        data: {
            register_name : $("#register_name").val(),
            register_email : $("#register_email").val(),
            register_password : $("#register_password").val(),
            register_passconf : $("#register_passconf").val(),
            register_bday : $("#register_bday").val()
        }
    })
    .done(function(data) {
        $("#register_form")[0].reset();
        $("#message").html(data);
    })
  });

$("#login_form").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
        method: "POST",
        url: "LoginRegister/login",
        data: {
            login_email : $("#login_email").val(),
            login_password : $("#login_password").val()
        }
    })
    .done(function(data) {
        if(data === 'success') {
            window.location.href = "/"
        } else {
        $("#message").html(data);
        }
    })
  });