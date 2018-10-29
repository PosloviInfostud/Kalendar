
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
    defaultDate: new Date(),
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
            "start_time" : $("#item_datetime_start").val(),
            "end_time" : $("#item_datetime_end").val(),
            "equipment_type" :  $(".radio_equipment:checked").val()
        }
    })
    .done(function(response){
        $("#rest").html(response);
    })
})

//send ajax search request for free schedule for specific room
$("select.select_room").change(function(e){
    room = $(".select_room option:selected").val();
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
})


//===============================================================================
//submit room reservation form 

    //search by date

var confirmRoomReservationByDate = function(callback){
  
    $("body").on('click', "#reservation_room_submit_by_date", function(e) {
        e.preventDefault();
        data = {};
        data.start_time = $("#datetime_start").val();
        data.end_time =  $("#datetime_end").val();
        data.room =  room;
        data.title = $("#reservation_name").val();
        data.description = $("#reservation_description").val();
        data.members = $("#members").val();

        $("#room_reservation_modal").modal('show');
        $("#modal-body").html(
            "Start: "+$("#datetime_start").val()+
            "<br>End: "+$("#datetime_end").val()+
            "<br>Room: "+room+
            "<br>Title: "+$("#reservation_name").val()+
            "<br> Description: "+$("#reservation_description").val()+
            "<br>Invited: "+$("#members").val())
    });
  
    $("body").on("click", "#reservation_room_submit_by_date_modal-btn-yes", function(){
      callback(true, data);
      $("#room_reservation_modal").modal('hide');
    });
    
    $("body").on("click", "#reservation_room_submit_by_date_modal-btn-no", function(){
        callback(false, data);
      $("#room_reservation_modal").modal('hide');
    });
};

confirmRoomReservationByDate(function(confirm, data) {
    if(confirm) {
        submit_room_reservation(data);
    } else {
        return false;
    }
})

    //search by free room

var confirmRoomReservationByRoom = function(callback){

    $("body").on('click', "#reservation_room_submit_by_room", function(e) {
        e.preventDefault();
        data = {};
        data.start_time = $("#datetime_start").val();
        data.end_time =  $("#datetime_end").val();
        data.room =  room;
        data.title = $("#reservation_name").val();
        data.description = $("#reservation_description").val();
        data.members = $("#members").val();

        $("#room_reservation_modal").modal('show');
        $("#modal-body").html(
            "Start: "+$("#datetime_start").val()+
            "<br>End: "+$("#datetime_end").val()+
            "<br>Room: "+room+
            "<br>Title: "+$("#reservation_name").val()+
            "<br> Description: "+$("#reservation_description").val()+
            "<br>Invited: "+$("#members").val())
    });
    
    $("body").on("click", "#reservation_room_submit_by_room_modal-btn-yes", function(){
        callback(true, data);
        $("#room_reservation_modal").modal('hide');
    });
    
    $("body").on("click", "#reservation_room_submit_by_room_modal-btn-no", function(){
        callback(false, data);
        $("#room_reservation_modal").modal('hide');
    });
};

confirmRoomReservationByRoom(function(confirm, data) {
    if(confirm) {
        submit_room_reservation(data);
    } else {
        return false;
    }
})

    //sending AJAX

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
            window.location.href = "/reservations/meetings";
        }
    })
}
//==============================================================================

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

//===================================================================================
//submit equipment reservation form

    //sending AJAX

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

    //search by date

var confirmEquipReservationByDate = function(callback) {

    $("body").on('click', "#reservation_equipment_submit_by_date", function(e) {
        e.preventDefault();
        data =  {};
        data.start_time =  $("#item_datetime_start").val();
        data.end_time =  $("#item_datetime_end").val();
        data.description =  $("#reservation_description").val();
        data.equipment_id =  $(".radio_equipment_id:checked").val(); 

        $("#equip_reservation_modal").modal('show');
        $("#modal-body").html(
            "Start: "+$("#item_datetime_start").val()+
            "<br>End: "+$("#item_datetime_end").val()+
            "<br> Description: "+$("#reservation_description").val())
    });

    $("body").on("click", "#reservation_equipment_submit_by_date_modal-btn-yes", function(){
        callback(true, data);
        $("#equip_reservation_modal").modal('hide');
      });
      
      $("body").on("click", "#reservation_equipment_submit_by_date_modal-btn-no", function(){
          callback(false, data);
        $("#equip_reservation_modal").modal('hide');
      });
}

confirmEquipReservationByDate(function(confirm, data) {
    if(confirm) {
        submit_equipment_reservation(data);
    } else {
        return false;
    }
})

    //search by specific item

var confirmEquipReservationByItem = function(callback) {

    $("body").on('click', "#reservation_equipment_submit_by_item", function(e) {
        e.preventDefault();
        data =  {};
        data.start_time =  $("#item_datetime_start").val();
        data.end_time =  $("#item_datetime_end").val();
        data.description =  $("#reservation_description").val();
        data.equipment_id =  $(".select_item option:selected").val(); 

        $("#equip_reservation_modal").modal('show');
        $("#modal-body").html(
            "Start: "+$("#item_datetime_start").val()+
            "<br>End: "+$("#item_datetime_end").val()+
            "<br> Description: "+$("#reservation_description").val())
    });

    $("body").on("click", "#reservation_equipment_submit_by_item_modal-btn-yes", function(){
        callback(true, data);
        $("#equip_reservation_modal").modal('hide');
        });
        
        $("body").on("click", "#reservation_equipment_submit_by_item_modal-btn-no", function(){
            callback(false, data);
        $("#equip_reservation_modal").modal('hide');
        });
}

