$(".btn-options").click(function()
{
    $(".btn-options").addClass('btn-outline-info').removeClass('btn-info');
    $.ajax({
        method: "POST",
        url: "/admin/show_view",
        data: {
            "name" : $(this).attr("data-name")
        }
    })
    .done(function(response) {
        $("#table").html(response);
    });
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})