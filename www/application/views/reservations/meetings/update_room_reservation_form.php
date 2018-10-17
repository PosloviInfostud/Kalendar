<h2 class="text-center p-2">Update reservation "<?= $meeting['title'] ?>"</h2>
<div class="jumbotron">
    <form id="form_update_room_reservation">

        <div class="form-group col-9">
            <label for="room">Select Room</label>
            <select name="room" id="room_select" class="js-example-basic-single form-control select_room text-center">
                <?php foreach ($rooms as $room) { ?>
                    <?php if($room['id'] == $meeting['room_id']) { ?>
                        <option value="<?= $room['id']; ?>" selected><?= $room['name']; ?></option>
                    <? } else { ?>
                        <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
                <?php }
                 } ?>
            </select>
        </div>

        <div class="form-froup">
            <p>When?</p>
            From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center" value="<?= $meeting['starttime'] ?>"> 
            to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center" value="<?= $meeting['endtime'] ?>">
        </div>

        <div class="form-group">
            <label for="title">What is the Name od the Event?</label>
            <input type="text" class="form-control" name="title" id="reservation_name" value="<?= $meeting['title'] ?>">
        </div>
                
        <div class="form-group">
            <label for="description">Describe it to the Attendants</label>
            <textarea class="form-control" name="description" id="reservation_description"><?= $meeting['description'] ?></textarea>
        </div>

        <div class="form-group">
            <p>Current members</p>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($members as $member) { ?>
                    <tr>
                    <th scope="row"><?= $i ?></th>
                    <td class="text-center"><?= $member['name'] ?></td>
                    <td><?= $member['email'] ?></td>
                    <td><?= $member['role'] ?></td>
                    <td><button class="btn btn-info btn-sm float-right mx-1 role_edit" data-roleid="<?= $member['res_role_id'] ?>"  data-rolename="<?= $member['role'] ?>"data-name="<?= $member['name'] ?>" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>"><i class="fas fa-marker"></i></button></td>
                    <td><button class="btn btn-danger btn-sm float-left mx-1 member_delete" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>" data-creator="<?= $meeting['creator_id'] ?>"><i class="fas fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $i++; } ?> 

                </tbody>
            </table>
        </div>
        <!-- Delete Reservation Member Errors -->
        <div id="del_error_msg" class="text-danger"></div>
        <div class="form-group">
            <button class="btn btn-info float-right mx-4 my-2" data-toggle="modal" data-target="#addNewMember"><i class="fas fa-plus-circle mr-1"></i> Add new member</button>
        </div>

        <input type="submit" name="submit" id="form_update_room_reservation_submit" class="btn btn-block btn-success" value="Update">

    </form>
</div>
<!-- Edit User Role -->
<div class="modal fade" id="editUserRoleModal" tabindex="-1" role="dialog" aria-labelledby="editUserRoleModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit user role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_user_role_modal_body"></div>
      </div>
    </div>
  </div>
</div>


<?php
echo "<br>Current reservation: "; var_dump($meeting); 
echo "<br>Reservation Members: "; var_dump($members);
echo "<br>Admin: "; var_dump($user_id);
?>
<script src="/js/reservations.js"></script>