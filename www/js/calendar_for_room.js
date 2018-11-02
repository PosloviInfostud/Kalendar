    var start_time = "";
    var end_time = "";
    
    $(document).ready(function() {
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
        slotDuration: "00:30:00",
        
        contentHeight: "auto",
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'agendaDay, agendaWeek, listDay, listWeek, listMonth'
        },
        views: {
            listDay: {buttonText: 'list day'},
            listDayFormat: (room) => event.room,
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
                    start: start.format("YYYY-MM-DD HH:mm"),
                    end: end.format("YYYY/DD/MM HH:mm")
                    // ,
                    // room: room
                };
                $calendar.fullCalendar("renderEvent", jsEvent, true);
                saveEvent(event);
                $("#datetime_start").attr("value", event.start);
                $("#datetime_start").text(event.start);
                $("#datetime_start").val(event.start);
                $("#datetime_start").jumpToDate(event.start);
                // fpRoomStartDate.set("defaultDate", event.start);
                end_time = event.end;
                console.log(start_time);
                //display en event

            }
        },
        //make events editable, globally
        editable: true,
        //callback triggered wehen we click on the event
        eventClick: function(event, jsEvent, view) {
            //ask for a title
            window.location.href = '/reservations/meetings/'+event.id;
            // if the cancel button isn't pressed
            // if(newTitle != null) {
            //     event.title = newTitle.trim() != "" ? newTitle: event.title;
            //     //call the "updateEvent" method
            //     $calendar.fullCalendar("updateEvent", event);
            // }
        },
        viewRender: function (view, viewContainer){
            // Clear background image if still lingering
            $(".fc-view-container").addClass("bg-white");
        },
        //delete link
        eventRender: function(event, element) {
            $(element).find(".fc-content").append("<div style='float-right'><a href='javascript:remove_event("+event.id+")' class='delete-link'>Delete</a></div>");
            $(element).find('.delete-link').click(function(e) {
                e.stopImmediatePropagation()
            })
        },
        eventAfterAllRender : function( view ) {
		    if (view.type == 'listWeek') {
			console.log(view.type + ' change colspan');
			console.log(view)
			var tableSubHeaders = jQuery("td.fc-widget-header");
			console.log(tableSubHeaders);
			var numberOfColumnsItem = jQuery('tr.fc-list-item');
			var maxCol = 0;
			var arrayLength = numberOfColumnsItem.length;
			for (var i = 0; i < arrayLength; i++) {
			    maxCol = Math.max(maxCol,numberOfColumnsItem[i].children.length);
			}
			console.log("number of items : " + maxCol);
			tableSubHeaders.attr("colspan",maxCol);
                    }		    
		},

        eventSources: [
            {
                color: background,   
                textColor: '#000000',
                events: current_reservations
            }
        ]
    })
});
//removes event
function remove_event(id) {
    var remove = confirm("remove event id"+id+"?");
    if (remove == true) {
        $("#calendar").fullCalendar("removeEvents", id);
    }
}
function saveEvent(event)
{
    console.log(event);
    $.ajax({
        method: "POST",
        url: "/calendar/save_test",
        data: {
            "start_time" : event.start,
            "end_time" :event.end,
            "title" : event.title
        }
    }).done(function(response){
        console.log(response);
    })
}