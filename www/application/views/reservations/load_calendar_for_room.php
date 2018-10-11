<p>/mesto za kalendar/</p>
From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center">
         to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
         <input type="hidden" name="room_id" id="room_id" value="<?= $room_id; ?>">
         <button id="search_free_termins" class="btn btn-outline-info">Search</button>
         <div id="freeornot"></div>
<script src="/js/reservations.js"></script>
