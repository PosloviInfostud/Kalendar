$(document).ready(function() {

    var $calendar = $('#calendar').fullCalendar({
        defaultView: "month",
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
            right: 'agendaWeek, month, listWeek, listMonth'
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
                    end: end,
                    room: room
                };
                //display en event
                $calendar.fullCalendar("renderEvent", event, true);

            }
        },
        //make events editable, globally
        editable: true,
        //callback triggered wehen we click on the event
        eventClick: function(event, jsEvent, view) {
            window.location.href = '/reservations/equipment/'+event.id;
        },
        viewRender: function (view, viewContainer){
            // Clear background image if still lingering
            $(".fc-view-container").addClass("bg-white");
        },
        eventRender: function(event, element) {
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

        eventSources: sources
    })
});