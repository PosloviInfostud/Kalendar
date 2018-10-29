<div class="jumbotron">
    <form id="reservation_form" action="/reservations/submit_reservation_form" method="POST">
    <?php echo validation_errors(); ?>
    <p>When is your meeting?</p>
    From
    <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center">
    <!-- <small id="start_time_err" class="form-text text-danger error_box"></small> -->
    to
    <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
    <!-- <small id="end_time_err" class="form-text text-danger error_box"></small> -->
    for
    <input type="number" name="attendants" id="attendants" step=1> people.
    <button id="search_reserved_rooms" class="btn btn-outline-info">Search</button>
    <div class="my-3"><small id="messages" class="form-text text-danger error_box"></small></div>
    <div id="free"></div>
    </form>
</div>

<script src="/js/reservations.js"></script>
