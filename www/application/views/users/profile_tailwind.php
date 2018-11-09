<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 mb-3 sm:px-0">
        <span>Users</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">Profile</span>
    </div>

        <!-- Content -->
        <div class="bg-white border-x sm:border-y sm:rounded shadow p-4 sm:p-8">
        <!-- Title -->
        <div class="flex flex-inline mb-6">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Moj profil</h1>
        </div>
        <!-- Buttons -->
        <div class="flex flex-inline">
                <button class="user-edit cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-normal text-sm py-1 px-2 rounded" data-id="<?= $this->user_data['user']['id'] ?>">Edit</button>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 p-4 sm:p-8">
    <div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Name:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['name'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Email:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['email'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Member since:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['created_at'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Notify me:</b></div>
            <div class="xs:w-3/4">
                <div class="mb-1">
                    <?php if($this->user_data['user']['not_create'] == 1) { ?>
                        <input type="checkbox" class="notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> when new meeting is created
                    <?php } else { ?>
                        <input type="checkbox" class="notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>"> when new meeting is created
                    <?php } ?>
                </div>
                <div class="mb-1">
                    <?php if($this->user_data['user']['not_update'] == 1) { ?>
                        <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> when a meeting is updated or cancelled
                    <?php } else { ?>
                        <input type="checkbox" class="notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>"> when a meeting is updated or cancelled
                    <?php } ?>
                </div>
                <div class="mb-1">
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
</div>