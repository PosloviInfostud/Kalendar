$("#login_form").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/login",
        data: {
            "email" : $("#email").val(),
            "password" : $("#password").val()
        }
    })
    .done(function(response){

    })
})