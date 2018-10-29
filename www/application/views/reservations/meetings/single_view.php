<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <div>
            <h1>
            <?= $meeting['title'] ?>
            <small class="text-muted">(<?= $meeting['status'] ?>)</small>
            </h1>
        </div>
        <div>
            <?php if (in_array($user_id, $editors)) { ?>
            <a href="/reservations/meetings/edit/<?= $meeting['id'] ?>"><button class="btn btn-info">Edit</button></a>
            <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn"><button class="btn btn-danger ml-2">Delete</button></a>
            <?php } ?>
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
        <div class="col-2"><b>Recurring:</b></div>
        <div class="col-10"><?= ($meeting['recurring'] == 0) ? 'No' : 'Yes' ?> (<?= $meeting['frequency_name'] ?>)</div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Description:</b></div>
        <div class="col-10"><?= (empty($meeting['description'])) ? 'No description' : $meeting['description'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Notify me:</b></div>
            <div class="form-group">

                <div class="form-control">
                <?php if($notify['update'] == 1) { ?>
                    <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" checked="checked"> when a meeting is updated or cancelled
                <?php } else { ?>
                    <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" > when a meeting is updated or cancelled
                <?php } ?>
                </div>

                <div class="form-control">
                <?php if($notify['remind'] == 1) { ?>
                    <input type="checkbox" class="notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" checked="checked"> to remind me meeting starts in 15 minutes
                <?php } else { ?>
                    <input type="checkbox" class="notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>"> to remind me meeting starts in 15 minutes
                <?php } ?>
                </div>
            </div>
        </div>
    <hr>
    <div class="row mt-1">
        <div>
            <h3>Current members</h3>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th colspan="2"></th>
                </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($members as $member) { ?>
                    <tr>
                    <th scope="row"><?= $i ?></th>
                    <td class="text-center"><?= $member['name'] ?></td>
                    <td><?= $member['email'] ?></td>

                    <!-- If user is an editor, he can edit roles for other members -->
                    <?php if (in_array($user_id, $editors)) {  ?>

                    <!-- Check who is creator of the reservation and unabling his update or deletion -->
                    <?php if($meeting['creator_id'] != $member['user_id']) { ?>
                        <td><?= $member['role'] ?></td>
                        <td><button class="btn btn-info btn-sm float-right mx-1 role_edit" data-roleid="<?= $member['res_role_id'] ?>"  data-rolename="<?= $member['role'] ?>"data-name="<?= $member['name'] ?>" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>"  data-creator="<?= $meeting['creator_id'] ?>"><i class="fas fa-marker"></i></button></td>
                        <td><button class="btn btn-danger btn-sm float-left mx-1 member_delete" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>" data-creator="<?= $meeting['creator_id'] ?>"><i class="fas fa-minus-circle"></i></button></td>
                    <?php }  else { ?>
                        <td colspan="3" class="text-center">CREATOR (cannot be updated or deleted)</td>
                    <?php } ?>

                    <?php } else { ?>
                    <td><?= $member['role'] ?></td>
                    <td colspan="2"></td>

                    <?php } ?> 
                    </tr>
                    <?php $i++; } ?> 

                </tbody>
            </table>

            <!-- Delete Reservation Member Errors -->
            <div id="del_error_msg" class="text-danger"></div>
            <!-- If user is an editor, he can add new members -->
            <?php if (in_array($user_id, $editors)) { ?>
            <button id="btn_add_new_member" class="btn btn-info float-right mx-4 my-2" data-toggle="modal" data-target="#addNewMember" data-res="<?= $meeting['id'] ?>"><i class="fas fa-plus-circle mr-1"></i> Add new member</button>
            <?php } ?>
        </div>
    </div>
<?php if($meeting['recurring'] == 1) { ?>
    <hr>
    <div class="mb-3">
    <h2>Upcoming dates</h2>
    <ul>
    <?php foreach($child_dates as $date) { ?>
        <li><?= $date['start_time'] ?> <a href="/reservations/meetings/<?= $date['id'] ?>">view</a> | <a href="/reservations/meetings/update/<?= $date['id'] ?>">edit</a> | <a href="/reservations/meetings/delete/<?= $date['id'] ?>">delete</a></li>
    <?php } ?>
</div>
<?php } ?>

<div class="d-flex justify-content-end mb-3"><a href="/reservations/meetings/"><button class="btn btn-secondary">Back</button></a></div>
</div>
</div>
<script src="/js/reservations.js"></script>


<!-- MODALS -->

<!-- Edit Member Role Modal -->
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

<!-- Add New Member Modal -->
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