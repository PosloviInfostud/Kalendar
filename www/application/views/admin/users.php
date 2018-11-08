<div class="flex text-sm text-black pb-4 px-2 sm:px-0">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Users</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">User List</span>
</div>
<h3 class="mt-5 mb-3">List of all users</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($users)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed stripe border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Active</th>
                    <th scope="col">Registered</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user) { ?> 
                    <tr>
                        <td class="align-middle text-center"><button class="btn btn-sm btn-info user-edit" data-id="<?= $user['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                        <td class="align-middle text-center"><?= $user['name'] ?></td>
                        <td class="align-middle text-center"><?= $user['email'] ?></td>
                        <td class="align-middle text-center"><?= $user['role'] ?></td>
                        <td class="align-middle text-center"><?= $user['active'] == 1 ? 'Yes' : 'No' ?></td>
                        <td class="align-middle text-center"><?= $user['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Edit Item Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_user_modal_body"></div>
      </div>
    </div>
  </div>
</div>