confirmEquipReservationByItem(function(confirm, data) {
    if(confirm) {
        submit_equipment_reservation(data);
    } else {
        return false;
    }
})

//===========================================================================================
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

//=====================================================================================================
//click on delete reservation member button

var deleteMemberConfirmModal = function(callback) {
    
    $("body").on('click', '.member_delete', function(e) {
        e.preventDefault();
        data = {};
        data.res_id = $(this).attr("data-res");
        data.user_id = $(this).attr("data-user");
        data.creator = $(this).attr("data-creator");
        $("#delete_member_confirm_modal").modal("show");
        $("#delete_member_confirm_modal-body").html(
            "Are you sure you want to remove this member from meeting?"
        )
    });

    $("body").on("click", "#delete_member_confirm_modal-btn-yes", function(){
        callback(true, data);
        $("#delete_member_confirm_modal").modal('hide');
      });
      
      $("body").on("click", "#delete_member_confirm_modal-btn-no", function(){
          callback(false, data);
        $("#delete_member_confirm_modal").modal('hide');
      });
    }

    deleteMemberConfirmModal(function(confirm, data) {
        if(confirm) {
            console.log($(this).attr("data-res"));
            $.ajax({
                method: "POST",
                url: "/reservations/delete_res_member",
                data: data
            }).done(function(response){
                msg = JSON.parse(response);
                if(msg.error) {
                    $("#del_error_msg").html(msg.error);
                } else {
                    location.reload();
                }
            })        
        } else {
            return false;
        }
    })


//=============================================================================================
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
        location.reload();
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
            $("#show_errors").addClass("alert alert-danger");
        }
        if(msg.success) {
            window.location.href = "/reservations/meetings/"+msg.success;
        }
    })
})
//=============================================================================================
//confirm delete reservation

var deleteReservationConfirmModal = function(callback) {
    
    $("body").on('click', '#del_res_btn', function(e) {
        e.preventDefault();
        delete_url = this.href;
        $("#delete_reservation_confirm_modal").modal("show");
        $("#delete_reservation_confirm_modal-body").html(
            "Are you sure you want to cancel this meeting?"
        )
    });

    $("body").on("click", "#delete_reservation_confirm_modal-btn-yes", function(){
        callback(true);
        $("#delete_reservation_confirm_modal").modal('hide');
      });
      
      $("body").on("click", "#delete_reservation_confirm_modal-btn-no", function(){
          callback(false);
        $("#delete_reservation_confirm_modal").modal('hide');
      });
    }

    deleteReservationConfirmModal(function(confirm) {
        if(confirm == false) {
            return false;
        } else {
            window.location = delete_url;
        }
    })


//========================================================================================
//submit equipment update form

var confirmEquipUpdate = function(callback){
  
    $("#update_equipment_submit").on("click", function(e){
        e.preventDefault();
      $("#update_equipment_modal").modal('show');
      $("#modal-body").html(
        "Start: "+$("#update_item_datetime_start").val()+
        "<br>End: "+$("#update_item_datetime_end").val()+
        "<br> Description: "+$("#reservation_description").val())
    });
  
    $("#modal-btn-yes").on("click", function(){
      callback(true);
      $("#update_equipment_modal").modal('hide');
    });
    
    $("#modal-btn-no").on("click", function(){
      callback(false);
      $("#update_equipment_modal").modal('hide');
    });
};
  
confirmEquipUpdate(function(confirm){
    if(confirm){
        $.ajax({
            method: "POST",
            url: "/reservations/update_equipment",
            data: {
                start_time : $("#update_item_datetime_start").val(),
                end_time :  $("#update_item_datetime_end").val(),
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
    } else {
        return false;
    }
});
//============================================================================================
//confirm delete equipment reservation
var deleteEquipReservationConfirmModal = function(callback) {

    $("body").on('click', '#delete_equip_btn', function(e) {
    delete_equip_url = this.href;
    console.log(delete_equip_url)
    e.preventDefault();
    $("#delete_equip_reservation_confirm_modal").modal("show");
    $("#delete_equip_reservation_confirm_modal-body").html(
        "Are you sure you want to remove this item from reservations?"
    )
});

$("body").on("click", "#delete_equip_reservation_confirm_modal-btn-yes", function(){
    callback(true);
    $("#delete_equip_reservation_confirm_modal").modal('hide');
  });
  
  $("body").on("click", "#delete_equip_reservation_confirm_modal-btn-no", function(){
      callback(false);
    $("#delete_equip_reservation_confirm_modal").modal('hide');
  });
}

deleteEquipReservationConfirmModal(function(confirm) {
    if(confirm == false) {
        return false;
    } else {
        window.location = delete_equip_url;
    }
})

//===========================================================================================
//edit member notifications checkboxes for specific reservation

$(".notify").change(function(){
    if($(this).is(":checked")) {
        value = 1;
    } else {
        value = 0;
    }
    $.ajax({
        method: "POST",
        url: "/reservations/change_member_notifications",
        data: {
            column: $(this).attr("name"),
            value: value,
            user_id: $(this).attr("data-user"),
            res_id: $(this).attr("data-res")
        }
    }).done(function(response){
        console.log(response);
    })
})

