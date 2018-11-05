// Close modal
$(".close-modal").on('click', function() {
    $(".modal").hide('slow');
 });
 
 // Close alert box (error messages)
 $("#close_alert").on('click', function() {
    $("#alert_box").hide('slow');
});

//send ajax search request for free rooms
$("#search_reserved_rooms").click(function(e){
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
        if(response['status'] == 'success') {
            $('#form_errors').empty();
            $('#free').html(response['message']);
            $('#free').show();
        } else {
            $('#form_errors').html(response['errors']);
        }
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
$("#room_select").change(function(e){
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
        data.frequency = $("#res_frequency").val();
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
        data.frequency = $("#res_frequency").val();
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
    }).done(function(response){
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
        $('#editUserRoleModal').show("slow");    
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
        $("#delete_member_confirm_modal").show("slow");
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
        $('#addMemberModal').show('slow');   
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
//===========================================================================
//reload calendar after different room selected

var room = 0;
$("#update_room_select").change(function(e) {
    room = $(".select_room option:selected").val();
    $.getJSON("/calendar/get_json_for_room/"+room, function(data) {
        current_reservations = data;
        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('addEventSource', current_reservations);  
        background = data.color;       
        $('#calendar').fullCalendar('rerenderEvents');
    });
})
//submit reservation update form

$("#form_update_room_reservation").submit(function(e){
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/update_room_reservation",
        data: {
            default_start_time : $("#default_datetime_start").val(),
            default_end_time : $("#default_datetime_end").val(),
            start_time : $("#datetime_start").val(),
            end_time :  $("#datetime_end").val(),
            room : $(".select_room option:selected").val(),
            title : $("#reservation_name").val(),
            description : $("#reservation_description").val(),
            update_all : $("#update_all_child_reservations").is(":checked"),
            res : $("#res").val(),
            parent : $("#parent").val()
        }
    })
    .done(function(response){
        console.log(response);
        msg = JSON.parse(response);
        console.log(msg);
        if (msg.error) {
            $("#messages").html(msg.error);
            $("#alert_box").show();
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
        $("#delete_reservation_confirm_modal").show("slow");
        $("#delete_reservation_confirm_modal-body").html(
            "Are you sure you want to cancel this meeting?"
        );
    });

    $("body").on('click', '#del_all_res_btn', function(e) {
        e.preventDefault();
        delete_url = this.href;
        $("#delete_reservation_confirm_modal").show("slow");
        $("#delete_reservation_confirm_modal-body").html(
            "Are you sure you want to cancel ALL the reservations of this recurring event?"
        );
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

