<div id="calendar"></div>
    <div id="show_errors"><?php echo validation_errors(); ?></div>

    <div class="form-froup">
        <p>When?</p>
        From <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center"> 
        to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
    </div>

    <div class="form-group">
        <label for="res_frequency">Frequency</label>
        <select class="form-control" id="res_frequency">
            <?php foreach($frequencies as $freq) { ?>
                <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">What is the Name od the Event?</label>
        <input type="text" class="form-control" name="title" id="reservation_name">
    </div>
                
    <div class="form-group">
        <label for="description">Describe it to the Attendants</label>
        <textarea class="form-control" name="description" id="reservation_description"></textarea>
    </div>

    <div class="form-group">
        <p>Who do you want to invite?</p>

        <select class="js-example-basic-multiple form-control" name="members[]" id="members" multiple="multiple">

        <?php foreach($users as $user) { ?>
            <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?> 

        </select>
    </div>
    <input type="submit" name="submit" id="reservation_room_submit_by_room" class="btn btn-block btn-success" value="Reserve!">

            
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="room_reservation_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirm Room Reservation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div id="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="reservation_room_submit_by_room_modal-btn-yes">Yes</button>
        <button type="button" class="btn btn-default" id="reservation_room_submit_by_room_modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>      

<script src="/js/reservations.js"></script>
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2(
        {
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                var count = 0
                var existsVar = false;
                //check if there is any option already
                if($('#keywords option').length > 0){
                    $('#keywords option').each(function(){
                        if ($(this).text().toUpperCase() == term.toUpperCase()) {
                            existsVar = true
                            return false;
                        }else{
                            existsVar = false
                        }
                    });
                    if(existsVar){
                        return null;
                    }
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
                //since select has 0 options, add new without comparing
                else{
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    }
                }
            },
            maximumInputLength: 50, // only allow terms up to 50 characters long
            closeOnSelect: true
        }

    );

});</script>
<script src="/js/calendar.js"></script>
<script>
    var $calendar = $('#calendar').fullCalendar({
        defaultView: "agendaWeek",
        // Do not show Saturday/Sunday
        weekends : false,
        // Min/max time
        minTime: "08:00:00",
        maxTime: "18:00:00",
        // Uppercase H for 24-hour clock
        timeFormat: "H:mm",
        slotLabelFormat: "H:mm",
        contentHeight: "auto",
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'agendaDay, agendaWeek, listDay, listWeek, listMonth'
        },
        views: {
            listDay: {buttonText: 'list day'},
            listWeek: {buttonText: 'list week'},
            listMonth: {buttonText: 'list month'},
        },
        //make clicks and selections possible
        selectable: true,

        //callback that will be triggered when a selection is made
        select: function(start, end, jsEvent, view) {

            //ask for a title
            var title = prompt("Enter a title for this event","New event");
            if (title != null) {
                //Create event
                var event = {
                    title: title.trim() !="" ? title: "New event",
                    start: start,
                    end: end
                };
                //display en event
                $calendar.fullCalendar("renderEvent", event, true);

            }
            // alert(start.format("MM/DD/YYYY HH:mm")+" to "+end.format("MM/DD/YYYY HH:mm")+" in view "+view.name);
        },
        //make events editable, globally
        editable: true,
        //callback triggered wehen we click on the event
        eventClick: function(event, jsEvent, view) {
            //ask for a title
            var newTitle = prompt("Enter a new title for this event", event.title);
            // if the cancel button isn't pressed
            if(newTitle != null) {
                event.title = newTitle.trim() != "" ? newTitle: event.title;
                //call the "updateEvent" method
                $calendar.fullCalendar("updateEvent", event);
            }
        },
        viewRender: function (view, viewContainer){
            // Clear background image if still lingering
            $(".fc-view-container").addClass("bg-white");
        },
        //delete link
        eventRender: function(event, element) {
            $(element).find(".fc-content").append("<div style='float-right'><a href='javascript:remove_event("+event.id+")' class='delete-link'>Delete</a></div>");
            $(element).find('.delete-link').click(function(e) {
                e.stopImmediatePropagation();
            })
        },

        eventSources: [
            {
                color: '#4dc0b5',   
                textColor: '#000000',
                events: "<?php echo $calendar; ?>"
            },
            {
                color: '#fa7ea8',   
                textColor: '#000000',
                events: <?= $calendar ?>
            }
        ]
    })

//removes event
function remove_event(id) {
    var remove = confirm("remove event id"+id+"?");
    if (remove == true) {
        $("#calendar").fullCalendar("removeEvents", id);
    }
}
</script>
