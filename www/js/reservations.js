// Close modal
$(".close-modal").on("click", function() {
    $(".modal").hide("slow");
 });
 
 // Close alert box (error messages)
 $("#close_alert").on("click", function() {
    $("#alert_box").hide("slow");
});

// Load mobile menu
$("#phone_menu_btn").on("click", function () {
    $("#secondary_nav").slideToggle();
});

// Load mobile menu
$("#new_reservation").on("touchstart", function(e) {
    e.preventDefault();
    $("#new_reservation_options").slideToggle();
});

// Back to top button
$(document).ready(function() {
    var backToTop = $('#back_to_top_btn'); 
    $(window).scroll(function() {
      if ($(window).scrollTop() > 100) {
        backToTop.addClass('flex items-center justify-center');
      } else {
        backToTop.removeClass('flex items-center justify-center');
      }
    });
  
    backToTop.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  });

//send ajax search request for free rooms
$("#search_reserved_rooms").click(function(e){
    e.preventDefault();
    $(this).addClass("spinner");
    $('#form_errors').hide();
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
        $("#search_reserved_rooms").removeClass("spinner");
        if(response['status'] == 'success') {
            $("#main-container").addClass("bg-smoke-lightest").removeClass("bg-white shadow");
            $("#search_reserved_rooms").addClass("bg-primary-lighter hover:bg-primary-light").removeClass("bg-primary hover:bg-primary-dark");
            $('#free').html(response['message']);
            $('#free').show();
            // Scroll to the next section
            $("html, body").animate({scrollTop: $('#free').offset().top}, 500);
        } else {
            $('#form_errors').html(response['errors']);
            $('#form_errors').show();
        }

    })
})

//send ajax requests for equipment type needed
$("#search_equipment").click(function(e) {
    e.preventDefault();
    $(this).addClass("spinner");
    $("#form_errors").hide();
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
        $("#search_equipment").removeClass("spinner");
        msg = JSON.parse(response);
        if(msg['status'] == 'error') {
            $("#form_errors").html(msg['response']);
            $("#form_errors").show();
        } else {
            $("#rest").html(msg['response']);
            $("#rest").show();
            // Scroll to the next section
            $("html, body").animate({scrollTop: $('#rest').offset().top}, 500);
            $("#search_equipment").addClass("bg-primary-lighter hover:bg-primary-light").removeClass("bg-primary hover:bg-primary-dark shadow");
        } 
    })
})

var room;
var room_name;

// Send ajax search request for free schedule for specific room
$("#room_select").change(function(e){
    room = $(".select_room option:selected").val();
    room_name = $(".select_room option:selected").attr("data-room_name");
    $.ajax({
        method: "POST",
        url: "/reservations/load_calendar_for_room",
        data: {
            "room" : room
        }
    })
    .done(function(response){
        $("#show").html(response);
        $("#show").show();
        // Scroll to the next section
        $("html, body").animate({scrollTop: $('#show').offset().top}, 500);
    })
})

// Get value from room radio button
$("body").on("change click", "input.room_radio", function(e) {
    room = $(this).val();
    room_name = $(this).attr("data-room_name");
});

