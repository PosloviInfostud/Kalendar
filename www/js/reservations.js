
$(document).ready(function() {
/* Flatpickr */

// Load flatpickr for room reservations
let fpRoomStartDate = $("#datetime_start").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    // defaultDate: new Date(),
    enableTime: true,
    time_24hr: true,
    minTime: "08:00",
    maxTime: "18:00",
    altInput: true,
    altInputClass: '',
    altFormat: "D @ H:i (d/n)",
    onOpen: [function(dateStr, dateObj) {
        this.set("defaultDate", new Date());
    }],
    onChange: [function(dateStr, dateObj) {
            fpRoomEndDate.set("minDate", dateObj);
    }]
});

let fpRoomEndDate = $("#datetime_end").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    enableTime: true,
    noCalendar: true,
    time_24hr: true,
    minTime: "08:00",
    maxTime: "18:00",
    altInput: true,
    altInputClass: '',
	altFormat: "H:i",
});

// Load flatpickr for equipment reservations
let fpItemStartDate = $("#item_datetime_start").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    // defaultDate: new Date(),
    enableTime: true,
    time_24hr: true,
    altInput: true,
    altInputClass: '',
    altFormat: "d/m/y @ H:i",
    onOpen: [function(dateStr, dateObj) {
        this.set("defaultDate", new Date());
    }],
    onChange: [function(dateStr, dateObj) {
            fpItemEndDate.set("minDate", dateObj);
    }]
});

let fpItemEndDate = $("#item_datetime_end").flatpickr({
    dateFormat: "Y-m-d H:i",
    minDate: new Date(),
    enableTime: true,
    time_24hr: true,
    altInput: true,
    altInputClass: '',
	altFormat: "d/m/y @ H:i",
});});

//load select2 plugin - multiple
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2(
                {
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                var count = 0
                var existsVar = false;
                //check if there is any option already
                if($('#keywords option').length > 0){
                    $('#keywords option').each(function(){
                        if ($(this).text().toUpperCase() == term.toUpperCase()) {
                            existsVar = true
                            return false;
                        }else{
                            existsVar = false
                        }
                    });
                    if(existsVar){
                        return null;
                    }
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
                //since select has 0 options, add new without comparing
                else{
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
            },
            maximumInputLength: 50, // only allow terms up to 50 characters long
            closeOnSelect: true
        }

    );

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

//load update user reservation role form modal

$("body").on('click','.role_edit', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/show_update_user_role_form",
        data: {
            user_id: $(this).attr("data-user"),
            res_id: $(this).attr("data-res"),
            name: $(this).attr("data-name"),
            role_id: $(this).attr("data-roleid"),
            role_name: $(this).attr("data-rolename"),
            creator : $(this).attr("data-creator")

        }
    }).done(function(response) {
        $('#edit_user_role_modal_body').html(response);
        // show modal
        $('#editUserRoleModal').modal('show');    
    })
})

//submit update user reservation role

$("body").on('submit', '#update_user_role_form', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/update_user_role",
        data: {
            "res_id" : $("#update_user_role_form_res_id").val(),
            "user_id" : $("#update_user_role_form_user_id").val(),
            "res_role_id" : $("#select_role").val(),
            "creator" : $("#update_user_role_form_creator").val()
        }
    }).done(function(response){
        location.reload();
    })
})

//click on delete reservation member button

$("body").on('click', '.member_delete', function(e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this user from this meeting? Notification email will be sent.")) {
        return false;
    } else {
        $.ajax({
            method: "POST",
            url: "/reservations/delete_res_member",
            data: {
                "res_id" : $(this).attr("data-res"),
                "user_id" : $(this).attr("data-user"),
                "creator" : $(this).attr("data-creator")
            }
        }).done(function(response){
            msg = JSON.parse(response);
            if(msg.error) {
                $("#del_error_msg").html(msg.error);
            } else {
                location.reload();
            }
        })
    }
})

//add new member show form modal

$("body").on('click', '#btn_add_new_member', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/show_add_new_member_form",
        data: {
            'res_id': $(this).attr("data-res")
        }
    }).done(function(response){
        $('#add_member_modal_body').html(response);
        // show modal
        $('#addMemberModal').modal('show');   
    })
})

//add new member form submit

$("body").on('submit','#add_new_member_form', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/add_new_member",
        data: {
            "members": $("#members").val(),
            "res_id" : $("#res_id").val()
        }

    }).done(function(response){
        console.log(response);
    })
})

//submit reservation update form

$("#form_update_room_reservation").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/update_room_reservation",
        data: {
            start_time : $("#datetime_start").val(),
            end_time :  $("#datetime_end").val(),
            room : $(".select_room option:selected").val(),
            title : $("#reservation_name").val(),
            description : $("#reservation_description").val(),
            res : $("#res").val()
        }
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#show_errors").html(msg.error);
        }
        if(msg.success) {
            window.location.href = "/reservations/meetings/"+msg.success;
        }
    })
})

//confirm delete reservation

$("#del_res_btn").click(function(){
    if (!confirm("Are you sure you want to delete this reservation? Notification email will be sent.")) {
        return false;
    }   
});

//load update equipment form modal

$("body").on('click','#edit_equip_btn', function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/show_update_equip_form",
        data: {
            equip: $(this).attr("data-equip")
        }
    }).done(function(response) {
        $('#edit_equip_modal_body').html(response);
        // show modal
        $('#editEquipModal').modal('show');    
    })
})

//submit equipment update form

$("#update_equipment_submit").click(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/update_equipment",
        data: {
            start_time : $("#item_datetime_start").val(),
            end_time :  $("#item_datetime_end").val(),
            description : $("#reservation_description").val(),
            equip_id : $("#equip_id").val(),
            res_id : $("#res_id").val()
        }
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#show_errors").html(msg.error);
        }
        if(msg.success) {
            window.location.href = "/reservations/equipment/"+msg.success;
        }
    })
})

//confirm delete equipment reservation

$("#delete_equip_btn").click(function(){
    if (!confirm("Are you sure you want to delete this reservation?")) {
        return false;
    }   
});