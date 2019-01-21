$("#phone_menu_btn").on("click", function () {
    $("#secondary_nav").slideToggle();
});

$("#load-modal, #close-modal").on('click', function () {
    $("#modal").toggle('slow');
});

$("#close_alert").on('click', function () {
    $("#flash_alert_box").toggle('slow');
});

// Show register form
$('*[data-link="register"]').click(function () {
    $("#messages").empty();
    $('*[data-section="login"]').addClass("hidden");
    $('*[data-section="forgot"]').addClass("hidden");
    $('*[data-section="register"]').removeClass("hidden");
});

// Show login form
$('*[data-link="login"]').click(function () {
    $("#messages").empty();
    $('*[data-section="register"]').addClass("hidden");
    $('*[data-section="forgot"]').addClass("hidden");
    $('*[data-section="login"]').removeClass("hidden");
});

// Show forgot password form
$('*[data-link="forgot"]').click(function () {
    $("#messages").empty();
    $('*[data-section="register"]').addClass("hidden");
    $('*[data-section="login"]').addClass("hidden");
    $('*[data-section="forgot"]').removeClass("hidden");
});
