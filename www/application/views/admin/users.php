<!-- Breadcrumbs -->
<div class="flex text-sm text-black py-3 border-b mb-8">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Users</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">List of Users</span>
</div>
<!-- Content -->
<h1 class="pl-2 mb-8 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo capitalize">List of all users</h1>

<!-- Check if there are any entries in the db -->
<?php if(empty($users)) {
        echo 'No entries';
} else { ?>
        <table class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
            <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                <tr>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Active</th>
                    <th>Registered</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user) { ?> 
                    <tr>
                        <td ><button class="user-edit cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-normal text-sm py-1 px-2 rounded" data-id="<?= $user['id'] ?>">Edit</button></td>
                        <td ><?= $user['name'] ?></td>
                        <td ><?= $user['email'] ?></td>
                        <td ><?= $user['role'] ?></td>
                        <td ><?= $user['active'] == 1 ? 'Yes' : 'No' ?></td>
                        <td ><?= $user['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<div class="hidden modal" id="editUserModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-md m-auto flex-col flex rounded shadow">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="text-danger"></small>
                <div id="edit_user_modal_body">
                </div>
            </div>
        </div>
</div>