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

//load select2 plugin

$(document).ready(function() {
    $('.js-example-basic-single').select2();

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

//send ajax search request for free schedule for specific room
$("select.select_room").change(function(e){
    room = $(".select_room option:selected").val();
    console.log(room);
    $.ajax({
        method: "POST",
        url: "/reservations/load_calendar_for_room",
        data: {
            "room" : room
        }
    })
    .done(function(response){
        $("#show").html(response);
    })
})

//get value from room radio button
var room;
$("body").on('change click', "input.room_radio", function(e) {
    room = $(this).val();
    console.log(room);
})

//submit room reservation form

$("body").on('click', "#reservation_room_submit_by_date", function(e) {
    e.preventDefault();
    data = {};
    data.start_time = $("#datetime_start").val();
    data.end_time =  $("#datetime_end").val();
    data.room =  room;
    data.title = $("#reservation_name").val();
    data.description = $("#reservation_description").val();
    data.members = $("#members").val();
    submit_room_reservation(data);
})

$("body").on('click', "#reservation_room_submit_by_room", function(e) {
    e.preventDefault();
    data = {};
    data.start_time = $("#datetime_start").val();
    data.end_time =  $("#datetime_end").val();
    data.room =  room;
    data.title = $("#reservation_name").val();
    data.description = $("#reservation_description").val();
    data.members = $("#members").val();
    submit_room_reservation(data);
})

function submit_room_reservation(data) {
    $.ajax({
        method: "POST",
        url: "/reservations/submit_reservation_form",
        data: data
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#show_errors").html(msg.error);
        }
        if(msg.success) {
            window.location.href = "/dashboard";
        }
    })
}

//send ajax search request for free schedule for specific item
$("select.select_item").change(function(e){
    item = $(".select_item option:selected").val();
    console.log(item);
    $.ajax({
        method: "POST",
        url: "/reservations/load_calendar_for_item",
        data: {
            "equipment_id" : item
        }
    })
    .done(function(response){
        $("#show").html(response);
    })
})


//submit equipment reservation form
function submit_equipment_reservation(data) {
    $.ajax({
        method: "POST",
        url: "/reservations/submit_reservation_equip_form",
        data: data
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#show_errors").html(msg.error);
        }
        if(msg.success) {
            window.location.href = "/dashboard";
        }
    })
}

$("body").on('click', "#reservation_equipment_submit_by_date", function(e) {
    e.preventDefault();
    data =  {};
    data.start_time =  $("#datetime_start").val();
    data.end_time =  $("#datetime_end").val();
    data.description =  $("#reservation_description").val();
    data.equipment_id =  $(".radio_equipment_id:checked").val();
    submit_equipment_reservation(data);
    })

$("body").on('click', "#reservation_equipment_submit_by_item", function(e) {
    e.preventDefault();
    data =  {};
    data.start_time =  $("#datetime_start").val();
    data.end_time =  $("#datetime_end").val();
    data.description =  $("#reservation_description").val();
    data.equipment_id =  $(".select_item option:selected").val();
    submit_equipment_reservation(data);
    })