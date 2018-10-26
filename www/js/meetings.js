// Show members of a meeting
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

// Single meeting view modal
$("body").on('click', ".meeting-view", function() {
    $('#MeetingModal').modal('show');
    $.ajax({
        method: "POST",
        url: "/reservations/single_room_reservation",
        data: {
            "reservation_id" : $(this).attr("data-id")
        }
    })
    .done(function(response) {
            $('#show_meeting_body').html(response);
    });
})

$(document).ready(function(){
    $("#filter_list_input").on("keyup", function() {
      let value = $(this).val().toLowerCase();
      $(".reservation_boxes").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });