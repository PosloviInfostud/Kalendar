<div class="container mt-5">
    <h1>My Profile</h1>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <div class="row mt-1">
        <div class="col-2"><b>Name:</b></div>
        <div class="col-10"><?= $this->user_data['user']['name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Email:</b></div>
        <div class="col-10"><?= $this->user_data['user']['email'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Member since:</b></div>
        <div class="col-10"><?= $this->user_data['user']['created_at'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Notify me:</b></div>
            <div class="form-group">

                <div class="form-control">
                <?php if($this->user_data['user']['not_create'] == 1) { ?>
                    <input type="checkbox" class="notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> when new meeting is created
                <?php } else { ?>
                    <input type="checkbox" class="notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>"> when new meeting is created
                <?php } ?>
                </div>

                <div class="form-control">
                <?php if($this->user_data['user']['not_update'] == 1) { ?>
                    <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> when a meeting is updated or cancelled
                <?php } else { ?>
                    <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>"> when a meeting is updated or cancelled
                <?php } ?>
                </div>

                <div class="form-control">
                <?php if($this->user_data['user']['not_remind'] == 1) { ?>
                    <input type="checkbox" class="notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> to remind me meeting starts in 15 minutes
                <?php } else { ?>
                    <input type="checkbox" class="notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>"> to remind me meeting starts in 15 minutes
                <?php } ?>
                </div>
            </div>
            </div>
    </div>
</div>

<!-- Edit User Notifications -->
<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User notification change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="notify_modal_body"></div>
      </div>
    </div>
  </div>
</div>

<script src="/js/reglog.js"></script>