//===============================================================================
// Submit room reservation form (search by date)
    $("body").on("click", ".reservation_room_submit_by_date", function(e) {
        e.preventDefault();
        $(this).addClass("spinner");
        data = {};
        data.start_time = $("#datetime_start").val();
        data.end_time =  $("#datetime_end").val();
        data.room =  room;
        data.frequency = $("#res_frequency").val();
        data.title = $("#reservation_name").val();
        data.description = $("#reservation_description").val();
        data.members = $("#members").val();
        submit_room_reservation_by_date(data);
    });

    function submit_room_reservation_by_date(data) {
        $("#room_errors").hide();
        $.ajax({
            method: "POST",
            url: "/reservations/validate_reservation_form",
            data: data
        }).done(function(response){
            $(".reservation_room_submit_by_date").removeClass("spinner");
            msg = JSON.parse(response);
            if (msg.error) {
                $("#room_errors").html(msg.error);
                $("#room_errors").show();
                // Scroll to the error message
                $("html, body").animate({scrollTop: $('#room_errors').offset().top}, 500);
            }
            if(msg.success) {
                $("#room_reservation_modal").show("slow");
                $("#modal-body").html(
                    "<p class=\"mb-1\"><strong>Početak:</strong> " + $("#datetime_start").val() + "</p>" +
                    "<p class=\"mb-1\"><strong>Kraj:</strong> "+ $("#datetime_end").val() + "</p>" +
                    "<p class=\"mb-1\"><strong>Sala:</strong> " + room_name + "</p>" +
                    "<p class=\"mb-1\"><strong>Naziv:</strong> " + $("#reservation_name").val() + "</p>"
                );
    
                    $("body").on("click", "#reservation_room_submit_by_date_modal-btn-yes", function() {
                        $.ajax({
                            method: "POST",
                            url: "/reservations/submit_reservation_form",
                            data: data
                        }).done(function(response){
                            msg = JSON.parse(response);
                            if (msg.error) {
                                $("#room_errors").html(msg.error);
                            }
                            if(msg.success) {
                                window.location.href = "/rezervacije/sastanci";
                            }
                        })     ;
                        console.log(data);
                        $("#room_reservation_modal").hide("slow");
                    });
                
                    $("body").on("click", "#reservation_room_submit_by_date_modal-btn-no", function(){
                        $("#room_reservation_modal").hide("slow");
                    });       
            };
        })
    }
//===================================================================================================  
// Submit room reservation form (search by free room)
    $("body").on("click", ".reservation_room_submit_by_room", function(e) {
        e.preventDefault();
        $("#room_errors").hide();
        $(this).addClass("spinner");
        data = {};
        data.start_time = $("#datetime_start").val();
        data.end_time =  $("#datetime_end").val();
        data.room =  room;
        data.frequency = $("#res_frequency").val();
        data.title = $("#reservation_name").val();
        data.description = $("#reservation_description").val();
        data.members = $("#members").val();
        submit_room_reservation_by_room(data);
    });

    function submit_room_reservation_by_room(data) {
        $.ajax({
            method: "POST",
            url: "/reservations/validate_reservation_form",
            data: data
        }).done(function(response){
            $(".reservation_room_submit_by_room").removeClass("spinner");
            msg = JSON.parse(response);
            if (msg.error) {
                $("#room_errors").html(msg.error);
                $("#room_errors").show();
                $('html, body').animate({scrollTop: $("#room_errors").offset().top}, 500);
            }
            if(msg.success) {
                $("#room_reservation_modal").show("slow");
                $("#modal-body").html(
                    "<p class=\"mb-1\"><strong>Početak:</strong> " + $("#datetime_start").val() + "</p>" +
                    "<p class=\"mb-1\"><strong>Kraj:</strong> "+ $("#datetime_end").val() + "</p>" +
                    "<p class=\"mb-1\"><strong>Sala:</strong> " + room_name + "</p>" +
                    "<p class=\"mb-1\"><strong>Naziv:</strong> " + $("#reservation_name").val() + "</p>"
                );
    
                    $("body").on("click", "#reservation_room_submit_by_room_modal-btn-yes", function(){
                        $.ajax({
                            method: "POST",
                            url: "/reservations/submit_reservation_form",
                            data: data
                        }).done(function(response) {
                            msg = JSON.parse(response);
                            if (msg.error) {
                                $("#room_errors").html(msg.error);
                            }
                            if(msg.success) {
                                window.location.href = "/rezervacije/sastanci";
                            }
                        });
                        $("#room_reservation_modal").hide("slow");
                    });
                
                    $("body").on("click", "#reservation_room_submit_by_room_modal-btn-no", function(){
                        $("#room_reservation_modal").hide("slow");
                    });       
            };
        })
    }
//==============================================================================

// Send ajax search request for free schedule for specific item
$("select.select_item").change(function(e) {
    item = $(".select_item option:selected").val();
    $.ajax({
        method: "POST",
        url: "/reservations/load_calendar_for_item",
        data: {
            "equipment_id" : item
        }
    })
    .done(function(response){
        $("#show").html(response);
        $("#show").show();
    })
})

