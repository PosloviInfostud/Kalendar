<div class="container mt-5">
    <h1>
        My reservations
        <small class="text-muted">(pick an option below)</small>
    </h1>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <div class="row mt-5">
        <div class="col"><a href="#" class="btn btn-outline-info btn-lg btn-block btn-options" id="meetings">Meetings</a></div>
        <div class="col"><a href="#" class="btn btn-outline-info btn-lg btn-block btn-options" id="equipment">Equipment</a></div>
    </div>
    <div class="my-3" id="reservations"></div>
</div>

<script src="/js/reservations.js"></script>