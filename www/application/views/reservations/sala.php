<div class="jumbotron">
    <form class="border border-warning rounded p-3">
        From <input type="text" name="start_time" id="datetime_start" placeholder="Start Date&Time" class="text-center">
         to <input type="text" name="end_time" id="datetime_end" placeholder="End Date&Time" class="text-center">
         for <input type="number" name="attendants" id="attendants" min=2 max=50 step=1> people.
        <button id="search_reserved_offices" class="btn btn-outline-info">Search</button>
        <!-- <input type="submit" name="submit"  value="Submit"> -->
    </form>
</div>

<script src="/js/reservations.js"></script>
