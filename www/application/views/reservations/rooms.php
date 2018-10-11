<div class="jumbotron">
    <form id="reservation_form" class="border border-warning rounded p-3" action="/reservations/submit_reservation_form" method="POST">
    <?php echo validation_errors(); ?>
        <p>When is your meeting?</p>
        From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center">
         to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
         for <input type="number" name="attendants" id="attendants" min=2 max=50 step=1> people.
        <button id="search_reserved_offices" class="btn btn-outline-info">Search</button>
        <div id="free"></div>
    </form>
</div>

<script src="/js/reservations.js"></script>
