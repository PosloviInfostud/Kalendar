<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <div>
            <h1>
            <?= $meeting['title'] ?>
            <small class="text-muted">(<?= $meeting['status'] ?>)</small>
            </h1>
        </div>
        <div>
            <?php foreach ($members as $member) {
                if($user_id == $member['user_id'] && $member['res_role_id'] == 1) { ?>
                <a href="/reservations/update_room_reservation_form/<?= $meeting['id'] ?>"><button class="btn btn-info">Edit</button></a>
                <a href="/reservations/delete_room_reservation/<?= $meeting['id'] ?>" id="del_res_btn"><button class="btn btn-danger ml-2">Delete</button></a>
            <?php } } ?>
        </div>
    </div>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <hr>
    <div class="row mt-1">
        <div class="col-2"><b>Created by:</b></div>
        <div class="col-10"><?= $meeting['creator_name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Start Time:</b></div>
        <div class="col-10"><?= $meeting['start_time'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>End Time:</b></div>
        <div class="col-10"><?= $meeting['end_time'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Where:</b></div>
        <div class="col-10"><?= $meeting['name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Description:</b></div>
        <div class="col-10"><?= $meeting['description'] ?></div>
    </div>
    <hr>
    <div class="row mt-1">
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

                    <!-- Check who is creator of the reservation and unabling his update or deletion -->
                    <?php if($meeting['creator_id'] != $member['user_id']) { ?>
                    <td><?= $member['role'] ?></td>
                    <td><button class="btn btn-info btn-sm float-right mx-1 role_edit" data-roleid="<?= $member['res_role_id'] ?>"  data-rolename="<?= $member['role'] ?>"data-name="<?= $member['name'] ?>" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>"  data-creator="<?= $meeting['creator_id'] ?>"><i class="fas fa-marker"></i></button></td>
                    <td><button class="btn btn-danger btn-sm float-left mx-1 member_delete" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>" data-creator="<?= $meeting['creator_id'] ?>"><i class="fas fa-minus-circle"></i></button></td>
                    <?php }  else { ?>
                    <td colspan="3" class="text-center">CREATOR (cannot be updated or deleted)</td>
                    <?php } ?>
                    
                    </tr>
                    <?php $i++; } ?> 

                </tbody>
            </table>
        </div>
<!-- Delete Reservation Member Errors -->
<div id="del_error_msg" class="text-danger"></div>
<div class="form-group">
    <button id="btn_add_new_member" class="btn btn-info float-right mx-4 my-2" data-toggle="modal" data-target="#addNewMember" data-res="<?= $meeting['id'] ?>"><i class="fas fa-plus-circle mr-1"></i> Add new member</button>
</div>

<!-- Edit Member Role -->
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

<!-- Add New Member -->
<div class="modal fade" id="addMemberModal" role="dialog" aria-labelledby="addMemberModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new member to this meeting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="add_member_error_msg" class="text-danger"></small>
        <div id="add_member_modal_body"></div>
      </div>
    </div>
  </div>
</div>

</div>
<div class="d-flex justify-content-end"><a href="/reservations/meetings/"><button class="btn btn-secondary">Back</button></a></div>
<script src="/js/reservations.js"></script>