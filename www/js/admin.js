// $("body").on('click', ".btn-options", function(e) {
//     $(".btn-options, .sub-options").addClass('btn-outline-info').removeClass('btn-info');
//     $("#message, #table").html('');
//     $("#rooms, #items, #equipment").addClass('hide');
//     // $("#table").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div></div>');
// })

// $("body").on('click', ".sub-options", function(e) {
//     $(".sub-options").addClass('btn-outline-info').removeClass('btn-info');
//     $(".equip-options").addClass('btn-outline-info').removeClass('btn-info');
//     $("#equipment").addClass('hide');
// })

// $("body").on('click', ".equip-options", function(e) {
//     $(".equip-options").addClass('btn-outline-info').removeClass('btn-info');
// })

// // Choose between reservation types
// $("body").on('click', "#show_reservations", function() {
//     $("#rooms").removeClass("hide");
//     $(this).addClass('btn-info').removeClass('btn-outline-info');
// })

// // Choose between type of lists
// $("body").on('click', "#show_items", function() {
//     $("#items").removeClass("hide");
//     $(this).addClass('btn-info').removeClass('btn-outline-info');
// })

// // Choose between equipment items and types
// $("body").on('click', "#show_equipment", function() {
//     $("#equipment").removeClass("hide");
//     $(this).addClass('btn-info').removeClass('btn-outline-info');
//     $("#message, #table").html('');
// })

/* VIEWS */

// Load conference room reservations view
$("body").on('click', '#show_room_res', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_room_reservations"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

// Load equipment reservations view
$("body").on('click', '#show_equipment_res', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_equipment_reservations"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

// Load conference room list view
$("body").on('click', '#show_rooms', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_conference_rooms"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

// Load equipment list view
$("body").on('click', '#show_equip_items', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_equipment"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

$("body").on('click', '#show_users', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_users"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
})

// Load equipment types view
$("body").on('click', '#show_item_types', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_equipment_types"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

$("body").on('click', '#show_users', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_users"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
})

$("body").on('click', '#show_user_activites', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_user_activites"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

$("body").on('click', '#show_logs', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_logs"
    })
    .done(function(response) {
        // Load view
        $("#table").html(response);
        // Apply datatables on the loaded table
        $('.table').DataTable();
    });
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
})

/* CONFERENCE ROOMS */

// Add new conference room
$("body").on('click', "#new_room_btn", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/insert_room",
        data: {
            "name" : $("#room_name").val(),
            "capacity" : $("#room_capacity").val(),
            "description" : $("#room_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> New room added.</div>');
            $('#addNewRoomModal').modal('hide');
        } else {
            $("#insert_error_msg").html(response);
        }
    })
})

// Load conference room edit modal
$("body").on('click', ".room-edit", function() {
        $.ajax({
            method: "POST",
            url: "/items/edit_room",
            data: {
                "room_id" : $(this).attr("data-id")
            }
        })
        .done(function(response) {
                $('#edit_room_modal_body').html(response);
    
                // show modal
                $('#editRoomModal').modal('show');
        });
});

// Update exisitng conference room
$("body").on('submit', "#update_room_form", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update_room",
        data: {
            "id" : $("#update_room_id").val(),
            "name" : $("#update_room_name").val(),
            "capacity" : $("#update_room_capacity").val(),
            "description" : $("#update_room_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> Room updated.</div>');
            $("editRoomModal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})

/* EQUIPMENT */

// Add new equipment
$("body").on('click', "#new_equipment_btn", function(e) {
    // $("#insert_error_msg").empty();
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/insert_equipment",
        data: {
            "name" : $("#equipment_name").val(),
            "barcode" : $("#equipment_barcode").val(),
            "type" : $("#equipment_type").val(),
            "description" : $("#equipment_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> New equipment added.</div>');
            $('#addNewEquipmentModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        } else {
            $("#insert_error_msg").html(response);
        }
    })
})

// Load equipment edit modal
$("body").on('click', ".equipment-edit", function() {
        $.ajax({
            method: "POST",
            url: "/items/edit_equipment",
            data: {
                "equipment_id" : $(this).attr("data-id")
            }
        })
        .done(function(response) {
                $('#edit_equipment_modal_body').html(response);
    
                // show modal
                $('#editEquipmentModal').modal('show');
        });
});

// Update exisitng equipment
$("body").on('submit', "#update_equipment_form", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update_equipment",
        data: {
            "id" : $("#update_equipment_id").val(),
            "name" : $("#update_equipment_name").val(),
            "barcode" : $("#update_equipment_barcode").val(),
            "type" : $("#update_equipment_type").val(),
            "description" : $("#update_equipment_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> Equipment updated.</div>');
            $("editEquipmentModal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})

/* EQUIPMENT TYPE */

// Add new equipment type
$("body").on('click', "#new_type_btn", function(e) {
    // $("#insert_error_msg").empty();
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/insert_type",
        data: {
            "name" : $("#type_name").val(),
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> New type added.</div>');
            $('#addNewTypeModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        } else {
            $("#insert_error_msg").html(response);
        }
    })
})

// Load equipment type edit modal
$("body").on('click', ".type-edit", function() {
        $.ajax({
            method: "POST",
            url: "/items/edit_type",
            data: {
                "type_id" : $(this).attr("data-id")
            }
        })
        .done(function(response) {
                $('#edit_type_modal_body').html(response);
    
                // show modal
                $('#editTypeModal').modal('show');
        });
});

// Update exisitng type
$("body").on('submit', "#update_type_form", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update_type",
        data: {
            "id" : $("#update_type_id").val(),
            "name" : $("#update_type_name").val(),
            "barcode" : $("#update_type_barcode").val(),
            "type" : $("#update_type_type").val(),
            "description" : $("#update_type_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> Type updated.</div>');
            $("editTypeModal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})


/* USERS */

// Load user edit modal
$("body").on('click', ".user-edit", function() {
    $.ajax({
        method: "POST",
        url: "/users/edit",
        data: {
            "user_id" : $(this).attr("data-id")
        }
    })
    .done(function(response) {
        $('#edit_user_modal_body').html(response);
        // show modal
        $('#editUserModal').modal('show');
    });
})

// Edit exisitng user
$("body").on('submit', "#update_user", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/users/update",
        data: {
            "id" : $("#user_id").val(),
            "name" : $("#user_name").val(),
            "email" : $("#user_email").val(),
            "role_id" : $("#select_role").val(),
            "active" : $("#select_active").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> User updated.</div>');
            $('#editUserModal').modal('hide');
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})