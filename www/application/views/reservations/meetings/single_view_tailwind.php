<div class="flex text-xs sm:text-sm text-black px-2 sm:px-0">
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
<div class="bg-white border-x sm:border-y sm:rounded shadow p-4 md:p-8 my-4">
    <!-- Title and buttons section -->
    <div class="smd:flex smd:items-center smd:justify-between">
        <div class="smd:w-2/3">
            <div class="flex items-top mb-4 smd:mb-0">
                <h1 class="font-normal xs:text-2xl sm:text-3xl"><?= $meeting['title'] ?></h1>
                <div class="flex flex-inline items-center h-5 ml-2 p-1 bg-primary text-white text-xs font-medium rounded"><?= $meeting['status'] ?></div>
            </div>
        </div>
        <div class="smd:w-1/3">
            <div class="flex smd:justify-end">
                <?php if (in_array($user_id, $editors)) { ?>
                    <a href="/reservations/meetings/edit/<?= $meeting['id'] ?>">
                        <button class="bg-primary hover:bg-primary-dark text-white font-bold mr-3 py-1 px-2 md:py-2 md:px-4 border-b-4 border-primary-dark rounded hover:shadow-inner">
                            Edit
                        </button>
                    </a>
                    <?php if($meeting['recurring'] == 1) { ?>
                        <div class="inline-flex">
                            <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn">
                                <button class="bg-red hover:bg-red-dark text-white font-bold border-b-4 border-r border-red-dark py-1 px-2 md:py-2 md:px-4 rounded-l">
                                    Delete
                                </button>
                            </a>
                            <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>?option=all&parent=<?= $meeting['parent'] ?>" id="del_all_res_btn">
                                <button class="bg-red hover:bg-red-dark text-white font-bold border-b-4 border-red-dark py-1 px-2 md:py-2 md:px-4 rounded-r">
                                    Delete All
                                </button>
                            </a>
                        </div>
                    <?php } else { ?>
                        <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn">
                            <button class="bg-red hover:bg-red-dark text-white font-bold mr-3 py-1 px-2 md:py-2 md:px-4 border-b-4 border-red-dark rounded hover:shadow-inner">
                                Delete
                            </button>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Reservation details -->
    <div class="md:w-1/2 mt-8 mb-8">
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>Created by:</b></div>
            <div class="xs:w-3/4"><?= $meeting['creator_name'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>Start time:</b></div>
            <div class="xs:w-3/4"><?= $meeting['start_time'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>End time:</b></div>
            <div class="xs:w-3/4"><?= $meeting['end_time'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>Where:</b></div>
            <div class="xs:w-3/4"><?= $meeting['name'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>Recurring:</b></div>
            <div class="xs:w-3/4"><?= ($meeting['recurring'] == 0) ? 'No' : 'Yes' ?> (<?= $meeting['frequency_name'] ?>)</div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
            <div class="xs:w-1/4"><b>Description:</b></div>
            <div class="xs:w-3/4"><?= (empty($meeting['description'])) ? 'No description' : $meeting['description'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2 sm:mb-0">
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
    </div>

    <div class="md:flex">
        <!-- Members -->
        <div class="md:w-2/3 md:mr-4">
            <div class="flex justify-between items-center h-12">
            <div class="flex items-center h-12">
                <h2 class="font-normal">Current members</h2>
            </div>
            </div>
    
            <table class="table-auto w-full text-center text-grey-darker text-sm">
                <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                    <tr>
                        <th class="py-2">#</th>
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="bg-grey-lightest">
                    <?php $i=1; foreach($members as $member) { ?>
                        <tr>
                            <td class="px-2 py-2 text-sm"><strong><?= $i ?></strong></td>
                            <td class="px-2 py-2 text-sm"><?= $member['name'] ?></td>
                            <td class="px-2 py-2 text-xs"><?= $member['email'] ?></td>
                            <!-- If user is an editor, he can edit roles for other members -->
                            <?php if (in_array($user_id, $editors)) {  ?>
                            <!-- Check who is creator of the reservation and unabling his update or deletion -->
                                <?php if($meeting['creator_id'] != $member['user_id']) { ?>
                                    <td class="px-2 py-2 text-xs"><?= $member['role'] ?></td>
                                    <td class="px-2 py-2">
                                        <button class="role_edit bg-primary-light py-1 px-2 text-white text-xs font-medium rounded" data-roleid="<?= $member['res_role_id'] ?>" data-rolename="<?= $member['role'] ?>" data-name="<?= $member['name'] ?>" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>"  data-creator="<?= $meeting['creator_id'] ?>">
                                            edit
                                        </button>
                                        <button class="member_delete bg-red-light py-1 px-2 text-white text-xs font-medium rounded" data-res="<?= $meeting['id'] ?>" data-user="<?= $member['user_id'] ?>" data-creator="<?= $meeting['creator_id'] ?>">
                                            x
                                        </button>
                                    </td>
                                <?php }  else { ?>
                                    <td class="px-2 py-2 text-primary text-xs font-bold">CREATOR</td>
                                    <td class="px-2"></td>
                                <?php } ?>
                            <?php } else { ?>
                            <td class="px-2 py-2 text-xs"><?= $member['role'] ?></td>
                            <td class="px-2 py-2"></td>
                            <?php } ?> 
                        </tr>
                    <?php $i++; } ?>
                         <tr>
                             <td class="px-2 py-2" colspan="5">
                                <button class="w-full bg-primary-light hover:bg-primary-dark text-white font-bold text-sm py-2 px-4 rounded" id="btn_add_new_member" data-toggle="modal" data-target="#addNewMember" data-res="<?= $meeting['id'] ?>">Add new member</button> 
                             </td>
                         </tr>       
                </tbody>
            </table>
             <!-- Delete Reservation Member Errors -->
             <div id="del_error_msg" class="text-danger"></div>
        </div>
        <!-- Recurring events -->
        <?php if($meeting['recurring'] == 1) { ?>
            <div class="mt-4 md:mt-0 md:w-1/3 md:ml-4">
                <div class="flex items-center h-12">
                    <h2 class="font-normal">Recurring events</h2>
                </div>

                <table class="table-auto w-full text-grey-darker text-sm">
                    <thead class="text-left bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                        <tr>
                            <th class="py-2 px-4">Upcoming dates</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-grey-lightest">
                        <?php foreach($child_dates as $date) { ?>
                            <tr>
                                <td class="md:w-1/2 p-2"><?= $date['start_time'] ?></td>
                                <td class="md:w-2/2 p-2">
                                <a class="no-underline" href="/reservations/meetings/<?= $date['id'] ?>">
                                    <button class="bg-primary-light py-1 px-2 text-white text-xs font-medium rounded">
                                        view
                                    </button>
                                </a>
                                <a class="no-underline" href="/reservations/meetings/update/<?= $date['id'] ?>">
                                    <button class="bg-primary-light py-1 px-2 text-white text-xs font-medium rounded">
                                        edit
                                    </button>
                                </a>
                                <a class="no-underline" href="/reservations/meetings/delete/<?= $date['id'] ?>">
                                    <button class="bg-red-light py-1 px-2 text-white text-xs font-medium rounded">
                                        x
                                    </button>
                                </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>


<!-- MODALS -->

<!-- Edit member role modal -->
<div class="hidden modal" id="editUserRoleModal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-8 md:p-12 bg-white sm:w-1/2 max-w-smd m-auto flex-col flex">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="edit_error_msg" class="text-xs text-red mb-2"></div>
            <div id="edit_user_role_modal_body"></div>
        </div>
    </div>
</div>

<!-- Add new member modal -->
<div class="hidden modal" id="addMemberModal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-8 md:p-12 bg-white sm:w-1/2 max-w-smd m-auto flex-col flex">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="edit_error_msg" class="text-xs text-red mb-2"></div>
            <div id="add_member_modal_body"></div>
        </div>
    </div>
</div>

<!-- Delete member confirmation modal -->
<div class="hidden modal" id="delete_member_confirm_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-8 md:p-12 bg-white sm:w-1/2 max-w-smd m-auto flex-col flex">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="delete_member_confirm_modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red-light hover:bg-red text-grey-darkest text-white font-bold w-full py-2 mt-2 sm:mr-2 border border-red-light rounded" id="delete_member_confirm_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 sm:ml-2 border border-grey rounded" id="delete_member_confirm_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete member confirmation modal -->
<div class="hidden modal" id="delete_reservation_confirm_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-8 md:p-12 bg-white sm:w-1/2 max-w-smd m-auto flex-col flex">
            <span class="absolute pin-t pin-b pin-r p-2 sm:p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <div id="delete_reservation_confirm_modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red-light hover:bg-red text-grey-darkest text-white font-bold w-full py-2 mt-2 sm:mr-2 border border-red-light rounded" id="delete_reservation_confirm_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 sm:ml-2 border border-grey rounded" id="delete_reservation_confirm_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>