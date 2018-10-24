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
        <?php if ($this->user_data['user']['notify'] == 1) { ?>
            <div class="col-10">Yes
        <?php } else { ?>
            <div class="col-10">No
        <?php } ?>
                (  <button id="change_notification" data-user="<?= $this->user_data['user']['id'] ?>" data-notify="<?= $this->user_data['user']['notify'] ?>" class="btn btn-sm btn-outline-secondary">Change Mail Notification</button>  )
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