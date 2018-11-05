<div id="room_err" class=""></div>
<div class="md:flex mb-4 mt-4 md:mt-0">
    <div class="md:w-1/3 md:pr-4 mb-2 md:mb-0">
        <label class="font-normal md:font-light">Which room do you want to reserve?</label>
    </div>
    <div class="md:w-2/3">
        <?php if(empty($rooms)) { ?>
        <p>No free rooms for this time. Try again.</p>
        <?php } else {
            $i=1; 
            foreach($rooms as $room) { ?>
            <div class="py-1">
                <input type="radio" id="customRadio<?= $i; ?>" name="room" value="<?= $room['id'] ?>" enabled>
                <label for="customRadio<?= $i; ?>" class=""><?= $room['name'] ?></label>
            </div>
            <?php $i++;}
        } ?>
    </div>
</div>

<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="res_frequency" class="mr-4 font-normal md:font-light">Frequency</label>
    </div>
    <div class="md:w-2/3">
        <select id="res_frequency" class="w-full md:w-1/3 bg-grey-lighter p-2 border rounded">
            <?php foreach($frequencies as $freq) { ?>
                <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                <?php } ?>
        </select>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="title" class="mr-4 font-normal md:font-light">What is the name of the event?</label>
    </div>
    <div class="md:w-2/3">
        <input type="text" name="title" id="reservation_name" class="w-full md:w-3/4 p-3 bg-grey-lighter border rounded">
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="description" class="mr-4 font-normal md:font-light">Describe it to the attendants</label>
    </div>
    <div class="md:w-2/3">
        <textarea name="description" rows="4" id="reservation_description" class="w-full md:w-3/4 p-3 bg-grey-lighter border rounded"></textarea>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="description" class="mr-4 font-normal md:font-light">Who do you want to invite?</label>
    </div>
    <div class="md:w-2/3">
    <select class="js-example-basic-multiple w-full md:w-3/4 p-3 bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
        <?php foreach($users as $user) { ?>
            <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?>
    </select>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="hidden md:block md:w-1/3">
    </div>
    <div class="md:w-2/3">
        <input type="submit" name="submit" id="reservation_room_submit_by_date" class="cursor-pointer w-full md:w-3/4 py-2 px-2 md:px-4 bg-primary hover:bg-primary-dark text-white font-bold border-b-4 border-primary-dark rounded hover:shadow-inner" value="Create">
    </div>
</div>
<script src="/js/select2.js"></script>