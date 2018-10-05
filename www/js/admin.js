$("body").on('click', ".btn-options", function(e) {
    $(".btn-options").addClass('btn-outline-info').removeClass('btn-info');
    // $("#table").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div></div>');
})

/* VIEWS */

// Load reservations view
$("body").on('click', '#show_reservations', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_reservations"
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

$("body").on('click', '#show_items', function() {
    $.ajax({
        method: "POST",
        url: "/admin/show_items"
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
    // Set clicked button active
    $(this).addClass('btn-info').removeClass('btn-outline-info');
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

/* ITEMS */

// Add new item
$("body").on('click', "#new_item_btn", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/create",
        data: {
            "name" : $("#item_name").val(),
            "type" : $("#item_type").val(),
            "description" : $("#item_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> New item created.</div>');
            $('.modal-backdrop').remove();
        } else {
            $("#messages").html(response);
        }
    })
})

// Load item edit modal
$("body").on('click', ".item-edit", function() {
        console.log($(this).attr("data-id"));
        $.ajax({
            method: "POST",
            url: "/items/edit",
            data: {
                "item_id" : $(this).attr("data-id")
            }
        })
        .done(function(response) {
                $('#edit_item_modal_body').html(response);
    
                // show modal
                $('#editItemModal').modal('show');
        });
});

// Update exisitng item
$("body").on('submit', "#update_item_form", function(e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "/items/update",
        data: {
            "id" : $("#update_item_id").val(),
            "name" : $("#update_item_name").val(),
            "type" : $("#update_item_type").val(),
            "description" : $("#update_item_description").val()
        }
    })
    .done(function(response){
        if(response === 'success') {
            $("#table").html('<div class="alert alert-success" role="alert"><strong>Success!</strong> Item updated.</div>');
            $('.modal-backdrop').remove();
        } else {
            $("#messages").html(response);
        }
    })
    // $(this).unbind('submit');
})


/* USERS */

// Load user edit view
$("body").on('click', ".user-edit", function() {
    $.ajax({
        method: "POST",
        url: "/users/edit",
        data: {
            "user_id" : $(this).attr("data-id")
        }
    })
    .done(function(response) {
        $("#table").html(response);
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
        } else {
            $("#messages").html(response);
        }
    })
})