//show reservation forms

$(".btn-options").click(function(){
    $.ajax({
        method: "POST",
        url: "/reservations/show_form",
        data: {
            "name" : $(this).attr("data-name")
        }
    })
    .done(function(response){
        $("#show").html(response);
    })
})

//load flatpickr

$("#datetime_start, #datetime_end").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});

//send ajax search request for free rooms

$("#search_reserved_offices").click(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/search_free_rooms",
        data: {
            "start_time" : $("#datetime_start").val(),
            "end_time" : $("#datetime_end").val(),
            "attendants" : $("#attendants").val()
        }
    })
    .done(function(response){
        console.log(response);
        $("#free").html(response);
    })
})

//send ajax requests for equipment type needed

$("#search_equipment").click(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/search_free_equipment",
        data: {
            "start_time" : $("#datetime_start").val(),
            "end_time" : $("#datetime_end").val(),
            "equipment_type" :  $(".radio_equipment:checked").val()
        }
    })
    .done(function(response){
        console.log(response);
        $("#rest").html(response);
    })
})

//send ajax search request for free schedule for sepecific room

$("select.select_room").change(function(e){
    $.ajax({
        method: "POST",
        url: "/reservations/load_calendar_for_room",
        data: {
            "room" : $(".select_room option:selected").val()
        }
    })
    .done(function(response){
        console.log(response);
        $("#show").html(response);
    })
})

//search free termins for specific rooms

$("#search_free_termins").click(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/search_free_termins_for_specific_room",
        data: {
            "start_time" : $("#datetime_start").val(),
            "end_time" : $("#datetime_end").val(),
            "room_id" : $("#room_id").val()
        }
    })
    .done(function(response){
        $("#freeornot").html(response);
    })
})

//submit reservation form

$("body").on('click', "#reservation_submit", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/submit_reservation_form",
        data: {
            "start_time" : $("#datetime_start").val(),
            "end_time" : $("#datetime_end").val(),
            "room" : $("input[name='room']:checked").val(),
            "title" : $("#reservation_name").val(),
            "description" : $("#reservation_description").val(),
            "members" : $("#members").val()
        }
    })
    .done(function(response){
        $("#show_errors").html(response);
    })
})



