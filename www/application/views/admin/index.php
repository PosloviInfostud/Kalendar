<div class="container my-5">
    <h1 class="mb-5">Admin area</h1>
    <div class="row">
        <div class="col"><button type="button" class="btn btn-block btn-outline-info btn-lg btn-options" id="show_reservations">Reservations</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info btn-lg btn-options" id="show_items">Items</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info btn-lg btn-options" id="show_users">Users</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info btn-lg btn-options" id="show_user_activites">User Activites</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info btn-lg btn-options" id="show_logs">Logs</button></div>
    </div>
    <div class="row my-4 hide" id="rooms">
        <hr>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info sub-options" id="show_room_res">Conference Room Reservations</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info sub-options" id="show_equipment_res">Equipment Reservations</button></div>
    </div>
    <div class="row my-4 hide" id="items">
        <div class="col"><button type="button" class="btn btn-block btn-outline-info sub-options" id="show_rooms">Conference Room List</button></div>
        <div class="col"><button type="button" class="btn btn-block btn-outline-info sub-options" id="show_equipment">Equipment List</button></div>
    </div>

    <div class="my-3" id="message"></div>
    <div class="my-3" id="table"></div>
</div>
<script src="/js/admin.js"></script>