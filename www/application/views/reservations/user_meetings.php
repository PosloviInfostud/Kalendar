<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
    <div><h1>My meetings</h1></div>
    <div><input class="form-control" type="text" id="filter_list_input" placeholder="Search.."></div>
  </div>
  <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>


<!-- Check if there are any entries in the db -->
<?php if(empty($meetings)) {
        echo 'No reservations..';
} else { ?>

    <div class="row py-3 mb-3 text-center align-items-center border-bottom">
        <div class="col-1"><strong>#</strong></div>
        <div class="col-1"><strong>Status</strong></div>
        <div class="col-3">When</div>
        <div class="col"><strong>Where</strong></div>
        <div class="col-3">Title</div>
        <div class="col-1">Type</div>
        <div class="col-1">Created by</div>
    </div>
    <?php
    foreach($meetings as $meeting) { ?>
        <div class="reservation_boxes text-sm row py-2 mb-2 text-center align-items-center text-white meeting-card <?= ($meeting['user_id'] == $meeting['creator_id']) ? 'bg-info' : 'bg-secondary' ?>">
            <div class="col-1"><a href="/reservations/meetings/<?= $meeting['res_id'] ?>"><i class="far fa-clipboard fa-lg text-white"></i></a></div>
            <div class="col-1"><?= $meeting['status'] ?></div>
            <div class="col-3"><?= $meeting['start_time'] ?></div>
            <div class="col"><?= $meeting['room_name'] ?></div>
            <div class="col-3"><?= $meeting['title'] ?></div>
            <div class="col-1"><?= $meeting['frequency_name'] ?></div>
            <div class="col-1"><?= ($meeting['user_id'] == $meeting['creator_id']) ? 'me' : $meeting['created_by'] ?></div>
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

<?php } ?>