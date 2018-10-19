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
</div>