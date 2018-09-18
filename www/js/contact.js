

$("form").on("submit", function(e) {
    e.preventDefault();
    let formData = $(this).serializeArray();

    $.ajax({
        method: "POST",
        url: "/contact/process_form",
        data: {form_data : formData}
    })
    .done(function(data) {
        console.log($(this)[0].data);
        $("#message").html(data);
    })
  });