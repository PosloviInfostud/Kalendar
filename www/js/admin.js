$(".btn-options").click(function()
{
    $(".btn-options").addClass('btn-outline-info').removeClass('btn-info');
    // $("#table").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div></div>');
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