//===================================================================================
// Submit equipment reservation form (search by date)
$("body").on("click", ".reservation_equipment_submit_by_date", function(e) {
    e.preventDefault();
    $("#equipment_errors").hide();
    $(this).addClass("spinner");
    data =  {};
    data.start_time =  $("#item_datetime_start").val();
    data.end_time =  $("#item_datetime_end").val();
    data.description =  $("#reservation_description").val();
    data.equipment_id =  $(".radio_equipment_id:checked").val();
    submit_equipment_reservation_by_date(data);
});

function submit_equipment_reservation_by_date(data) {
    $.ajax({
        method: "POST",
        url: "/reservations/validate_reservation_equip_form",
        data: data
    })
    .done(function(response){
        $(".reservation_equipment_submit_by_date").removeClass("spinner");
        msg = JSON.parse(response);
        if (msg['status'] == 'error') {
            $("#equipment_errors").html(msg['response']);
            $("#equipment_errors").show();
            $('html, body').animate({scrollTop: $("#equipment_errors").offset().top}, 500);
        } 
        if (msg['status'] == 'success') {
            $("#equip_reservation_modal").show("slow");
            $("#modal-body").html(
                "<p class=\"mb-1\"><strong>Početak:</strong> " + $("#item_datetime_start").val() + "</p>" +
                "<p class=\"mb-1\"><strong>Kraj:</strong> "+ $("#item_datetime_end").val() + "</p>")

            $("body").on("click", "#reservation_equipment_submit_by_date_modal-btn-yes", function() {
                $.ajax({
                    method: "POST",
                    url: "/reservations/submit_reservation_equip_form",
                    data: data
                }).done(function(response) {
                    msg = JSON.parse(response);
                    if (msg['status'] == 'error') {
                        $("#equipment_errors").html(msg['response']);
                    }
                    if(msg['status'] == 'success') {
                        window.location.href = "/rezervacije/oprema";
                    }
                });
                $("#equip_reservation_modal").hide("slow");
            });
            $("body").on("click", "#reservation_equipment_submit_by_date_modal-btn-no", function(){
              $("#equip_reservation_modal").hide();
            });
        }
    });
}
//==========================================================================================================
// Submit equipment reservation form (search by item)

$("body").on("click", ".reservation_equipment_submit_by_item", function(e) {
    e.preventDefault();
    $(this).addClass("spinner");
    data =  {};
    data.start_time =  $("#item_datetime_start").val();
    data.end_time =  $("#item_datetime_end").val();
    data.description =  $("#reservation_description").val();
    data.equipment_id =  $(".select_item option:selected").val();
    submit_equipment_reservation_by_item(data);
});

function submit_equipment_reservation_by_item(data) {
    $("#equipment_errors").hide();
    $.ajax({
        method: "POST",
        url: "/reservations/validate_reservation_equip_form",
        data: data
    })
    .done(function(response){
        $(".reservation_equipment_submit_by_item").removeClass("spinner");
        msg = JSON.parse(response);

        if (msg['status'] == 'error') {
            $("#equipment_errors").html(msg['response']);
            $("#equipment_errors").show();
            $('html, body').animate({scrollTop: $("#equipment_errors").offset().top}, 500);
        } 
        if (msg['status'] == 'success') {
            $("#equip_reservation_modal").show("slow");
            $("#modal-body").html(
                "<p class=\"mb-1\"><strong>Početak:</strong> " + $("#item_datetime_start").val() + "</p>" +
                "<p class=\"mb-1\"><strong>Kraj:</strong> "+ $("#item_datetime_end").val() + "</p>")

            $("body").on("click", "#reservation_equipment_submit_by_item_modal-btn-yes", function() {
                $.ajax({
                    method: "POST",
                    url: "/reservations/submit_reservation_equip_form",
                    data: data
                }).done(function(response) {
                    msg = JSON.parse(response);
                    if (msg['status'] == 'error') {
                        $("#equipment_errors").html(msg['response']);
                    }
                    if(msg['status'] == 'success') {
                        window.location.href = "/rezervacije/oprema";
                    }
                });
                $("#equip_reservation_modal").hide("slow");
            });
            $("body").on("click", "#reservation_equipment_submit_by_item_modal-btn-no", function(){
              $("#equip_reservation_modal").hide();
            });
        }
    });
}

