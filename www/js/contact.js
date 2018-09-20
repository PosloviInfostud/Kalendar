$("form").on("submit", function (e) {
    e.preventDefault();
    let formData = $(this).serializeArray();

    $.ajax({
            method: "POST",
            url: "/contact/process_form",
            data: {
                // form_data : formData,
                contact_name: $("#contact_name").val(),
                contact_email: $("#contact_email").val(),
                contact_message: $("#contact_message").val()
            }
        })
        .done(function (data) {
            let response = JSON.parse(data);
            console.log(response);
            if (response.status) {
                $("#message").removeClass().addClass('alert alert-success');
                $("#contact-form")[0].reset();
            } else {
                $("#message").removeClass().addClass('alert alert-danger');
            }
            $("#message").html(response.status_message);
            $("#message").show();
            $("#contact_name_err").html(response.contact_name);
            $("#contact_email_err").html(response.contact_email);
            $("#contact_message_err").html(response.contact_message);
        })
});
$("form").on("submit", function (e) {
    e.preventDefault();
    let formData = $(this).serializeArray();

    $.ajax({
            method: "POST",
            url: "/contact/process_form",
            data: {
                // form_data : formData,
                contact_name: $("#contact_name").val(),
                contact_email: $("#contact_email").val(),
                contact_message: $("#contact_message").val()
            }
        })
        .done(function (data) {
            let response = JSON.parse(data);
            console.log(response);
            if (response.status) {
                $("#message").removeClass().addClass('alert alert-success');
                $("#contact-form")[0].reset();
            } else {
                $("#message").removeClass().addClass('alert alert-danger');
            }
            $("#message").html(response.status_message);
            $("#message").show();
            $("#contact_name_err").html(response.contact_name);
            $("#contact_email_err").html(response.contact_email);
            $("#contact_message_err").html(response.contact_message);
        })
});