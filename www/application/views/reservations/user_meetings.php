<div class="container mt-5">
    <h1>
        My meetings
    </h1>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <div class="row p-3 mb-3 text-center align-items-center border-bottom">
        <div class="col"><strong>ID</strong></div>
        <div class="col"><strong>Status</strong></div>
        <div class="col"><strong>Where</strong></div>
        <div class="col-4">Title</div>
        <div class="col">#</div>
        <div class="col">Created by</div>
        <div class="col">When</div>
    </div>
<?php
foreach($meetings as $meeting) { ?>
    <div data-id="" class="row p-3 mb-2 text-center align-items-center text-white meeting-card <?= ($meeting['user_id'] == $meeting['creator_id']) ? 'bg-info' : 'bg-secondary' ?>">
        <div class="col"><?= $meeting['res_id'] ?></div>
        <div class="col"><?= strtotime($meeting['start_time']) < time() ? 'ongoing' : 'upcoming' ?></div>
        <div class="col"><?= $meeting['room_name'] ?></div>
        <div class="col-4"><?= $meeting['title'] ?></div>
        <div class="col"><button class="btn btn-sm btn-outline-light members-btn" data-id="<?= $meeting['res_id'] ?>">members</button></div>
        <div class="col"><?= ($meeting['user_id'] == $meeting['creator_id']) ? 'me' : $meeting['created_by'] ?></div>
        <div class="col"><?= $meeting['start_time'] ?></div>
    </div>
<?php } ?>
<div class="my-3 float-right"><a href="/reservations">Back to my reservations</a></div>
</div>

<!-- Members Modal -->
<div class="modal fade" id="MembersModal" tabindex="-1" role="dialog" aria-labelledby="MembersModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="membersModalLongTitle">Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="show_members_body"></div>
      </div>
    </div>
  </div>
</div>

<script src="/js/meetings.js"></script>