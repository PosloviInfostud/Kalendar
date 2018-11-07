//Load DataTable
    $(document).ready( function () {
        $('.table').DataTable();
    } );

//==============================================================================
/* CONFERENCE ROOMS */

//Show and Hide Add New Room Modal
$("body").on('click','#show_add_new_room_modal', function(){
    $("#addNewRoomModal").show('slow');
})
$("body").on('click','#close-modal, #cancel-modal', function(){
    $("#addNewRoomModal").hide('slow');
})

// Add new conference room
$("body").on('click', "#new_room_btn", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/insert_room",
        data: {
            "name" : $("#room_name").val(),
            "capacity" : $("#room_capacity").val(),
            "description" : $("#room_description").val(),
            "color" : $("#room_color").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $('#addNewRoomModal').hide();
            location.reload();
        } else {
            $("#insert_error_msg").html(response);
        }
    })
})

// Load conference room edit modal
$("body").on('click', ".edit_room_modal", function() {
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
                $('#editRoomModal').show('slow');
        });
});

//Hide update room modal
$("body").on('click','#close-edit_modal, #cancel-edit_modal', function(){
    $("#editRoomModal").hide('slow');
})

// Update existing conference room
$("body").on('submit', "#update_room_form", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update_room",
        data: {
            "id" : $("#update_room_id").val(),
            "name" : $("#update_room_name").val(),
            "capacity" : $("#update_room_capacity").val(),
            "description" : $("#update_room_description").val(),
            "color" : $("#update_room_color").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("editRoomModal").hide();
            location.reload();
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})
//=========================================================================

/* EQUIPMENT */

//Show and Hide Add New Item Modal
$("body").on('click','#show_add_new_item_modal', function(){
    $("#addNewItemModal").show('slow');
})
$("body").on('click','#close-addNewItemModal, #cancel-addNewItemModal', function(){
    $("#addNewItemModal").hide('slow');

})// Add new equipment
$("body").on('click', "#new_equipment_btn", function(e) {
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
            $('#addNewItemModal').hide();
            location.reload();
        } else {
            $("#insert_error_msg").html(response);
        }
    })
})

// Load equipment edit modal
$("body").on('click', ".edit_item_btn", function() {
        $.ajax({
            method: "POST",
            url: "/items/edit_equipment",
            data: {
                "equipment_id" : $(this).attr("data-id")
            }
        })
        .done(function(response) {
                $('#edit_item_modal_body').html(response);
                // show modal
                $('#editItemModal').show('slow');
        });
});

//Hide update item modal
$("body").on('click','#close-edit_item_modal, #cancel-edit_item_modal', function(){
    $("#editItemModal").hide('slow');
})

// Update existing equipment
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
            $("editItemModal").hide();
            location.reload();
        } else {
            $("#edit_error_msg").html(response);
        }
    })
})

//================================================================================
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