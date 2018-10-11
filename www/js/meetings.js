$("body").on('click', ".members-btn", function() {
    $('#MembersModal').modal('show');
    $.ajax({
        method: "POST",
        url: "/reservations/get_reservation_members",
        data: {
            "reservation_id" : $(this).attr("data-id")
        }
    })
    .done(function(response){
        $("#show_members_body").html(response);
    })
})