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

// $("#search_")

//submit reservation form

// $("#reservation_submit").click(function(e){
//     e.preventDefault();
//     $.ajax({
//         method: "POST",
//         url: "/reservations/submit_reservation_form",
//         data: {
//             "start_time" : $("#datetime_start").val(),
//             "end_time" : $("#datetime_end").val(),
//             "item" : $("input[name='item']:checked").val(),
//             "title" : $("#reservation_name").val(),
//             "description" : $("#reservation_description").val(),
//             "members" : $("input[name='members[]']:checked").val()
//         }
//     })
//     .done(function(response){
//         console.log(response);
//     })
// })

