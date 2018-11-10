<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 mb-3 sm:px-0">
        <span>Reservations</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Meetings</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal"><?= $meeting['title'] ?></span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
        <!-- Title -->
        <div class="flex flex-inline mb-4">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary"><?= $meeting['title'] ?></h1>
            <div class="h-5 ml-2 p-1 bg-primary text-white text-xs font-medium rounded"><?= $meeting['status'] ?></div>
        </div>
        <!-- Buttons -->
        <div class="flex flex-inline">
            <?php if (in_array($user_id, $editors) && $meeting['status'] != 'expired') { ?>
                <a href="/reservations/meetings/edit/<?= $meeting['id'] ?>">
                    <button class="hover:bg-primary text-grey text-sm hover:text-white mr-3 py-1 px-2 border-2 hover:border-primary rounded focus:outline-none">
                        Edit
                    </button>
                </a>
                <?php if($meeting['recurring'] == 1) { ?>
                    <div class="flex inline-flex">
                        <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn">
                            <button class="hover:bg-red text-grey text-sm hover:text-white mr-3 py-1 px-2 border-2 hover:border-red rounded focus:outline-none">
                                Delete
                            </button>
                        </a>
                        <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>?option=all&parent=<?= $meeting['parent'] ?>" id="del_all_res_btn">
                            <button class="hover:bg-red text-grey text-sm hover:text-white py-1 px-2 border-2 hover:border-red rounded focus:outline-none">
                                Delete All
                            </button>
                        </a>
                    </div>
                <?php } else { ?>
                    <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn">
                        <button class="hover:bg-red text-grey text-sm hover:text-white py-1 px-2 border-2 hover:border-red rounded focus:outline-none">
                            Delete
                        </button>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <!-- Reservation details -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8 mt-4">
        <div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Created by:</b></div>
                <div class="xs:w-3/4"><?= $meeting['creator_name'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Start time:</b></div>
                <div class="xs:w-3/4"><?= $meeting['start_time'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>End time:</b></div>
                <div class="xs:w-3/4"><?= $meeting['end_time'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Where:</b></div>
                <div class="xs:w-3/4"><?= $meeting['name'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Recurring:</b></div>
                <div class="xs:w-3/4"><?= ($meeting['recurring'] == 0) ? 'No' : 'Yes' ?> (<?= $meeting['frequency_name'] ?>)</div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Description:</b></div>
                <div class="xs:w-3/4"><?= (empty($meeting['description'])) ? 'No description' : $meeting['description'] ?></div>
            </div>
            <?php if($meeting['status'] != 'expired') { ?> 
            <div class="xs:flex py-1">
                <div class="xs:w-1/4"><b>Notify me:</b></div>
                <div class="xs:w-3/4">
                    <div class="mb-1">
                        <?php if($notify['update'] == 1) { ?>
                            <input type="checkbox" class="notify mr-2 leading-tight py-1" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" checked="checked"> <span class="text-sm">when a meeting is updated or cancelled</span>
                        <?php } else { ?>
                            <input type="checkbox" class="notify mr-2 leading-tight py-1" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" > <span class="text-sm">when a meeting is updated or cancelled</span>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($notify['remind'] == 1) { ?>
                            <input type="checkbox" class="notify mr-2 leading-tight" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>" checked="checked"> <span class="text-sm">to remind me meeting starts in 15 minutes</span>
                        <?php } else { ?>
                            <input type="checkbox" class="notify mr-2 leading-tight" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" data-res="<?= $meeting['id'] ?>"> <span class="test-sm">to remind me meeting starts in 15 minutes</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Members -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8 mt-4">
        <!-- Delete Reservation Member Errors -->
        <div id="del_error_msg" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-4 border-red-lighter"></div>
        <h2 class="pl-2 font-medium text-lg xs:text-xl sm:text-2xl border-l-4 border-primary">Current members</h2>
        <div class="overflow-auto">
            <table class="table-auto w-full text-center text-grey-darker text-sm mt-6">
                <thead class="font-medium uppercase text-sm border-b">
                    <tr>
                        <th class="py-2">#</th>
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($members as $member) { ?>
                        <tr>
                            <td class="px-2 py-2 text-sm"><strong><?= $i ?></strong></td>
                            <td class="px-2 py-2 text-sm"><?= $member['name'] ?></td>
                            <td class="px-2 py-2 text-sm"><?= $member['email'] ?></td>
                            <!-- If user is an editor, he can edit roles for other members -->
                            <?php if (in_array($user_id, $editors) && $meeting['status'] != 'expired') {  ?>
                            <!-- Check who is creator of the reservation and unabling his update or deletion -->
                                <?php if($meeting['creator_id'] != $member['user_id']) { ?>
                                    <td class="px-2 py-2 text-sm"><?= $member['role'] ?></td>
                                    <td class="px-2 py-2 flex flex-inline">
                                        <a href="#" class="role_edit text-grey-darker hover:text-primary mr-2 no-underline focus:outline-none" data-roleid="<?= $member['res_role_id'] ?>" data-rolename="<?= $member['role'] ?>" data-name="<?= $member['name'] ?>" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>"  data-creator="<?= $meeting['creator_id'] ?>">
                                            <div class="fill-current h-4 w-4">
                                                <?= file_get_contents("public/icons/pencil.svg") ?>
                                            </div>
                                        </a>
                                        <a href="#" class="member_delete text-grey-darker hover:text-red ml-2 no-underline focus:outline-none">
                                            <div class="fill-current h-4 w-4">
                                                <?= file_get_contents("public/icons/cross-circle.svg") ?>
                                            </div>
                                        </a>
                                    </td>
                                <?php }  else { ?>
                                    <td class="px-2 py-2 text-primary text-xs font-bold uppercase">Creator</td>
                                    <td class="px-2"></td>
                                <?php } ?>
                            <?php } else { ?>
                            <td class="px-2 py-2 text-xs"><?= $member['role'] ?></td>
                            <td class="px-2 py-2"></td>
                            <?php } ?> 
                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
        <?php if (in_array($user_id, $editors) && $meeting['status'] != 'expired') {  ?>
            <button class="w-full bg-primary-light hover:bg-primary text-white mt-4 py-2 px-4 rounded focus:outline-none" id="btn_add_new_member" data-toggle="modal" data-target="#addNewMember" data-res="<?= $meeting['id'] ?>">Add new member</button> 
        <?php } ?>       
    </div>
    <!-- Recurring events -->
    <?php if($meeting['recurring'] == 1) { ?>
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8 mt-4">
        <h2 class="pl-2 font-medium text-lg xs:text-xl sm:text-2xl border-l-4 border-primary">Recurring Events</h2>
        <div class="overflow-auto">
            <table class="w-full text-grey-darker text-center text-sm mt-6">
                <thead class="font-medium uppercase text-sm border-b">
                    <tr>
                        <th class="py-2 px-4">#</th>
                        <th class="py-2 px-4">Upcoming dates</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($child_dates as $date) { ?>
                        <tr>
                            <td class="p-2"><strong><?= $i ?></strong></td>
                            <td class="p-2"><?= $date['start_time'] ?></td>
                            <td class="flex flex-inline p-2">
                            <a class="text-grey-darker hover:text-primary mr-4 no-underline focus:outline-none" href="/reservations/meetings/<?= $date['id'] ?>">
                                <div class="fill-current h-4 w-4">
                                    <?= file_get_contents("public/icons/magnifier.svg") ?>
                                </div>
                            </a>
                            <a class="text-grey-darker hover:text-primary mr-4 no-underline focus:outline-none" href="/reservations/meetings/edit/<?= $date['id'] ?>">
                                <div class="fill-current h-4 w-4">
                                    <?= file_get_contents("public/icons/pencil.svg") ?>
                                </div>
                            </a>
                            <a class="text-grey-darker hover:text-red no-underline focus:outline-none" href="/reservations/meetings/delete/<?= $date['id'] ?>">
                                <div class="fill-current h-4 w-4">
                                    <?= file_get_contents("public/icons/cross-circle.svg") ?>
                                </div>
                            </a>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</div>

<!-- MODALS -->

<!-- Edit member role modal -->
<div class="hidden modal" id="editUserRoleModal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="edit_error_msg" class="text-xs text-red mb-2"></div>
            <div id="edit_user_role_modal_body"><!-- vews/reservations/meetings/update_user_role --></div>
        </div>
    </div>
</div>

<!-- Add new member modal -->
<div class="hidden modal" id="addMemberModal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="edit_error_msg" class="text-xs text-red mb-2"></div>
            <div id="add_member_modal_body"><!-- views/reservations/meetings/add_new_member_form --></div>
        </div>
    </div>
</div>

<!-- Delete member confirmation modal -->
<div class="hidden modal" id="delete_member_confirm_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="delete_member_confirm_modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded" id="delete_member_confirm_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-dark font-bold w-full py-2 mt-2 ml-2 border border-grey rounded" id="delete_member_confirm_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete reservation confirmation modal -->
<div class="hidden modal" id="delete_reservation_confirm_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-8 md:p-12 bg-white sm:w-1/2 md:w-1/3 max-w-smd m-auto flex-col flex rounded shadow">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="delete_reservation_confirm_modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded" id="delete_reservation_confirm_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded" id="delete_reservation_confirm_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>