//===========================================================================================
//load update user reservation role form modal

$("body").on("click",'.role_edit', function(e) {
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
    
    $("body").on("click", '.member_delete', function(e) {
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
        $("#delete_member_confirm_modal").hide();
      });
      
      $("body").on("click", "#delete_member_confirm_modal-btn-no", function(){
          callback(false, data);
        $("#delete_member_confirm_modal").hide();
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

$("body").on("click", '#btn_add_new_member', function(e) {
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
        $('#addMemberModal').show("slow");   
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

var room;
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

// Submit reservation update form
$("#update_reservation_room").on("click", function(e) {
    console.log("clicked");
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/reservations/update_room_reservation",
        data: {
            default_start_time : $("#default_datetime_start").val(),
            default_end_time : $("#default_datetime_end").val(),
            start_time : $("#datetime_start").val(),
            end_time :  $("#datetime_end").val(),
            room : $("#update_room_select").val(),
            title : $("#reservation_name").val(),
            description : $("#reservation_description").val(),
            update_all : $("#update_all_child_reservations").is(":checked"),
            send_email_update: $("#send_email_update").is(":checked"),
            res : $("#res").val(),
            parent : $("#parent").val()
        }
    })
    .done(function(response){
        msg = JSON.parse(response);
        if (msg.error) {
            $("#form_errors").html(msg.error);
            $("#form_errors").show();
        }
        if(msg.success) {
            window.location.href = "/rezervacije/sastanci/"+msg.success;
        }
    })
})
//=============================================================================================
//confirm delete reservation

var deleteReservationConfirmModal = function(callback) {
    
    $("body").on("click", '#del_res_btn', function(e) {
        e.preventDefault();
        delete_url = this.href;
        $("#delete_reservation_confirm_modal").show("slow");
        $("#delete_reservation_confirm_modal-body").html(
            "Are you sure you want to cancel this meeting?"
        );
    });

    $("body").on("click", '#del_all_res_btn', function(e) {
        e.preventDefault();
        delete_url = this.href;
        $("#delete_reservation_confirm_modal").show("slow");
        $("#delete_reservation_confirm_modal-body").html(
            "Are you sure you want to cancel ALL the reservations of this recurring event?"
        );
    });

    $("body").on("click", "#delete_reservation_confirm_modal-btn-yes", function(){
        callback(true);
        $("#delete_reservation_confirm_modal").hide();
      });
      
      $("body").on("click", "#delete_reservation_confirm_modal-btn-no", function(){
          callback(false);
        $("#delete_reservation_confirm_modal").hide();
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
  
$(".update_equipment_submit").on("click", function(e){
    e.preventDefault();
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
            window.location.href = "/rezervacije/oprema/"+msg.success;
        }
    })
});

//============================================================================================
//confirm delete equipment reservation
var deleteEquipReservationConfirmModal = function(callback) {

    $("body").on("click", '#delete_equip_btn', function(e) {
    delete_equip_url = this.href;
    e.preventDefault();
    $("#delete_equip_reservation_confirm_modal").show("slow");
    $("#delete_equip_reservation_confirm_modal-body").html(
        "Are you sure you want to remove this item from reservations?"
    )
});

$("body").on("click", "#delete_equip_reservation_confirm_modal-btn-yes", function(){
    callback(true);
    $("#delete_equip_reservation_confirm_modal").hide();
  });
  
  $("body").on("click", "#delete_equip_reservation_confirm_modal-btn-no", function(){
      callback(false);
    $("#delete_equip_reservation_confirm_modal").hide();
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


// Edit user notifications checkboxes (in User Profile)
$(".user_notify").change(function(){
    if($(this).is(":checked")) {
        value = 1;
    } else {
        value = 0;
    }
    $.ajax({
        method: "POST",
        url: "/users/change_notifications",
        data: {
            column: $(this).attr("name"),
            value: value,
            user_id: $(this).attr("data-user")
        }
    }).done(function(response){
    })
})
